<?php
App::import('Controller', 'Users.AppController');
class FakeTestController extends UsersAppController {
	public $uses = array();
	public $components = array('Auth', 'Users.Access');
	
	public function beforeFilter() {
		$this->Access->file = 'test_suite_permissions';
	}
}

class AccessComponentTestCase extends CakeTestCase {

	private $Controller = null;
	private $config = 'test_suite_permissions.php';
	
	public $fixtures = array('plugin.users.user', 'plugin.users.message', 'plugin.users.conversation');
	
		
	public function startCase() {
		$testfile = APP . 'plugins' . DS . 'users' . DS . 'tests' . DS . 'files' . DS . 'permissions.php.test';
		$configfile = APP . 'config' . DS . $this->config;
		copy($testfile, $configfile);
	}
	
	public function endCase() {
		$this->Controller->Auth->logout();
		$this->Controller->Access->Cookie->destroy();
		@unlink(APP . 'config' . DS . $this->config);
	}
	
	public function startTest() {
		$this->Controller = new FakeTestController();
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/');
		$this->Controller->constructClasses();
		$this->Controller->beforeFilter();
		$this->Controller->Session->delete('Auth.User');
		$this->Controller->Component->initialize($this->Controller);
		$this->Controller->Component->startup($this->Controller);
	}
	
	public function testInstances() {
		$this->assertIsA($this->Controller, 'FakeTestController');
		$this->assertIsA($this->Controller->Auth, 'AuthComponent');
		$this->assertIsA($this->Controller->Access, 'AccessComponent');
	}
	
	public function testLoadedHelper() {
		$this->AssertTrue(in_array('Users.Auth', $this->Controller->helpers));
	}
	
	public function testAuthConfiguration() {
		$this->assertEqual($this->Controller->Auth->authorize, 'object');
		$this->AssertIsA($this->Controller->Auth->object, 'AccessComponent');
		$this->AssertIsA($this->Controller->Auth->authenticate, 'AccessComponent');
	}
	
	public function testPassingAuthFields() {
		$this->assertEqual($this->Controller->viewVars['authFields'], $this->Controller->Auth->fields);
	}
	
	public function testIsAuthorizedOnNonSignedInUsers() {
		$this->Controller->Auth->params = $this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')	
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')	
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/add');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/move');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
	}
	
	public function testIsAuthorizedOnMemberUsers() {
		$this->Controller->Session->write('Auth.User.group_id', 10);
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/move');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
	}
	
	public function testIsAuthorizedOnModeratorUsers() {
		$this->Controller->Session->write('Auth.User.group_id', 50);
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		

		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/move');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
	}

	public function testIsAuthorizedOnCoreDevUsers() {
		$this->Controller->Session->write('Auth.User.group_id', 80);
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));

		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/move');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
	}
	
	public function testIsAuthorizedOnAdministratorUsers() {
		$this->Controller->Session->write('Auth.User.group_id', 100);
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));

		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/users/users/delete');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/comments/move');
		$this->assertTrue($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
		
		$this->Controller->Auth->params = $this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized(
			$this->Controller->Auth->user(),
			$this->Controller->Auth->action(':controller'),
			$this->Controller->Auth->action(':action')
		));
	}
	
	public function testHashPasswordsWithDefaultFields() {
		$data = array('User' => array('username' => 'Phally', 'password' => 'Frank'));
		$expected = array('User' => array('username' => 'Phally', 'password' => Security::hash('Frank', null, true)));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$data = array('User' => array('email' => 'phally@example.org', 'password' => 'Frank'));
		$expected = array('User' => array('email' => 'phally@example.org', 'password' => 'Frank'));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$this->Controller->Access->salt = false;
		
		$data = array('User' => array('username' => 'Phally', 'password' => 'Frank'));
		$expected = array('User' => array('username' => 'Phally', 'password' => Security::hash('Frank')));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
	}

	public function testHashPasswordsWithCustomFields() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		
		$data = array('User' => array('username' => 'Phally', 'psword' => 'Frank'));
		$expected = array('User' => array('username' => 'Phally', 'psword' => Security::hash('Frank', null, true)));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$data = array('User' => array('email' => 'phally@example.org', 'psword' => 'Frank'));
		$expected = array('User' => array('email' => 'phally@example.org', 'psword' => 'Frank'));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$this->Controller->Access->salt = false;
		
		$data = array('User' => array('username' => 'Phally', 'psword' => 'Frank'));
		$expected = array('User' => array('username' => 'Phally', 'psword' => Security::hash('Frank')));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
	}

	public function testHashPasswordsWithCustomUserModel() {
		$this->Controller->Auth->userModel = 'Member';
		
		$data = array('Member' => array('username' => 'Phally', 'password' => 'Frank'));
		$expected = array('Member' => array('username' => 'Phally', 'password' => Security::hash('Frank', null, true)));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$data = array('Member' => array('email' => 'phally@example.org', 'password' => 'Frank'));
		$expected = array('Member' => array('email' => 'phally@example.org', 'password' => 'Frank'));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$this->Controller->Access->salt = false;
		
		$data = array('Member' => array('username' => 'Phally', 'password' => 'Frank'));
		$expected = array('Member' => array('username' => 'Phally', 'password' => Security::hash('Frank')));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
		$data = array('User' => array('username' => 'Phally', 'password' => 'Frank'));
		$expected = array('User' => array('username' => 'Phally', 'password' => 'Frank'));
		$result = $this->Controller->Access->hashPasswords($data);
		$this->assertEqual($expected, $result);
		
	}
	
	public function testLazyLoginInDebugMode() {
		$mode = Configure::read('debug');
		Configure::write('debug', 1);
		
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->assertEqual($this->Controller->Auth->user('id'), 1);
		$this->assertEqual($this->Controller->Auth->user('username'), 'Phally');
		$this->assertEqual($this->Controller->Auth->user('group_id'), 100);
		
		Configure::write('debug', $mode);
	}
	
	public function testLazyLoginInProductionMode() {
		$mode = Configure::read('debug');
		Configure::write('debug', 0);
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->assertNull($this->Controller->Auth->user());
		
		Configure::write('debug', $mode);
	}
	
	public function testLazyLoginWithSignedInUser() {
		$mode = Configure::read('debug');
		Configure::write('debug', 1);
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		
		$user = ClassRegistry::init('Users.User')->find('first', array('conditions' => array('username' => 'coredev')));
		$this->Controller->Auth->login($user);
		
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->assertEqual($this->Controller->Auth->user('id'), 3);
		$this->assertEqual($this->Controller->Auth->user('username'), 'coredev');
		$this->assertEqual($this->Controller->Auth->user('group_id'), 80);
		
		Configure::write('debug', $mode);
	}
	
	public function testSetRememberCookieWithoutRememberValueAndNoLogin() {
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword'
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		$result = $this->Controller->Access->Cookie->read($this->Controller->Auth->sessionKey);
		$expected = null;
		$this->assertEqual($result, $expected);
	}
	
	public function testSetRememberCookieWithRememberValueAndNoLogin() {
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword',
				$this->Controller->Access->rememberField => 0
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		$result = $this->Controller->Access->Cookie->read($this->Controller->Auth->sessionKey);
		$expected = null;
		$this->assertEqual($result, $expected);
		
		$this->Controller->Access->Cookie->destroy();
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword',
				$this->Controller->Access->rememberField => 1
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		$result = $this->Controller->Access->Cookie->read($this->Controller->Auth->sessionKey);
		$expected = null;
		$this->assertEqual($result, $expected);
	}
	
	public function testSetRememberCookieWithRememberValueAndLogin() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword',
				$this->Controller->Access->rememberField => 0
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		$result = $this->Controller->Access->Cookie->read($this->Controller->Auth->sessionKey);
		$expected = null;
		$this->assertEqual($result, $expected);
		
		$this->Controller->Access->Cookie->destroy();
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword',
				$this->Controller->Access->rememberField => 1
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		$result = $this->Controller->Access->Cookie->read($this->Controller->Auth->sessionKey);
		$expected = array(
			$this->Controller->Auth->fields['username'] => 'Phally',
			$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword'
		);
		$this->assertEqual($result, $expected);
	}
	
	public function testGetRememberCookie() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$result = $this->Controller->Access->getRememberCookie();
		$expected = null;
		$this->assertEqual($result, $expected);
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword',
				$this->Controller->Access->rememberField => 1
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		
		$result = $this->Controller->Access->getRememberCookie();
		$expected = array(
			$this->Controller->Auth->fields['username'] => 'Phally',
			$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword'
		);
		$this->assertEqual($result, $expected);
	}
	
	public function testDeleteRememberCookie() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword',
				$this->Controller->Access->rememberField => 1
			)
		);
		
		$this->Controller->Access->setRememberCookie($data);
		
		$result = $this->Controller->Access->getRememberCookie();
		$expected = array(
			$this->Controller->Auth->fields['username'] => 'Phally',
			$this->Controller->Auth->fields['password'] => 'SomeInRealityHashedPassword'
		);
		$this->assertEqual($result, $expected);
		
		$this->Controller->Access->deleteRememberCookie();
		
		$result = $this->Controller->Access->getRememberCookie();
		$expected = null;
		$this->assertEqual($result, $expected);
	}
	
	public function testCookieLoginWithoutCookieAndWithoutLoggedInUser() {
		$this->Controller->Access->cookieLogin();
		$this->assertNull($this->Controller->Auth->user());
	}
	
	public function testCookieLoginWithoutCookieAndWithLoggedInUser() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->Controller->Access->cookieLogin();
		$result = $this->Controller->Auth->user($this->Controller->Auth->fields['username']);
		$expected = 'Phally';
		$this->assertEqual($result, $expected);
	}
	
	public function testCookieLoginWithCookieAndWithoutLoggedInUser() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe',
				$this->Controller->Access->rememberField => 1
			)
		);
		
		$this->Controller->Auth->login($data);
		$this->Controller->Access->setRememberCookie($data);
		$this->Controller->Auth->logout();
		
		$this->Controller->Access->cookieLogin();
		$result = $this->Controller->Auth->user($this->Controller->Auth->fields['username']);
		$expected = 'Phally';
		$this->assertEqual($result, $expected);
	}
	
	public function testCookieLoginWithCookieAndLoggedInUser() {
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		
		$data = array(
			$this->Controller->Auth->userModel => array(
				$this->Controller->Auth->fields['username'] => 'Phally',
				$this->Controller->Auth->fields['password'] => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe',
				$this->Controller->Access->rememberField => 1
			)
		);
		
		$this->Controller->Auth->login($data);
		$this->Controller->Access->setRememberCookie($data);
		$this->Controller->Auth->logout();
		$this->Controller->Access->lazyLogin('coredev');
		
		$this->Controller->Access->cookieLogin();
		$result = $this->Controller->Auth->user($this->Controller->Auth->fields['username']);
		$expected = 'coredev';
		$this->assertEqual($result, $expected);
	}
}
?>