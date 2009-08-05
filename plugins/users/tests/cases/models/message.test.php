<?php 
/* SVN FILE: $Id$ */
/* Message Test cases generated on: 2009-07-19 00:22:59 : 1247955779*/
App::import('Model', 'Users.Message');

class MessageTestCase extends CakeTestCase {
	public $Message = null;
	public $fixtures = array('plugin.users.message', 'plugin.users.conversation', 'plugin.users.user');

	public function startTest() {
		$this->Message =& ClassRegistry::init('Message');
		$this->Message->recursive = -1;
	}

	public function testMessageInstance() {
		$this->assertTrue(is_a($this->Message, 'Message'));
	}

	public function testMessageFind() {
		$results = $this->Message->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Message' => array(
			'id'  => 1,
			'conversation_id'  => 1,
			'user_id'  => 6,
			'message'  => 'I am experiencing glitches when publishing an article. Can you please look at this?',
			'new'  => false,
			'created'  => '2009-07-19 00:22:59',
			'modified'  => '2009-07-19 00:22:59'
		));
		$this->assertEqual($results, $expected);
	}
	
	public function testSendToExistingConversation() {
		$this->assertTrue($this->Message->send('Hello there!', 6, 1, null, 1));
	}
	
	public function testSendToNewConversationWithOneRecipient() {
		$this->assertTrue($this->Message->send('Hello there!', 2, 3, 'The subject...'));
		$result = $this->Message->find('first', array(
			'fields' => array(
				'user_id',
				'message',
				'new'
			),
			'conditions' => array(
				'user_id' => 2,
				'message' => 'Hello there!'
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'sender_id',
						'recipient_id',
						'title'
					)
				)
			)
		));
		$expected = array(
			'Message' => array(
				'user_id' => 2,
				'message' => 'Hello there!',
				'new' => true
			),
			'Conversation' => array(
				'sender_id' => 3,
				'recipient_id' => 2,
				'title' => 'The subject...',
				'id' => 5
			)
		);
		$this->assertEqual($result, $expected);
		
	}
}
?>