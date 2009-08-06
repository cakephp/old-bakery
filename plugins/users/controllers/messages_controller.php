<?php
class MessagesController extends UsersAppController {

	public $components = array('Users.Messaging');

	public function send($user_id = null) {
		if (!$user_id || $user_id == $this->Auth->user('id')) {
			$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'));
		}
		
		if ($this->data) {
			App::import('Core', 'Sanitize');
			$message = Sanitize::clean($this->data['Message']['message']);
			$title = Sanitize::clean($this->data['Conversation']['title']);
			$recipient = $user_id;
			$sender = $this->Auth->user('id');
			
			if ($this->Messaging->send($message, $recipient, $sender, $title)) {
				$this->Session->setFlash(__('Your message has been sent', true));
				$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'));
			}
		}
		
		$this->Message->User->id = $user_id;
		$this->set('recipientName', $this->Message->User->field('username'));
	}

}
?>