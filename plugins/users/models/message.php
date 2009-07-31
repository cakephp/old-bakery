<?php
class Message extends UsersAppModel {
	public $useDbConfig = 'user_plug';
	
	public $belongsTo = array(
		'Users.Conversation', 
		'Users.User'
	);
	
	public function send($message = null, $recipients = array(), $sender = null, $title = null, $conversationId = null) {
		if ($conversationId && !is_array($recipients)) {
			
			$conversation = $this->Conversation->find('first', array(
				'conditions' => array(
					$this->Conversation->primaryKey => $conversationId,
					'sender_id' => array($recipients, $sender),
					'recipient_id' => array($recipients, $sender)
				)
			));
			
			if ($conversation) {
			
				$this->create(array(
					$this->alias => array(
						'conversation_id' => $conversationId,
						'user_id' => $recipients,
						'message' => $message
					)
				));
				return $this->save();
				
			} else {
			
				return false;
				
			}
			
		}
		
		$recipients = is_array($recipients) ? $recipients : array($recipients);
		
		// Todo, place validation outside the loop and return a proper value.
		
		foreach($recipients as $recipient) {
			$this->saveAll(array(
				$this->Conversation->alias => array(
					'sender_id' => $sender,
					'recipient_id' => $recipient,
					'title' => $title,
				),
				$this->alias => array(
					'conversation_id' => $conversationId,
					'user_id' => $recipient,
					'message' => $message
				)
			), array('validate' => 'first'));
		}
		
		return true;
	}
}
?>