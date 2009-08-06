<?php
class ConversationsController extends UsersAppController {

	public function index() {
		$this->paginate = array(
			'fields' => array(
				'new',
				'modified'
			),
			'conditions' => array(
				'ConversationsUser.user_id' => $this->Auth->user('id')
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'id',
						'title'
					)
				)
			),
			'order' => array(
				'ConversationsUser.modified' => 'DESC'
			)
		);
		
		$this->set('conversations', $this->paginate($this->Conversation->ConversationsUser));
	}
	
	public function show($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Select a valid conversation to read.', true));
			$this->redirect(array('plugin' => 'users', 'controller' => 'conversations', 'action' => 'index'));
		}
		
		$conversation = $this->Conversation->ConversationsUser->find('first', array(
			'fields' => array(
				'id',
				'conversation_id',
				'user_id'
			),
			'conditions' => array(
				'ConversationsUser.user_id' => $this->Auth->user('id'),
				'ConversationsUser.conversation_id' => $id
			),
			'contain' => array(
				'Conversation' => array(
					'fields' => array(
						'id',
						'title'
					)
				)
			)
		));
		
		if (!$conversation) {
			$this->Session->setFlash(__('Select a valid conversation to read.', true));
			$this->redirect(array('plugin' => 'users', 'controller' => 'conversations', 'action' => 'index'));
		}
		
		$this->paginate = array(
			'fields' => array(
				'id',
				'conversation_id',
				'user_id',
				'message',
				'created'
			),
			'conditions' => array(
				'Message.conversation_id' => $id
			),
			'contain' => array(
				'User' => array(
					'fields' => array(
						'id',
						'username'
					)
				)
			),
			'order' => array(
				'Message.created' => 'ASC'
			)
		);
		
		$messages = $this->paginate($this->Conversation->Message);
		
		$this->set(compact('conversation', 'messages'));
	}

}
?>