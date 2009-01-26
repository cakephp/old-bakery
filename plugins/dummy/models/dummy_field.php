<?php
class DummyField extends DummyAppModel {
	public $name = 'DummyField';
	public $order = 'DummyField.name ASC';
	
	public $actsAs = array('Dummy.DummyData');
	
	public $useDbConfig = 'dummy';
	public $belongsTo = array(
			'DummyTable' => array(
					'className' => 'Dummy.DummyTable', 
					'foreignKey' => 'tablename'), 
			'Dummy.DummyType');
	
	public $_schema = array(
			'id' => array(
					'type' => 'integer', 
					'null' => false, 
					'default' => '', 
					'length' => 11, 
					'key' => 'primary'), 
			
			'tablename' => array(
					'type' => 'string', 
					'null' => false, 
					'default' => '', 
					'length' => 255), 
			
			'name' => array(
					'type' => 'string', 
					'null' => false, 
					'default' => '', 
					'length' => 255), 
			
			'field_type' => array(
					'type' => 'string', 
					'null' => false, 
					'default' => '', 
					'length' => 255), 
			
			'allow_null' => array(
					'type' => 'string', 
					'null' => false, 
					'default' => '', 
					'length' => 255), 
			
			'default' => '', 
			array('type' => 'string', 'null' => false, 'default' => '', 'length' => 255), 
			
			'active' => array(
					'type' => 'boolean', 
					'null' => false, 
					'default' => 1, 
					'length' => 1), 
			
			'type' => array(
					'type' => 'string', 
					'null' => true, 
					'default' => '', 
					'length' => 100), 
			
			'custom_min' => array(
					'type' => 'integer', 
					'null' => true, 
					'default' => '', 
					'length' => 11), 
			
			'custom_max' => array(
					'type' => 'integer', 
					'null' => true, 
					'default' => '', 
					'length' => 11), 
			
			'custom_variable' => array(
					'type' => 'string', 
					'null' => true, 
					'default' => '', 
					'length' => 100));
	
	private function _switchDbConfig($dbConfig) {
		$this->useDbConfig = $dbConfig;
		$db = & ConnectionManager::getDataSource($this->useDbConfig);
		$this->databaseName = $db->config['database'];
	}
	
	public function analyze($tablename = null) {
		if (!$tablename) {
			if ($this->find('count')) {
				$this->deleteAll(array(1 => 1));
			}
			$this->_switchDbConfig('default');
			$tables = $this->DummyTable->find('all', array('recursive' => -1));
			$this->_switchDbConfig('dummy');
			foreach ($tables as $table) {
				if (!$this->saveAll($this->getFields($table['DummyTable']['name']))) {
					return false;
				}
			}
			return true;
		} else {
			$table = $this->DummyTable->find('first', array(
					'conditions' => array('name' => $tablename), 
					'recursive' => -1));
			if ($table) {
				if ($this->find('count', array('conditions' => array(
						'tablename' => $tablename)))) {
					$this->deleteAll(array('tablename' => $tablename));
				}
				return $this->saveAll($this->getFields($table['DummyTable']['name']));
			}
		}
	}
	
	public function find($type = 'all', $params = array()) {
		if ($this->useTable !== false) {
			return parent::find($type, $params);
		}
		switch ($type){
			case 'first':
				return null;
			break;
			default:
			case 'all':
				if (!isset($params['conditions']['DummyField.tablename'])) {
					return null;
				}
				return $this->getFields($params['conditions']['DummyField.tablename']);
			break;
		}
	}
	
	public function fill($table) {
		$this->data = $this->find('all', array(
				'conditions' => array('DummyField.tablename' => $table)));
		$one = array();
		foreach ($this->data as $key => $row) {
			$field = $row['DummyField'];
			if (isset($field['active']) && $field['active']) {
				$one[$field['name']] = $this->generate('generate' . $field['type'], array(
						'min' => $field['custom_min'], 
						'max' => $field['custom_max'], 
						'variable' => $field['custom_variable'], 
						'default' => $field['default'], 
						'null' => $field['allow_null']));
			}
		}
		$one = $this->specialFieldsReplace($one, $this->DummyType->specialFieldRules);
		
		$ret = false;
		$this->_switchDbConfig('default');
		$modelClass = Inflector::camelize(Inflector::singularize($table));
		if (App::import('model', $modelClass)) {
			$model = ClassRegistry::init($modelClass, 'model');
		} else {
			$model = new Model(false, $table);
		}
		if ($model) {
			$model->create($one);
		//	$model->beforeValidate();
			$ret = $model->save();
		}
		if (!$ret) {
			$this->validationErrors = $model->validationErrors;
		}
		$this->_switchDbConfig('dummy');
		return $ret;
	}
	
	public function getFields($table) {
		$this->_switchDbConfig('default');
		$schema = $this->query('Describe ' . $table);
		if (!$schema) {
			return NULL;
		}
		$fields = Set::extract($schema, '{n}.COLUMNS');
		$ret = array();
		$this->_switchDbConfig('dummy');
		foreach ($fields as $key => $values) {
			$ret[$key][$this->alias] = $this->_convert($table, $values);
			$ret[$key][$this->alias]['tablename'] = $table;
			if (!isset($this->DummyTable)) {
				App::import('model', 'Dummy.DummyTable');
				$this->DummyTable = new DummyTable();
			}
			
			$tableData = $this->DummyTable->find('first', array(
					'conditions' => array('name' => $table), 
					'recursive' => -1));
			$ret[$key]['DummyTable'] = $tableData['DummyTable'];
		}
		return $ret;
	}
	
	private function _convert($table, $values) {
		$ret = array();
		$ret['name'] = $values['Field'];
		$ret['field_type'] = $values['Type'];
		if (!isset($this->DummyType)) {
			App::import('model', 'Dummy.DummyType');
			$this->DummyType = new DummyType();
		}
		$ret['allow_null'] = ($values['Null'] == 'YES');
		$ret['default'] = $values['Default'];
		$ret['custom_min'] = $ret['custom_max'] = $ret['custom_variable'] = NULL;
		if (in_array($values['Field'], array('id', 'created', 'modified', 'lft', 'rght'))) {
			$ret['active'] = false;
			$ret['type'] = 'none';
		} elseif ($values['Field'] == 'parent_id') {
			$ret['active'] = true;
			$ret['type'] = 'BelongsTo';
			$ret['custom_variable'] = $table;
		} else {
			$ret['active'] = true;
			$type = $this->DummyType->defaultType($values);
			if (is_array($type)) {
				$ret = array_merge($ret, $type);
			} else {
				$ret['type'] = $type;
			}
		}
		return $ret;
	}
	
	function getColumnType($field) {
		switch ($field) {
			case 'date' :
				return 'date';
			break;
			case 'datetime' :
				return 'datetime';
			break;
			case 'time' :
				return 'time';
			break;
			default:
				return parent::getColumnType($field);				
		}
	}
	
	function beforeSave() {
		if (isset($this->data['DummyField']['custom_min']) && is_array($this->data['DummyField']['custom_min'])) {
			$this->data['DummyField']['custom_min'] = $this->deconstruct($this->data['DummyField']['field_type'],$this->data['DummyField']['custom_min']);
		}
		if (isset($this->data['DummyField']['custom_max']) && is_array($this->data['DummyField']['custom_max'])) {
			$this->data['DummyField']['custom_max'] = $this->deconstruct($this->data['DummyField']['field_type'],$this->data['DummyField']['custom_max']);
		}
		return true;
		
	}
}
?>