<?php
App::import('Controller', 'Users.Users');
class TestUsersController extends UsersController {
	public $redirectUrl = null;
	public $renderedAction = null;
	public $stopped = null;
	public $uses = 'User';
	
	public $autoRender = false;
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->fields = array('username' => 'username', 'password' => 'password');
	}
	
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
	public $fixtures = array('plugin.users.user', 'plugin.users.message', 'plugin.users.conversation', 'plugin.users.conversations_user');
	private $config = 'test_suite_permissions.php';
	
	public function startCase() {
		$testfile = APP . 'plugins' . DS . 'users' . DS . 'tests' . DS . 'files' . DS . 'permissions.php.test';
		$configfile = APP . 'config' . DS . $this->config;
		copy($testfile, $configfile);
	}
	
	public function startTest() {
		$this->Users = new TestUsersController();
		$this->Users->constructClasses();
		$this->Users->Access->file = 'test_suite_permissions';
	}
	
	public function testLoginActionWithValidUser() {
		$this->Users->params['url']['url'] = Router::normalize($this->Users->params = Router::parse('/users/users/login'));
		$this->Users->Component->initialize($this->Users);
		$this->Users->data = array(
			$this->Users->Auth->userModel => array(
				$this->Users->Auth->fields['username'] => 'Phally',
				$this->Users->Auth->fields['password'] => 'frank',
				$this->Users->Access->rememberField => 1
			)
		);
		
		$this->Users->beforeFilter();
		$this->Users->Component->startup($this->Users);
		$this->Users->login();
		
		$result = $this->Users->Access->getRememberCookie();
		$expected = array(
			$this->Users->Auth->fields['username'] => 'Phally',
			$this->Users->Auth->fields['password'] => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe',
		);
		$this->assertEqual($result, $expected, 'User has been placed in the remember me cookie');
		
		$this->assertEqual($this->Users->Auth->user('username'), 'Phally', 'User is logged in');
		
		if (!$this->Users->Auth->loginRedirect) {
			$this->Users->Auth->loginRedirect = '/';
		}
		$this->assertEqual($this->Users->redirectUrl, $this->Users->Auth->loginRedirect, 'User is redirected');
	}
	
	public function testLoginActionWithoutValidUser() {
		$this->Users->params['url']['url'] = Router::normalize($this->Users->params = Router::parse('/users/users/login'));
		$this->Users->Component->initialize($this->Users);
		
		$this->Users->data = array(
			$this->Users->Auth->userModel => array(
				$this->Users->Auth->fields['username'] => 'Phally',
				$this->Users->Auth->fields['password'] => 'Some wrong password...',
				$this->Users->Access->rememberField => 1
			)
		);
		
		$this->Users->beforeFilter();
		$this->Users->Component->startup($this->Users);
		$this->Users->Auth->login($this->Users->data);
		$this->Users->login();
		
		$this->assertNull($this->Users->Access->getRememberCookie(), 'No remember me cookie is set');
		$this->assertNull($this->Users->Auth->user('username'), 'No user is logged in');
		$this->assertNull($this->Users->redirectUrl, 'No redirects took place');
	}
	
	public function testLogoutAction() {
		$this->Users->params['url']['url'] = Router::normalize($this->Users->params = Router::parse('/users/users/logout'));
		$this->Users->Component->initialize($this->Users);
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
		
		$this->assertNull($this->Users->Auth->user(), 'User is logged out');
		$this->assertNull($this->Users->Access->getRememberCookie(), 'Remember me cookie has been deleted');
		$this->assertEqual($this->Users->redirectUrl, Router::normalize($this->Users->Auth->logoutRedirect), 'User is redirected to the logoutRedirect');
	}

	public function testIndexActionWithoutSearchParameters() {
		$this->Users->params['url']['url'] = Router::normalize($this->Users->params = Router::parse('/users/users/index'));
		$this->Users->Component->initialize($this->Users);
		$this->Users->beforeFilter();
		
		$this->Users->Component->startup($this->Users);
		$this->Users->index();
		
		$this->assertEqual(Set::extract('/User/id', $this->Users->viewVars['users']), array(5, 4, 3, 7, 6, 1, 2), 'View variable \'$users\' matches');
		$this->assertNull($this->Users->redirectUrl, 'No redirects');
	}

	public function testIndexActionWithSearchParameters() {
		$url = '/users/users/index/keyword:a';
		$this->Users->params = array_merge(Router::parse($url), array('url' => array('url' => $url)));
		
		$this->Users->Component->initialize($this->Users);
		$this->Users->beforeFilter();
		
		$this->Users->Component->startup($this->Users);
		$this->Users->index();
		$this->assertEqual(Set::extract('/User/id', $this->Users->viewVars['users']), array(5, 4, 1), 'View variable \'$users\' matches');
		$this->assertNull($this->Users->redirectUrl, 'No redirects');
	}
	
	public function endTest() {
		$this->Users->Session->destroy();
		$this->Users->Access->Cookie->destroy();
		unset($this->Users);
		ClassRegistry::flush();
	}
	
	public function endCase() {
		@unlink(APP . 'config' . DS . $this->config);
	}
}

?>