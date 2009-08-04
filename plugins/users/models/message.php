<?php
class Message extends UsersAppModel {
	public $useDbConfig = 'users_plugin';
	
	public $belongsTo = array(
		'Users.Conversation', 
		'Users.User'
	);
	
	public $validate = array(
		'message' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a message.'
			)
		)
	);
	
	public function send($message = null, $recipients = array(), $sender = null, $title = null, $conversationId = null) {
		$data = array();
		$this->id = null;
		
		$data[$this->alias] = array(
			'user_id' => $sender,
			'message' => $message
		);
		
		if ($conversationId && !is_array($recipients)) {
			$conversation = $this->Conversation->ConversationsUser->find('count', array(
				'conditions' => array(
					'conversation_id' => $conversationId,
					'user_id' => $sender,
				)
			));
			
			if ($conversation > 0) {
				$data[$this->alias]['conversation_id'] = $conversationId;
			}
		}

		if (!isset($data[$this->alias]['conversation_id'])) {
			$data[$this->Conversation->alias] = array(
				'title' => $title,
			);
		}
		
		$this->set($data);
		$this->Conversation->set($data);
		$validConversation = $this->Conversation->validates();
		$validMessage = $this->validates();
		
		$invalid = (!$validConversation || !$validMessage);
		
		if (!$invalid) {
			if (isset($data[$this->alias]['conversation_id'])) {
				$this->save($data, false);
				$this->Conversation->ConversationsUser->updateAll(
					array(
						'new' => true
					), 
					array(
						'ConversationsUser.conversation_id' => $data[$this->alias]['conversation_id'], 
						'ConversationsUser.user_id != ' => $sender
					)
				);
			} else {
				$recipients = is_array($recipients) ? $recipients : array($recipients);
				$message = $data['Message'];
				unset($data['Message']);
				$data['Message'][0] = $message;
				foreach($recipients as $recipient) {
					$data[$this->Conversation->alias]['recipient_id'] = $recipient;
					$data[$this->Conversation->ConversationsUser->alias]= array(
						array('user_id' => $sender), 
						array('user_id' => $recipient)
					);
					$this->Conversation->saveAll($data, array('validate' => false));
				}
			}
		}
		return !$invalid;
	}
}
?>