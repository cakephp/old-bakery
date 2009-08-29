<?php 
App::import('Model', 'Users.Message');

class MessageTestCase extends CakeTestCase {
	public $Message = null;
	public $fixtures = array('plugin.users.message', 'plugin.users.conversation', 'plugin.users.user', 'plugin.users.conversations_user');

	public function startTest() {
		$this->Message =& ClassRegistry::init('Message');
		$this->Message->recursive = -1;
	}

	public function testMessageInstance() {
		$this->assertIsA($this->Message, 'Message', 'Model instance present');
	}

	public function testMessageFind() {
		$results = $this->Message->find('first');
		$this->assertTrue(!empty($results), 'First record retreived');

		$expected = array(
			'Message' => array(
				'id'  => 1,
				'conversation_id'  => 1,
				'user_id'  => 6,
				'message'  => 'I am experiencing glitches when publishing an article. Can you please look at this?',
				'created'  => '2009-07-19 00:22:59',
				'modified'  => '2009-07-19 00:22:59'
			)
		);
		$this->assertEqual($results, $expected, 'First record matches');
	}
	
	
	public function testSendingInvalidMessages() {
		$valid = $this->Message->send('', 6, 1, null, 1) ? true : false;
		$this->assertFalse($valid, 'Empty message intercepted');
		$this->assertEqual($this->Message->find('count', array('conditions' => array('Message.message' => ''))), 0, 'No empty messages inserted');
	}
	
	public function testSendToExistingConversation() {
		$valid = $this->Message->send('Hello there!', 6, 1, null, 1) ? true : false;
		$this->assertTrue($valid, 'No validation errors');
		
		$result = $this->Message->find('first', array(
			'fields' => array(
				'Message.user_id',
				'Message.message',
			),
			'conditions' => array(
				'user_id' => 1,
				'message' => 'Hello there!'
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => 'Conversation.title'
				)
			)
		));
		$expected = array(
			'Message' => array(
				'user_id' => 1,
				'message' => 'Hello there!',
			),
			'Conversation' => array(
				'title'  => 'Problems with publishing.',
				'id' => 1
			)
		);
		$this->assertEqual($result, $expected, 'Message actually saved');
		
		$result = $this->Message->Conversation->ConversationsUser->find('all', array(
			'fields' => array('new'),
			'conditions' => array(
				'ConversationsUser.conversation_id' => 1, 
				'ConversationsUser.user_id != ' => 1
			)
		));
		
		$expected = array(
			0 => array(
				'ConversationsUser' => array(
					'new' => true
				)
			)
		);
		
		$this->assertEqual($result, $expected, 'Receiving users have a new message in this conversation');
	}
	
	public function testSendToNewConversationWithOneRecipient() {
		$valid = $this->Message->send('Hello there!', 2, 3, 'The subject...') ? true : false;
		$this->assertTrue($valid, 'No validation errors');
		$result = $this->Message->find('first', array(
			'fields' => array(
				'user_id',
				'conversation_id',
				'message',
			),
			'conditions' => array(
				'user_id' => 3,
				'message' => 'Hello there!'
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'title'
					),
					'ConversationsUser' => array(
						'fields' => array(
							'user_id',
							'new'
						)
					)
				)
			)
		));
		$expected = array(
			'Message' => array(
				'user_id' => 3,
				'conversation_id' => 5,
				'message' => 'Hello there!',
			),
			'Conversation' => array(
				'title' => 'The subject...',
				'id' => 5,
				'ConversationsUser' => array(
					0 => array(
						'user_id' => 2,
						'id' => 5,
						'conversation_id' => 5,
						'new' => true
					),
					1 => array(
						'user_id' => 3,
						'id' => 6,
						'conversation_id' => 5,
						'new' => false
					)
				)
			)
		);
		$this->assertEqual($result, $expected, 'Message and conversation actually saved');
		
	}
	
	public function testSendToNewConversationWithMultipleRecipients() {
		$valid = $this->Message->send('Multiple recipients!', array(1, 2, 4), 3, 'The multiple subject...') ? true : false;
		$this->assertTrue($valid, 'No validation errors');
		
		$result = $this->Message->find('all', array(
			'fields' => array(
				'user_id',
				'conversation_id',
				'message',
			),
			'conditions' => array(
				'user_id' => 3,
				'message' => 'Multiple recipients!'
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'title'
					),
					'ConversationsUser' => array(
						'fields' => array(
							'user_id'
						)
					)
				)
			)
		));
		$expected = array(
			array(
				'Message' => array(
					'user_id' => 3,
					'conversation_id' => 5,
					'message' => 'Multiple recipients!',
				),
				'Conversation' => array(
					'title' => 'The multiple subject...',
					'id' => 5,
					'ConversationsUser' => array(
						0 => array(
							'user_id' => 1,
							'id' => 5,
							'conversation_id' => 5
						),
						1 => array(
							'user_id' => 3,
							'id' => 6,
							'conversation_id' => 5
						)
					)
				)
			),
			array(
				'Message' => array(
					'user_id' => 3,
					'conversation_id' => 6,
					'message' => 'Multiple recipients!',
				),
				'Conversation' => array(
					'title' => 'The multiple subject...',
					'id' => 6,
					'ConversationsUser' => array(
						0 => array(
							'user_id' => 2,
							'id' => 7,
							'conversation_id' => 6
						),
						1 => array(
							'user_id' => 3,
							'id' => 8,
							'conversation_id' => 6
						)
					)
				)
			),
			array(
				'Message' => array(
					'user_id' => 3,
					'conversation_id' => 7,
					'message' => 'Multiple recipients!',
				),
				'Conversation' => array(
					'title' => 'The multiple subject...',
					'id' => 7,
					'ConversationsUser' => array(
						0 => array(
							'user_id' => 4,
							'id' => 9,
							'conversation_id' => 7
						),
						1 => array(
							'user_id' => 3,
							'id' => 10,
							'conversation_id' => 7
						)
					)
				)
			),
			
		);
		$this->assertEqual($result, $expected, 'Multiple messages and conversations actually saved');		
	}
	
	public function testSendSystemMessage() {
		$valid = $this->Message->send('You have received a new comment on your article.', 2, null, 'System message') ? true : false;
		$this->assertTrue($valid, 'No validation errors');
		$result = $this->Message->find('first', array(
			'fields' => array(
				'user_id',
				'conversation_id',
				'message',
			),
			'conditions' => array(
				'user_id' => null,
				'message' => 'You have received a new comment on your article.'
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'title'
					),
					'ConversationsUser' => array(
						'fields' => array('user_id')
					)
				)
			)
		));
		$expected = array(
			'Message' => array(
				'user_id' => null,
				'conversation_id' => 5,
				'message' => 'You have received a new comment on your article.',
			),
			'Conversation' => array(
				'title' => 'System message',
				'id' => 5,
				'ConversationsUser' => array(
					0 => array(
						'user_id' => 2,
						'id' => 5,
						'conversation_id' => 5
					)
				)
			)
		);
		$this->assertEqual($result, $expected, 'Message and conversation actually saved');
		
	}

	public function testSendMessageToSelf() {
		$valid = $this->Message->send('I can send a message to myself.', 2, 2, 'Personal issue') ? true : false;
		$this->assertTrue($valid, 'No validation errors');
		$result = $this->Message->find('first', array(
			'fields' => array(
				'user_id',
				'conversation_id',
				'message',
			),
			'conditions' => array(
				'user_id' => 2,
				'message' => 'I can send a message to myself.'
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'title'
					),
					'ConversationsUser' => array(
						'fields' => array('user_id')
					)
				)
			)
		));
		$expected = array(
			'Message' => array(
				'user_id' => 2,
				'conversation_id' => 5,
				'message' => 'I can send a message to myself.',
			),
			'Conversation' => array(
				'title' => 'Personal issue',
				'id' => 5,
				'ConversationsUser' => array(
					0 => array(
						'user_id' => 2,
						'id' => 5,
						'conversation_id' => 5
					)
				)
			)
		);
		$this->assertEqual($result, $expected, 'Message and conversation actually saved');
		
	}
	
	public function endTest() {
		// Against containable bleed-through.
		ClassRegistry::flush();
	}
	
}
?>