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

}
?>