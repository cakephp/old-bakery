<?php
App::import('Controller', 'Users.Conversations');
class TestConversationsController extends ConversationsController {
	public $redirectUrl = null;
	public $renderedAction = null;
	public $stopped = null;
	public $uses = 'Users.Conversation';
	
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

class ConversationsControllerTestCase extends CakeTestCase {
	private $Conversations = null;
	public $fixtures = array('plugin.users.user', 'plugin.users.message', 'plugin.users.conversation', 'plugin.users.conversations_user');
	private $config = 'test_suite_permissions.php';
	
	public function startCase() {
		$testfile = APP . 'plugins' . DS . 'users' . DS . 'tests' . DS . 'files' . DS . 'permissions.php.test';
		$configfile = APP . 'config' . DS . $this->config;
		copy($testfile, $configfile);
	}
	
	public function startTest() {
		$this->Conversations = new TestConversationsController();
		$this->Conversations->constructClasses();
		$this->Conversations->Access->file = 'test_suite_permissions';
	}
	
	public function testIndexAction() {
		$url = '/users/conversations/index';
		$this->Conversations->params = array_merge(Router::parse($url), array('url' => array('url' => $url)));
		
		$this->Conversations->Component->initialize($this->Conversations);
		
		$this->Conversations->beforeFilter();
		$this->Conversations->Access->lazyLogin('Phally');
		$this->Conversations->Component->startup($this->Conversations);
		$this->assertNull($this->Conversations->redirectUrl, 'No redirects by Auth, user is logged in and has permission');
		
		$this->Conversations->index();
		
		$expected = array(
			array(
				'ConversationsUser' => array(
					'new' => true,
					'modified' => '2009-07-19 00:24:13'
				),
				'Conversation' => array(
					'id' => 2,
					'title' => 'Problems with spammers.'
				)
			),
			array(
				'ConversationsUser' => array(
					'new' => true,
					'modified' => '2009-07-19 00:22:13'
				),
				'Conversation' => array(
					'id' => 1,
					'title' => 'Problems with publishing.'
				)
			)		
		);
		
		$this->assertEqual($this->Conversations->viewVars['conversations'], $expected);
	}
	
	public function endTest() {
		$this->Conversations->Session->destroy();
		$this->Conversations->Access->Cookie->destroy();
		unset($this->Conversations);
		ClassRegistry::flush();
	}
	
	public function endCase() {
		@unlink(APP . 'config' . DS . $this->config);
	}
}

?>