<?php
class AuthHelperTestCase extends CakeTestCase {
	
	private $Auth = null;
	
	public function startCase() {
		App::import('Helper', 'Users.Auth');
		App::import('Helper', 'Session');
		Mock::generate('SessionHelper');
	}
	
	public function startTest($method) {
		$this->Auth = new AuthHelper();
		$this->Auth->Session = new MockSessionHelper();
	}
	
	public function testHelperInstances() {
		$this->assertIsA($this->Auth, 'AuthHelper');
	}
	
	public function testLoggedOnNotSignedInUser() {
		$this->Auth->Session->setReturnValue('check', false);
		$this->Auth->Session->setReturnValue('read', null);
		$this->Auth->beforeRender();
		$this->assertFalse($this->Auth->logged());
	}
	
	public function testLoggedOnSignedInUser() {
		$this->Auth->Session->setReturnValue('check', true);
		$this->Auth->Session->setReturnValue('read', 100);
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->logged());
	}
	
	public function testVisibilityOnNotSignedInUser() {
		$this->Auth->Session->setReturnValue('check', false);
		$this->Auth->Session->setReturnValue('read', null);
		$this->Auth->beforeRender();
		$this->assertFalse($this->Auth->visible(10));
		$this->assertFalse($this->Auth->visible(50));
		$this->assertFalse($this->Auth->visible(100));
	}
	
	public function testVisibilityOnMemberUser() {
		$this->Auth->Session->setReturnValue('check', true);
		$this->Auth->Session->setReturnValue('read', 10);
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(10));
		$this->assertFalse($this->Auth->visible(50));
		$this->assertFalse($this->Auth->visible(100));
	}
	
	public function testVisibilityOnModeratorUser() {
		$this->Auth->Session->setReturnValue('check', true);
		$this->Auth->Session->setReturnValue('read', 50);	
		$this->Auth->beforeRender();
		$this->assertTrue($this->Auth->visible(10));
		$this->assertTrue($this->Auth->visible(50));
		$this->assertFalse($this->Auth->visible(100));
	}
	
	public function testVisibilityOnAdministratorUser() {
		$this->Auth->Session->setReturnValue('check', true);
		$this->Auth->Session->setReturnValue('read', 100);
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
		$this->Auth->Session->setReturnValue('check', true);
		$this->Auth->Session->setReturnValue('read', 100);
		
		$this->Auth->beforeRender();
		
		$this->Auth->Session->expect('read', array('Auth.Users'));
		$this->Auth->user();
		
		$this->Auth->Session->expect('read', array('Auth.Users.User.group_id'));
		$this->Auth->user('group_id');
		
		$this->Auth->Session->expect('read', array('Auth.Users.User.username'));
		$this->Auth->user('username');
	}
	
}
?>