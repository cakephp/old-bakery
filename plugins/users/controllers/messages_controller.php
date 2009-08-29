<?php
class MessagesController extends UsersAppController {

	public $components = array('Users.Messaging');

	public function send($user_id = null) {
		if ((!$user_id || $user_id == $this->Auth->user('id')) && !isset($this->params['named']['conversation'])) {
			$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'));
		}
		
		if ($this->data) {
			App::import('Core', 'Sanitize');
			$message = Sanitize::clean($this->data['Message']['message']);
			$sender = $this->Auth->user('id');
			
			if (!empty($this->params['named']['conversation'])) {
			
				$recipient = $title = null;
				$conversation = $this->params['named']['conversation'];
			
			} else {
				$title = Sanitize::clean($this->data['Conversation']['title']);
				$recipient = $user_id;
				$conversation = null;
			}
			
			if ($this->Messaging->send($message, $recipient, $sender, $title, $conversation)) {
				$this->Session->setFlash(__('Your message has been sent', true));
				if ($conversation) {
					$this->redirect(array('plugin' => 'users', 'controller' => 'conversations', 'action' => 'show', $conversation));
				} else {
					$this->redirect(array('plugin' => 'users', 'controller' => 'users', 'action' => 'index'));
				}
			}
		}
		
		if ($user_id) {
			$this->Message->User->id = $user_id;
			$this->set('recipientName', $this->Message->User->field('username'));
		}
	}

}
?>