<?php
class GroupModelTestCase extends CakeTestCase {
	public $fixtures = array('plugin.users.group', 'plugin.users.user');
	
	private $Group = null;
	
	public function startTest($method) {
		parent::startTest($method);
		$this->Group = ClassRegistry::init('Users.Group');
	}
	
	public function testGroupInstance() {
		$this->assertIsA($this->Group, 'Group');
	}
	
	public function testAttachedBehaviors() {
		$this->assertTrue(in_array('Containable', $this->Group->actsAs));
	}
	
	public function testHasManyUser() {
		$this->assertTrue(in_array('User', array_keys($this->Group->hasMany)));
		
		$expected = array(
			'className' => 'User', 
			'foreignKey' => 'group_id', 
			'conditions' => null, 
			'fields' => null, 
			'order' => null, 
			'limit' => null, 
			'offset' => null, 
			'dependent' => false, 
			'exclusive' => null, 
			'finderQuery' => null, 
			'counterQuery' => null
		);
		$this->assertEqual($expected, $this->Group->hasMany['User']);
		
		$expected = array(
			'Group' => array(
				'id' => 100, 
				'name' => 'Administrators'
			),
			'User' => array(
				array(
					'id' => 1, 
					'username' => 'Phally', 
					'group_id' => 100
				),
				array(
					'id' => 4, 
					'username' => 'admini', 
					'group_id' => 100
				)
			)
		);
		
		$result = $this->Group->find('first', array(
			'fields' => array(
				'id',
				'name'
			),
			'conditions' => array(
				'id' => 100
			),
			'contain' => array(
				'User' => array(
					'fields' => array(
						'User.id', 
						'User.username'
					), 
					'order' => 'User.id ASC'
				)
			)
		));
		
		$this->assertEqual($expected, $result);
	}
	
	public function testGroupConstants() {
		$this->assertTrue(defined('Group::ADMINS'));
		$this->assertTrue(defined('Group::COREDEVS'));
		$this->assertTrue(defined('Group::EDITORS'));
		$this->assertTrue(defined('Group::MODERATORS'));
		$this->assertTrue(defined('Group::AUTHORS'));
		$this->assertTrue(defined('Group::USERS'));
		$this->assertTrue(defined('Group::GUESTS'));
		
		$this->assertEqual(100, constant('Group::ADMINS'));
		$this->assertEqual(80, constant('Group::COREDEVS'));
		$this->assertEqual(60, constant('Group::EDITORS'));
		$this->assertEqual(50, constant('Group::MODERATORS'));
		$this->assertEqual(20, constant('Group::AUTHORS'));
		$this->assertEqual(10, constant('Group::USERS'));
		$this->assertEqual(0, constant('Group::GUESTS'));
	}
}
?>