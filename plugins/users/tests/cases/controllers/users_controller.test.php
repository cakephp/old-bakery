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
		$this->Users->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Users->data = array(
			$this->Users->Auth->userModel => array(
				$this->Users->Auth->fields['username'] => 'Phally',
				$this->Users->Auth->fields['password'] => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe',
				$this->Users->Access->rememberField => 1
			)
		);
		
		$this->Users->beforeFilter();
		$this->Users->Component->startup($this->Users);
		$this->Users->Auth->login($this->Users->data);
		$this->Users->login();
		
		$result = $this->Users->Access->getRememberCookie();
		$expected = array(
			$this->Users->Auth->fields['username'] => 'Phally',
			$this->Users->Auth->fields['password'] => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe',
		);
		$this->assertEqual($result, $expected);
		
		$this->assertEqual($this->Users->Auth->user('username'), 'Phally');
		
		if (!$this->Users->Auth->loginRedirect) {
			$this->Users->Auth->loginRedirect = '/';
		}
		$this->assertEqual($this->Users->redirectUrl, $this->Users->Auth->loginRedirect);
	}
	
	public function testLogoutAction() {
		$this->Users->beforeFilter();
		
		$data = array(
			$this->Users->Auth->userModel => array(
				$this->Users->Auth->fields['username'] => 'Phally',
				$this->Users->Auth->fields['password'] => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe',
				$this->Users->Access->rememberField => 1
			)
		);
		
		$this->Users->Auth->login($data);
		$this->Users->Access->setRememberCookie($data);
		
		$this->Users->Component->startup($this->Users);
		$this->Users->logout();
		
		$this->assertNull($this->Users->Auth->user());
		$this->assertNull($this->Users->Access->getRememberCookie());
		$this->assertEqual($this->Users->redirectUrl, $this->Users->Auth->logoutRedirect);
	}
	
	public function endTest() {
		$this->Users->Session->destroy();
		$this->Users->Access->Cookie->destroy();
		unset($this->Users);
		ClassRegistry::flush();
	}
}

?>