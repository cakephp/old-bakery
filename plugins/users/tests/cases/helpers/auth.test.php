<?php
App::import('Model', 'Users.Group');
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
			'group_id' => Group::ADMINS)
		);
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->logged());
	}
	
	public function testVisibilityOnNotSignedInUser() {
		$this->Auth->beforeRender();
		$this->assertFalse($this->Auth->visible(GROUP::USERS));
		$this->assertFalse($this->Auth->visible(GROUP::MODERATORS));
		$this->assertFalse($this->Auth->visible(GROUP::ADMINS));
	}
	
	public function testVisibilityOnMemberUser() {
		$this->Controller->Session->write('Auth.User', array(
			'group_id' => Group::USERS
		));
		
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(GROUP::USERS));
		$this->assertFalse($this->Auth->visible(GROUP::MODERATORS));
		$this->assertFalse($this->Auth->visible(GROUP::ADMINS));
	}
	
	public function testVisibilityOnModeratorUser() {
		$this->Controller->Session->write('Auth.User', array(
			'group_id' => Group::MODERATORS
		));
		
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(GROUP::USERS));
		$this->assertTrue($this->Auth->visible(GROUP::MODERATORS));
		$this->assertFalse($this->Auth->visible(GROUP::ADMINS));
	}
	
	public function testVisibilityOnAdministratorUser() {
		$this->Controller->Session->write('Auth.User', array(
			'group_id' => Group::ADMINS
		));
		
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(GROUP::USERS));
		$this->assertTrue($this->Auth->visible(GROUP::MODERATORS));
		$this->assertTrue($this->Auth->visible(GROUP::ADMINS));
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
			'group_id' => Group::ADMINS
		));
		
		$expected = array(
			'User' => array(
				'username' => 'Phally', 
				'group_id' => Group::ADMINS
			)
		);
		
		$result = $this->Auth->user();
		$this->assertEqual($expected, $result);
		
		$expected = Group::ADMINS;
		
		$result = $this->Auth->user('group_id');
		$this->assertEqual($expected, $result);
		
		$expected = 'Phally';
		
		$result = $this->Auth->user('username');
		$this->assertEqual($expected, $result);
	}
}
?>