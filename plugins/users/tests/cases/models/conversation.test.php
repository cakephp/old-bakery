<?php 
/* SVN FILE: $Id$ */
/* Conversation Test cases generated on: 2009-07-19 00:22:13 : 1247955733*/
App::import('Model', 'Users.Conversation');

class ConversationTestCase extends CakeTestCase {
	public $Conversation = null;
	public $fixtures = array('plugin.users.conversation', 'plugin.users.user', 'plugin.users.message');

	public function startTest() {
		$this->Conversation =& ClassRegistry::init('Conversation');
	}

	public function testConversationInstance() {
		$this->assertTrue(is_a($this->Conversation, 'Conversation'));
	}

	public function testConversationFind() {
		$this->Conversation->recursive = -1;
		$results = $this->Conversation->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Conversation' => array(
			'id'  => 1,
			'sender_id'  => 1,
			'recipient_id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-07-19 00:22:13',
			'modified'  => '2009-07-19 00:22:13'
		));
		$this->assertEqual($results, $expected);
	}
}
?>