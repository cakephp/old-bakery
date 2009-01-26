<?php
class DummyTable extends DummyAppModel {
	public $name = 'DummyTable';
	public $alias = 'DummyTable';
	public $displayField = 'name';
	public $primaryKey = 'name';
	public $databaseName = '';
	public $useDbConfig = 'dummy';
	
	public $hasMany = array(
			'DummyField' => array(
					'className' => 'Dummy.DummyField', 
					'foreignKey' => 'tablename'));
	
	private function _switchDbConfig($dbConfig) {
		$this->useDbConfig = $dbConfig;
		$db = & ConnectionManager::getDataSource($this->useDbConfig);
		$this->databaseName = $db->config['database'];
	}
	
	public function analyze($tablename = null) {
		if (!$tablename) {
			$tables = $this->_showTables();
			if ($this->find('count')) {
				$this->deleteAll(array(1 => 1));
			}
			return $this->saveAll($tables);
		} else {
			if ($this->find('count', array('conditions' => array('name' => 'tablename')))) {
				return $this->DummyField->analyze($tablename);
			} else {
				$tables = $this->_showTables();
				$tables = Set::extract($tables, '{n}.DummyTable.name');
				if (in_array($tablename, $tables)) {
					if (!$this->save(array('DummyTable' => array('name' => $tablename)))) {
						return false;
					}
					return $this->DummyField->analyze($tablename);
				} else {
					return false;
				}
			}
		}
		return false;
	}
	
	public function contents($tablename, $limit = 12) {
		return $this->_selectAllTable($tablename, $limit);
	}
	
	public function read($fields = array(), $id = null) {
		if ($this->useTable !== false) {
			return parent::read($fields, $id);
		}
		$this->data = $this->find('first', array('conditions' => array('name' => $this->id)));
		return $this->data;
	}
	
	public function find($type = 'all', $options = array()) {
		if ($this->useTable !== false) {
			return parent::find($type, $options);
		}
		$db = & ConnectionManager::getDataSource($this->useDbConfig);
		$this->databaseName = $db->config['database'];
		switch ($type){
			case 'first':
				if (!isset($options['conditions']['name'])) {
					return null;
				}
				$tablename = $options['conditions']['name'];
				$active = true;
				if (in_array($tablename, array('logs', 'users'))) {
					$active = false;
				}
				$data = array(
						'DummyTable' => array('name' => $tablename, 'active' => $active));
				if (!isset($options['recursive']) || $options['recursive'] < 0) {
					return $data;
				}
				App::import('model', 'Dummy.DummyField');
				$this->DummyField = new DummyField();
				$data['DummyField'] = $this->DummyField->getFields($tablename);
				if ($options['recursive'] < 1) {
					return $data;
				}
				$data['Table']['contents'] = $this->_selectAllTable($options['table']);
				return $data;
			break;
			case 'all':
				$tables = $this->_showTables();
				if (!isset($options['recursive']) || $options['recursive'] < 0) {
					return $tables;
				}
				$tables = $this->_describeTables($tables);
				return $tables;
			break;
			default:
				return null;
		}
	}
	
	private function _showTables() {
		$this->_switchDbConfig('default');
		$result = $this->query('SHOW TABLES;');
		$result = Set::extract($result, '{n}.TABLE_NAMES.Tables_in_' . $this->databaseName);
		$ret = array();
		foreach ($result as $key => $one) {
			if (substr($one, 0, 4) != 'dum_') {
				$ret[$key][$this->alias][$this->primaryKey] = $key + 1;
				$ret[$key][$this->alias][$this->displayField] = $one;
				$ret[$key][$this->alias]['active'] = true;
			}
			if (in_array($one, array('users', 'logs'))) {
				$ret[$key][$this->alias]['active'] = false;
			}
		}
		$this->_switchDbConfig('dummy');
		return $ret;
	}
	
	private function _describeTables($tables = null) {
		if (!$tables) {
			$tables = $this->_showTables();
		}
		foreach ($tables as $key => $one) {
			$table = $one[$this->alias][$this->displayField];
			$schema = $this->query('Describe ' . $table);
			$tables[$key]['DummyField'] = Set::extract($schema, '{n}.COLUMNS');
		}
		return $tables;
	}
	
	private function _selectAllTable($table, $limit = 12) {
		$this->_switchDbConfig('default');
		$modelClass = Inflector::camelize(Inflector::singularize($table));
		if (App::import('model', $modelClass)) {
			$model = ClassRegistry::init($modelClass, 'model');
		} else {
			$model = new Model(false, $table);
		}
		$model->alias = 'Model';
		$result = $model->find('all', array('limit' => $limit,'recursive'=>-1));
		$this->_switchDbConfig('dummy');
		return $result;
	}
	
	public function generate($table) {
		$this->DummyField = ClassRegistry::init('Dummy.DummyField', 'model');
		$number = (isset($this->data[$this->alias]['number'])) ? $this->data[$this->alias]['number'] : 10;
		$teller = 0;
		for ($i = 0; $i < $number; $i++) {
			if ($this->DummyField->fill($table)) {
				$teller++;
			}
		}
		return $teller;
	}
}
?>
