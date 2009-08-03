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
		$invalid = (!$this->validates() || !$this->Conversation->validates());
		
		if (!$invalid) {
			if (isset($data[$this->alias]['conversation_id'])) {
				$this->save($data, false);
				// todo: updateAll to set new for all joined users.
			} else {
				$recipients = is_array($recipients) ? $recipients : array($recipients);
				foreach($recipients as $recipient) {
					$data[$this->Conversation->alias]['recipient_id'] = $recipient;
					$this->saveAll($data, array('validate' => false));
				}
			}
		}
		return !$invalid;
	}
}
?>