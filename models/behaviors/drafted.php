<?php
/**
 * Drafted behavior. 
 * 
 * @license MIT
 * @url http://code.google.com/p/alkemann
 * @author Alexander Morland aka alkemann
 * @author Ronny Vindenes 
 * @modified 26. january 2009
 * @version 0.1
 */
class DraftedBehavior extends ModelBehavior {
	/**
	 * Behavior settings
	 * 
	 * @access public
	 * @var array
	 */
	public $settings = array();
	private $model_prefix = 'Draft__';
	private $model_primary_key = 'draft_id';
	private $suffix = '_drafts';
	/**
	 * Defaul setting values
	 *
	 * @access private
	 * @var array
	 */
	private $defaults = array('fields' => null, 'useDbConfig' => null, 'model' => false);
	
	/**
	 * Configure the behavior through the Model::actsAs property
	 *
	 * @param object $Model
	 * @param array $config
	 */
	public function setup(&$Model, $config = null) {
		if (is_array($config)) {
			$this->settings[$Model->alias] = array_merge($this->defaults, $config);
		} else {
			$this->settings[$Model->alias] = $this->defaults;
		}
		if (is_null($this->settings[$Model->alias]['fields'])) {
			$this->settings[$Model->alias]['fields'] = array();
			foreach ($Model->_schema as $field => $arr) {
				if ($arr['type'] == 'string' || $arr['type'] == 'text') {
					$this->settings[$Model->alias]['fields'][] = $field;
				}
			}
			if (empty($this->settings[$Model->alias]['fields'])) {
				$this->settings[$Model->alias]['fields'] = null;
			}
		}
		$Model->DraftModel = false;
		$this->createDraftModel($Model);
	}
	
	/**
	 * Move a draft into live table. Will delete the draf after saving.
	 *
	 * @param object $Model
	 * @param int $id
	 * @return boolean on success
	 */
	public function acceptDraft(&$Model, $id) {
		if (!$Model->hasDraft($id)) {
			return false;
		}
		$draft = $Model->DraftModel->find('first', array(
				'conditions' => array($Model->primaryKey => $id)));
		if (isset($Model->saveDraft)) {
			$draftState = $Model->saveDraft;
		}
		$Model->saveDraft = false;
		if ($Model->save($draft)) {
			return $Model->DraftModel->delete($draft[$Model->DraftModel->alias][$Model->DraftModel->primaryKey]);
		}
		if (isset($draftState)) {
			$Model->saveDraft = $draftState;
		} else {
			unset($Model->saveDraft);
		}
		return false;
	}
	
	/**
	 * Find all drafts 
	 *
	 * @param object $Model 
	 * @param int $page 
	 * @param int $limit 
	 * @return mixed either array with drafts, or true/false if id given
	 */
	public function findDrafts(&$Model, $page = 1, $limit = null) {
		$draftAlias = $this->model_prefix . $Model->alias;
		$db = ConnectionManager::getDataSource($Model->DraftModel->useDbConfig);
		$tablePrefix = $db->config['prefix'];
		$fields = array(
				$Model->alias . '.' . $Model->primaryKey, 
				$Model->alias . '.' . $Model->displayField, 
				$draftAlias . '.' . $Model->primaryKey, 
				$draftAlias . '.' . $this->model_primary_key);
		if (in_array($Model->displayField, $this->settings[$Model->alias]['fields'])) {
			$fields[] = $draftAlias . '.' . $Model->displayField;
		}
		$Model->DraftModel->alias = $draftAlias;
		$all = $Model->DraftModel->find('all', array(
				'fields' => $fields, 
				'page' => $page, 
				'limit' => $limit, 
				'joins' => array(
						array(
								'table' => '`' . $Model->tablePrefix . $Model->table . '`', 
								'alias' => $Model->alias, 
								'type' => 'LEFT', 
								'foreignKey' => false, 
								'conditions' => array(
										$Model->alias . '.' . $Model->primaryKey . ' = ' . $draftAlias . '.' . $Model->primaryKey)))));
		$Model->DraftModel->alias = $Model->alias;
		foreach ($all as $key => $value) {
			$all[$key][$Model->alias] = array_merge($value[$Model->alias], $value[$draftAlias]);
			unset($all[$key][$draftAlias]);
		}
		return $all;
	}
	
	/**
	 * Checks if model with given id is present in draft table
	 *
	 * @param object $Model
	 * @param int $id
	 * @return int 0 or 1 - consider boolean
	 */
	public function hasDraft(&$Model, $id) {
		return $Model->DraftModel->find('count', array(
				'conditions' => array($Model->primaryKey => $id)));
	}
	
	/**
	 * When a model row is deleted, this will delete locales for that Id
	 *
	 * @param object $Model
	 */
	public function afterDelete(&$Model) {
		if ($Model->DraftModel) {
			$Model->DraftModel->deleteAll(array($Model->primaryKey => $Model->id));
		}
	}
	
	/**
	 * If locale is set, assumes the result have joined locale data and will merge the results 
	 *
	 * @param object $Model
	 * @param array $result
	 * @return array modified result
	 */
	public function afterFind(&$Model, $result, $primary = false) {
		if (empty($result) || $this->findQueryType == 'count') { // !$Model->DraftModel ||
			return $result;
		}
		if (isset($Model->showDraft) && $Model->showDraft === true) {
			$draftAlias = $this->model_prefix . $Model->alias;
			foreach ($result as $key => $data) {
				if (isset($data[$draftAlias])) {
					if (!empty($data[$draftAlias][$this->model_primary_key])) {
				/*		foreach ($data[$draftAlias] as $field => $value) {
							$result[$key][$Model->alias][$field] = $value;
						}
				*/
						$result[$key][$Model->alias] = am($result[$key][$Model->alias],$data[$draftAlias]);
					} else {
						$result[$key][$Model->alias][$this->model_primary_key] = NULL;
					}
					unset($result[$key][$draftAlias]);
				}
			}
		}
		return $result;
	}
	
	/**
	 * Will save draftData if it is set in beforeSave
	 *
	 * @param object $Model
	 * @param boolean $created true if an add and false on edit
	 */
	public function afterSave(&$Model, $created) {
		if (!$Model->DraftModel) {
			return true;
		}
		if (isset($Model->draftData) && !empty($Model->draftData)) {
			$Model->DraftModel->create($Model->draftData);
			if ($created) {
				$Model->DraftModel->set($Model->primaryKey, $Model->id);
			} else {
				$exist = $Model->DraftModel->find('first', array(
						'conditions' => array($Model->primaryKey => $Model->id)));
				if (!empty($exist)) {
					$id = $exist[$Model->alias][$Model->DraftModel->primaryKey];
					$Model->DraftModel->set($Model->DraftModel->primaryKey, $id);
					$Model->DraftModel->id = $id;
				}
			}
			$Model->DraftModel->save();
			unset($Model->draftData);
		}
	
	}
	
	/**
	 * If locale is set and find type is first all or list, will join in the locales table
	 *
	 * @param object $Model
	 * @param array $query
	 * @return array $query
	 */
	function beforeFind(&$Model, $query) {
		$this->findQueryType = $Model->findQueryType;
		if (isset($Model->showDraft) && $Model->showDraft === true) {
			$draftAlias = $this->model_prefix . $Model->alias;
			$db = ConnectionManager::getDataSource($Model->DraftModel->useDbConfig);
			$tablePrefix = $db->config['prefix'];
			
			if (empty($query['fields'])) {
				$query['fields'] = array();
				$fields = array_keys($Model->_schema);
				foreach ($fields as $field) {
					$query['fields'][] = $Model->alias . '.' . $field;
				}
			
			} elseif (is_string($query['fields'])) {
				$query['fields'] = array($query['fields']);
			}
			foreach ($this->settings[$Model->alias]['fields'] as $field) {
				if (in_array($Model->alias . '.' . $field, $query['fields'])) {
					$query['fields'][] = $draftAlias . '.' . $field;
				}
			}
			$query['fields'][] = $draftAlias . '.' . $this->model_primary_key;
			$query['joins'][] = array(
					'type' => 'LEFT', 
					'alias' => $draftAlias, 
					'table' => '`' . $tablePrefix . $Model->DraftModel->table . '`', 
					'conditions' => array(
							$Model->alias . '.' . $Model->primaryKey => $db->identifier($draftAlias . '.' . $Model->primaryKey)));
		}
		return $query;
	}
	
	/**
	 * If DraftModel and locale is set, will save these fields 
	 * and allow any other fields to continue on with the save process.
	 *
	 * @param object $Model
	 * @param array $options 
	 * @return boolean true to continue save process
	 */
	public function beforeSave(&$Model, $options = array()) {
		if (!$Model->DraftModel || (isset($Model->saveDraft) && $Model->saveDraft == false)) { // !isset($Model->saveDraft) || 
			return true;
		}
		$Model->DraftModel->create();
		$Model->draftData = array();
		foreach ($this->settings[$Model->alias]['fields'] as $field) {
			if (isset($Model->data[$Model->alias][$field])) {
				$Model->draftData[$field] = $Model->data[$Model->alias][$field];
				unset($Model->data[$Model->alias][$field]);
			}
		}
		if (!empty($Model->draftData) && isset($Model->data[$Model->alias][$Model->primaryKey])) {
			$Model->draftData[$Model->primaryKey] = $Model->data[$Model->alias][$Model->primaryKey];
		}
		if (!empty($Model->draftData) && empty($Model->data[$Model->alias])) {
			$Model->DraftModel->create($Model->draftData);
			unset($Model->draftDate);
			return $Model->DraftModel->save();
		}
		return true;
	}
	
	/**
	 * creates a model to access the draft tables
	 *
	 * @param object $Model 
	 * @return object Model object for the draft table
	 */
	private function createDraftModel(&$Model) {
		if ($this->settings[$Model->alias]['useDbConfig']) {
			$dbConfig = $this->settings[$Model->alias]['useDbConfig'];
		} else {
			$dbConfig = $Model->useDbConfig;
		}
		$table = $Model->useTable . $this->suffix;
		$db = & ConnectionManager::getDataSource($dbConfig);
		$prefix = $Model->tablePrefix ? $Model->tablePrefix : $db->config['prefix'];
		$tables = $db->listSources();
		$full_table_name = $prefix . $table;
		if ($prefix && empty($db->config['prefix'])) {
			$table = $full_table_name;
		}
		if (!in_array($full_table_name, $tables)) {
			$Model->DraftModel = false;
			return false;
		}
		
		if (is_string($this->settings[$Model->alias]['model'])) {
			if (App::import('model', $this->settings[$Model->alias]['model'])) {
				$Model->DraftModel = new $this->settings[$Model->alias]['model'](false, $table, $dbConfig);
			} else {
				$Model->DraftModel = new Model(false, $table, $dbConfig);
			}
		} else {
			$Model->DraftModel = new Model(false, $table, $dbConfig);
		}
		$Model->DraftModel->alias = $Model->alias;
		$Model->DraftModel->primaryKey = $this->model_primary_key;
		return true;
	}
}
?>
