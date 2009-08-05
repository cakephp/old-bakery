<?php
class MessagesController extends UsersAppController {

	public $components = array('Users.Messaging');

	public function send($user_id = null) {
		if (!$user_id) {
			$this->redirect(array('controller' => 'users', 'action' => 'index'));
		}
		
		if ($this->data) {
			$message = $this->data['Message']['message'];
			$title = $this->data['Conversation']['title'];
			$recipient = $user_id;
			$sender = $this->Auth->user('id');
			
			if ($this->Messaging->send($message, $recipient, $sender, $title)) {
				$this->Session->setFlash(__('Your message has been sent', true));
			}
		}
		
		$this->Message->User->id = $user_id;
		$this->set('recipientName', $this->Message->User->field('username'));
	}

}
?>