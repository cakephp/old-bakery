<?php
class UserModelTestCase extends CakeTestCase {
	public $fixtures = array('plugin.users.user');
	
	private $User = null;
	
	public function startTest($method) {
		parent::startTest($method);
		$this->User = ClassRegistry::init('Users.User');
	}
	
	public function testUserInstance() {
		$this->assertIsA($this->User, 'User');
	}
	
	public function testAttachedBehaviors() {
		$this->assertTrue(in_array('Containable', $this->User->actsAs));
	}
	
	public function testUserFind() {
		$results = $this->User->find('first', array(
			'fields' => array(
				'id', 
				'group_id', 
				'realname' , 
				'username' , 
				'email', 
				'psword', 
				'email_authenticated', 
				'email_token', 
				'email_token_expires', 
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
				'realname' => 'Frank de Graaf', 
				'username' => 'Phally', 
				'email' => 'phally@example.com', 
				'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 
				'email_authenticated' => true, 
				'email_token' => null, 
				'email_token_expires' => null, 
				'created' => '2009-06-20 03:16:52', 
				'modified' => '2009-06-20 03:16:56'
			)
		);
		
		$this->assertEqual($results, $expected);
	}
}
?>