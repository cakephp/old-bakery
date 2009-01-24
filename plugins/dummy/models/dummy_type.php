<?php
class DummyType extends AppModel {
	public $name = 'DummyType';
	public $useTable = false;

	private $string_generators = array(
			'String generators' => array(
					'String' => 'String', 
					'Title' => 'Title', 
					'Firstname' => 'Firstname', 
					'Lastname' => 'Lastname', 
					'Fullname' => 'Fullname',
					'Username' => 'Username', 
					'Password' => 'Password',
					'Email' => 'Email', 
					'PhoneNumber' => 'PhoneNumber', 
					'Url' => 'Url', 
					'Color' => 'Color',
					'Filename' => 'Filename', 
					'Extension' => 'Extension',
					'Title' => 'Title', 
					'Noun' => 'Noun', 
					'Verb' => 'Verb',
					'Float' => 'Float',
					'BelongsTo' => 'BelongsTo',
					'Qoute' => 'Qoute',
			)
	 );
	
	private $number_generators = array(
			'Number generators' => array(
					'Integer' => 'Integer', 
					'TinyInt' => 'TinyInt', 
					'SmallInt' => 'SmallInt', 
					'MediumInt' => 'MediumInt', 
					'BigInt' => 'BigInt',
					'Boolean' => 'Boolean',
					'BelongsTo' => 'BelongsTo'));
	
	private $date_generators = array(
			'Date generators' => array(
				'DateTime' => 'DateTime', 
				'Date' => 'Date', 
				'Time' => 'Time', 
				'Timestamp' => 'Timestamp', 
				'Year' => 'Year', 
				'Month' => 'Month', 
				'Day' => 'Day'));
	
	public $specialFieldRules = array(
			'email' => array(
				'source'=>array('name'), 
				'generator'=>'Email',
			),
			'email' => array(
				'source'=>array('firstname','lastname'), 
				'generator'=>'Email',
				'rule' => 'combine'
			),
			'username' => array(
				'source'=>array('name','firstname'), 
				'generator'=>'Username',
				'rule' => 'one'
			),
		);

	private $_nameMatch = array(
			'username' => 'Username', 
			'password' => 'Password', 
			'name' => 'Firstname', 
			'firstname' => 'Firstname', 
			'lastname' => 'Lastname', 
			'surname' => 'Lastname', 
			'email' => 'Email', 
			'phone' => 'PhoneNumber', 
			'phonenumber' => 'PhoneNumber', 
			'fax' => 'PhoneNumber', 
			'url' => 'Url', 
			'website' => 'Url', 
			'color' => 'Color', 
			'colour' => 'Color', 
			'timestamp' => 'Timestamp', 
			'year' => 'Year', 
			'month' => 'Month', 
			'day' => 'Day', 
			'title' => 'Title', 
			'model' => 'Noun', 
			'action' => 'Verb', 
			'filename' => 'Filename', 
			'file_name' => 'Filename', 
			'extension' => 'Extension',
			'description' => 'Qoute',
			'signature' => 'Qoute',
	);
	
	private $_typeMatch = array(
			'tinyint(1)' => 'Boolean', 
			'tinyint' => 'TinyInt', 
			'varchar' => 'String', 
			'int' => 'Integer', 
			'text' => 'String', 
			'datetime' => 'DateTime', 
			'date' => 'Date', 
			'time' => 'Time', 
			'bigint' => 'BigInt', 
			'smallint' => 'SmallInt', 
			'mediumint' => 'MediumInt', 
			'float' => 'Float', 
			'double' => 'Double');
	
	public function find($type = 'all', $params = array()) {
		return $this->_records;
	}
	
	public function options() {
		$all_text = am($this->string_generators, $this->number_generators, $this->date_generators); 
		$ret = array(
				'varchar' => $all_text, 
				'text' => $all_text, 
				'blob' => $this->string_generators, 
				'date' => array('Date' => 'Date'), 				
				'datetime' => array('DateTime' => 'DateTime'),
				'time' => array('Time'=>'Time'),
				'timestamp' => array('Timestamp'=>'Timestamp'),
				'smallint' => array('SmallInt' => 'SmallInt', 
									'Boolean' => 'Boolean'),
				'int' => $this->number_generators['Number generators'],
				'mediumint' => array('MediumInt'=>'MediumInt'),
				'bigint' => array('BigInt'=>'BigInt'),
				'tinyint' => array('TinyInt'=>'TinyInt'),
				'double' => array('Double'=>'Double'),
				'float' => array('Float'=>'Float'),
		);
		
		return $ret;
	}
		
	private function _matchName($fieldName) {
		if (isset($this->_nameMatch[$fieldName])) {
			return $this->_nameMatch[$fieldName];
		}
		return null;
	}
	
	private function _matchType($fieldType) {
		if (isset($this->_typeMatch[$fieldType])) {
			return $this->_typeMatch[$fieldType];
		}
		return null;
	}
	
	public function _defaultSettings($field = array()) {
		$type = array();
		
		if (preg_match('/unsigned$/', $field['Type']) == 1) {
			$type['custom_variable'] = 'unsigned';
		}
		
		if (preg_match('/_id$/', $field['Field']) == 1) {
			$model = substr($field['Field'], 0, strlen($field['Field']) - 3);
			$type['type'] = 'BelongsTo';
			$type['custom_variable'] = Inflector::pluralize($model);
		}
		
		if ($field['Type'] == 'float') {
			$type['custom_variable'] = '%01.2f';
		}
		
		$size = array();
		if (preg_match('/^varchar\((\d*)\)/', $field['Type'], $size) == 1) {
			$type['custom_max'] = $size[1];
		}
		
		return $type;
	}
	
	public function defaultType($field = array()) {
		if (empty($field)) {
			return 'SmallInt';
		}
		
		$type['type'] = $this->_matchType($field['Type']);
		
		if (!$type['type']) {
			$pos = strpos($field['Type'], '(');
			$db_type = substr($field['Type'], 0, $pos);
			$type['type'] = $this->_matchType($db_type);
		}
		
		$nameMatch = $this->_matchName($field['Field']);
		if ($nameMatch) {
			$type['type'] = $nameMatch;
		}
		
		$type = am($type, $this->_defaultSettings($field));
		
		if (!$type['type']) {
			$type['type'] = 'SmallInt';
		}
		
		return $type;
	}
}
?>