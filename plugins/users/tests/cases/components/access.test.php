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
	
	public $fixtures = array('plugin.users.user', 'plugin.users.group');
	
		
	public function startCase() {
		$testfile = APP . 'plugins' . DS . 'users' . DS . 'tests' . DS . 'files' . DS . 'permissions.php.test';
		$configfile = APP . 'config' . DS . $this->config;
		copy($testfile, $configfile);
	}
	
	public function endCase() {
		@unlink(APP . 'config' . DS . $this->config);
	}
	
	public function startTest() {
		$this->Controller = new FakeTestController();
		$this->Controller->constructClasses();
		$this->Controller->beforeFilter();
		$this->Controller->params = Router::parse('/');
		$this->Controller->Session->delete('Auth.User');
		$this->Controller->Access->initialize($this->Controller);
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
	
	public function testIsAuthorizedOnNonSignedInUsers() {
		$this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized());

		$this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/add');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/move');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized());
	}
	
	public function testIsAuthorizedOnMemberUsers() {
		$this->Controller->Session->write('Auth.User.group_id', Group::USERS);
		
		$this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized());

		$this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/move');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized());
	}
	
	public function testIsAuthorizedOnModeratorUsers() {
		$this->Controller->Session->write('Auth.User.group_id', Group::MODERATORS);
		
		$this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized());

		$this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/move');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized());
	}

	public function testIsAuthorizedOnCoreDevUsers() {
		$this->Controller->Session->write('Auth.User.group_id', Group::COREDEVS);
		
		$this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized());

		$this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/users/users/delete');
		$this->assertFalse($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/move');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized());
	}
	
	public function testIsAuthorizedOnAdministratorUsers() {
		$this->Controller->Session->write('Auth.User.group_id', Group::ADMINS);
		
		$this->Controller->params = Router::parse('/users/users/login');
		$this->assertTrue($this->Controller->Access->isAuthorized());

		$this->Controller->params = Router::parse('/users/users/logout');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/users/users/delete');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/add');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/comments/move');
		$this->assertTrue($this->Controller->Access->isAuthorized());
		
		$this->Controller->params = Router::parse('/not/existing');
		$this->assertFalse($this->Controller->Access->isAuthorized());
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
		Configure::write('debug', 1);
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->assertEqual($this->Controller->Auth->user('id'), 1);
		$this->assertEqual($this->Controller->Auth->user('username'), 'Phally');
		$this->assertEqual($this->Controller->Auth->user('group_id'), 100);
	}
	
	public function testLazyLoginInProductionMode() {
		Configure::write('debug', 0);
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->assertNull($this->Controller->Auth->user());
	}
	
	public function testLazyLoginWithSignedInUser() {
		Configure::write('debug', 1);
		$this->Controller->Auth->fields = array('username' => 'username', 'password' => 'psword');
		
		$user = ClassRegistry::init('Users.User')->find('first', array('conditions' => array('username' => 'coredev')));
		$this->Controller->Auth->login($user);
		
		$this->Controller->Access->lazyLogin('Phally');
		
		$this->assertEqual($this->Controller->Auth->user('id'), 3);
		$this->assertEqual($this->Controller->Auth->user('username'), 'coredev');
		$this->assertEqual($this->Controller->Auth->user('group_id'), 80);
	}
	
	
}
?>