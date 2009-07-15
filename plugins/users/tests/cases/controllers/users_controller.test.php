<?php
App::import('Controller', 'Users.Users');
class TestUsersController extends UsersController {
	public $redirectUrl = null;
	public $renderedAction = null;
	public $stopped = null;
	
	public $autoRender = false;
	public $uses = 'User';
	
	public function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
	
	public function render($action = null, $layout = null, $file = null) {
		$this->renderedAction = $action;
	}
	
	public function _stop($status = 0) {
		$this->stopped = $status;
	}
}

class UsersControllerTestCase extends CakeTestCase {
	private $Users = null;
	public $fixtures = array('plugin.users.user', 'plugin.users.group');
	
	public function startTest() {
		$this->Users = new TestUsersController();
		$this->Users->constructClasses();
		
		$this->Users->params = Router::parse('/');
		
		$this->Users->Component->initialize($this->Users);
		
	}
	
	public function testLoginAction() {
	}
	
	public function testLogoutAction() {
		$this->Users->beforeFilter();
		$this->Users->Access->lazyLogin('Phally');
		$this->Users->Component->startup($this->Users);
		$this->Users->logout();
		
		$this->assertNull($this->Users->Auth->user());
		$this->assertEqual($this->Users->redirectUrl, $this->Users->Auth->logoutRedirect);
	}
	
	public function endTest() {
		$this->Users->Session->destroy();
		unset($this->Users);
		ClassRegistry::flush();
	}
}

?>