<?php
class Boat extends CakeTestModel {
	var $name = 'Boat';
	var $useTable = false;
	var $hasMany = array('Passenger');
	var $fake = array('Boat' => array('id' => 1, 'title' => 'Hey'));
	var $_schema = array(
	    'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => '',
	            'length' => 11,
	            'key' => 'primary'
	        ),
	    'title' => array(
	            'type' => 'string',
	            'null' => false,
	            'default' => '',
	            'length' => 255
	        )
	
	);
	
	function find($type = 'all', $options = array()) {
		return $this->fake; 
	}
	
}
class Passenger extends CakeTestModel {
	var $name = 'Passenger';
	var $useTable = false;
	var $belongsTo = array('Boat');
	var $fake = array('Passenger'=>array('id' => 1, 'title' => 'alkemann','boat_id'=>1));
	var $_schema = array(
	    'id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => '',
	            'length' => 11,
	            'key' => 'primary'
	        ),
	    'title' => array(
	            'type' => 'string',
	            'null' => false,
	            'default' => '',
	            'length' => 255
	        ),
	    'boat_id' => array(
	            'type' => 'integer',
	            'null' => false,
	            'default' => '',
	            'length' => 11,
	        ),
	
	);
	
	function getParent() {
		$boat_id = $this->fake[$this->alias]['boat_id'];
		return $this->Boat->find('first', array('conditions'=>array('id' => $boat_id),'recursive'=>-1));
	}
}

class UsetableCase extends CakeTestCase {
    var $Boat = NULL;
    var $Passenger = NULL;

	function start() {
		parent::start();		
		$this->Boat = ClassRegistry::init('Boat');	
		$this->Passenger = ClassRegistry::init('Passenger');	
	}	
	
	function testAssociatedTable() {
		$BoatInitialized = isset($this->Passenger->Boat);
		$this->assertTrue($BoatInitialized,' Boat is set :%s');
		if ($BoatInitialized) {
			$result = $this->Passenger->getParent();
			
			$this->assertNoErrors('Shouldnt get an error : %s');
			$expected =  array('Boat' => array('id' => 1, 'title' => 'Hey'));
			$this->assertEqual($result, $expected);
					
		}

	}
	
}
?>