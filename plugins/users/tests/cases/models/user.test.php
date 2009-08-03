<?php
class UserModelTestCase extends CakeTestCase {
	public $fixtures = array('plugin.users.user', 'plugin.users.conversation', 'plugin.users.message', 'plugin.users.conversations_user');
	
	private $User = null;
	
	public function startTest($method) {
		parent::startTest($method);
		$this->User = ClassRegistry::init('Users.User');
	}
	
	public function testUserInstance() {
		$this->assertIsA($this->User, 'User');
	}
	
	public function testDisplayField() {
		$this->AssertEqual($this->User->displayField, 'username');
	}
	
	public function testAttachedBehaviors() {
		$this->assertTrue(in_array('Containable', $this->User->actsAs));
	}
	
	public function testUserFind() {
		$results = $this->User->find('first', array(
			'fields' => array(
				'id', 
				'group_id', 
				'username' , 
				'email', 
				'password', 
				'created', 
				'modified'
			),
			'contain' => false
		));
		$this->assertTrue(!empty($results));
		
		$expected = array(
			'User' => array(
				'id' => 1, 
				'group_id' => 100, 
				'username' => 'Phally', 
				'email' => 'phally@example.com', 
				'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 
				'created' => '2009-06-20 03:16:52', 
				'modified' => '2009-06-20 03:16:56'
			)
		);
		
		$this->assertEqual($results, $expected);
	}
}
?>