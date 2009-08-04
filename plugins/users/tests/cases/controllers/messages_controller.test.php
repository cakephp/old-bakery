<?php
App::import('Controller', 'Users.Messages');
class TestMessagesController extends MessagesController {
	public $redirectUrl = null;
	public $renderedAction = null;
	public $stopped = null;
	public $uses = 'Users.Message';
	
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

class MessagesControllerTestCase extends CakeTestCase {
	private $Messages = null;
	public $fixtures = array('plugin.users.user', 'plugin.users.message', 'plugin.users.conversation', 'plugin.users.conversations_user');
	private $config = 'test_suite_permissions.php';
	
	public function startCase() {
		$testfile = APP . 'plugins' . DS . 'users' . DS . 'tests' . DS . 'files' . DS . 'permissions.php.test';
		$configfile = APP . 'config' . DS . $this->config;
		copy($testfile, $configfile);
	}
	
	public function startTest() {
		$this->Messages = new TestMessagesController();
		$this->Messages->constructClasses();
		$this->Messages->Access->file = 'test_suite_permissions';
	}
	
	public function testSendActionWithoutRecipient() {
		$url = '/users/messages/send/';
		$this->Messages->params = array_merge(Router::parse($url), array('url' => array('url' => $url)));
		$this->Messages->Component->initialize($this->Messages);
		
		$this->Messages->beforeFilter();
		$this->Messages->Access->lazyLogin('Phally');
		$this->Messages->Component->startup($this->Messages);
		$this->assertNull($this->Messages->redirectUrl, 'No redirects by Auth, user is logged in and has permission.');
		$this->Messages->send();
		
		$this->assertEqual($this->Messages->redirectUrl, array('controller' => 'users', 'action' => 'index'), 'User redirected to member list');
		
	}
	
	public function endTest() {
		$this->Messages->Session->destroy();
		$this->Messages->Access->Cookie->destroy();
		unset($this->Messages);
		ClassRegistry::flush();
	}
	
	public function endCase() {
		@unlink(APP . 'config' . DS . $this->config);
	}
}

?>