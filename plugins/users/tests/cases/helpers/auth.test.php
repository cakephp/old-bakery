<?php
App::import('Controller', 'Users.AppController');
App::import('Helper', 'Users.Auth');
App::import('Helper', 'Session');

class FakeController extends UsersAppController { 
	public $helpers = array('Auth');
	public $uses = array();
}

class AuthHelperTestCase extends CakeTestCase {
	
	private $Controller = null;
	private $Auth = null;
	
	public function startTest($method) {
		parent::startTest($method);
		$this->Auth = new AuthHelper();
		$this->Auth->Session = new SessionHelper();
		$this->Controller = new FakeController();
		$this->Controller->constructClasses();
		$this->Controller->Session->delete('Auth.User');
	}
	
	public function testHelperInstances() {
		$this->assertIsA($this->Auth, 'AuthHelper');
		$this->assertIsA($this->Auth->Session, 'SessionHelper');
	}
	
	public function testLoggedOnNotSignedInUser() {
		$this->Auth->beforeRender();
		$this->assertFalse($this->Auth->logged());
	}
	
	public function testLoggedOnSignedInUser() {
		$this->Controller->Session->write('Auth.User', array(
			'username' => 'Phally', 
			'group_id' => 100)
		);
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->logged());
	}
	
	public function testVisibilityOnNotSignedInUser() {
		$this->Auth->beforeRender();
		$this->assertFalse($this->Auth->visible(10));
		$this->assertFalse($this->Auth->visible(50));
		$this->assertFalse($this->Auth->visible(100));
	}
	
	public function testVisibilityOnMemberUser() {
		$this->Controller->Session->write('Auth.User', array(
			'group_id' => 10
		));
		
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(10));
		$this->assertFalse($this->Auth->visible(50));
		$this->assertFalse($this->Auth->visible(100));
	}
	
	public function testVisibilityOnModeratorUser() {
		$this->Controller->Session->write('Auth.User', array(
			'group_id' => 50
		));
		
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(10));
		$this->assertTrue($this->Auth->visible(50));
		$this->assertFalse($this->Auth->visible(100));
	}
	
	public function testVisibilityOnAdministratorUser() {
		$this->Controller->Session->write('Auth.User', array(
			'group_id' => 100
		));
		
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(10));
		$this->assertTrue($this->Auth->visible(50));
		$this->assertTrue($this->Auth->visible(100));
	}
	
	public function testUserOnNotSignedInUser() {
		$expected = array();
		$result = $this->Auth->user();
		$this->assertEqual($expected, $result);
		
		$expected = array();
		$result = $this->Auth->user('group_id');
		$this->assertEqual($expected, $result);
	}
	
	public function testUserOnSignedInUser() {
		$this->Controller->Session->write('Auth.User', array(
			'username' => 'Phally', 
			'group_id' => 100
		));
		
		$expected = array(
			'User' => array(
				'username' => 'Phally', 
				'group_id' => 100
			)
		);
		
		$result = $this->Auth->user();
		$this->assertEqual($expected, $result);
		
		$expected = 100;
		
		$result = $this->Auth->user('group_id');
		$this->assertEqual($expected, $result);
		
		$expected = 'Phally';
		
		$result = $this->Auth->user('username');
		$this->assertEqual($expected, $result);
	}
}
?>