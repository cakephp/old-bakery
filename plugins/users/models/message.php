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
			$conversation = $this->Conversation->find('count', array(
				'conditions' => array(
					$this->Conversation->primaryKey => $conversationId,
					'sender_id' => array($recipients, $sender),
					'recipient_id' => array($recipients, $sender)
				)
			));
			
			if ($conversation > 0) {
				$data[$this->alias]['conversation_id'] = $conversationId;
			}
		}

		if (!isset($data[$this->alias]['conversation_id'])) {
			$data[$this->Conversation->alias] = array(
				'sender_id' => $sender,
				'title' => $title,
			);
		}
		
		$this->set($data);
		$this->Conversation->set($data);
		$invalid = (!$this->validates() || !$this->Conversation->validates());
		
		if (!$invalid) {
			if (isset($data[$this->alias]['conversation_id'])) {
				$this->save($data, false);
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