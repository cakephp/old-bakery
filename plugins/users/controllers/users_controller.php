<?php
class UsersController extends UsersAppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->autoRedirect = false;
	}
	
	public function index() {	
		$this->paginate = array(
			'order' => array($this->Auth->fields['username'] => 'ASC'),
			'limit' => 50
		);
		
		if (!empty($this->params['named']['keyword'])) {
			$this->paginate['conditions'] = array('User.' . $this->Auth->fields['username'] . ' LIKE ' => '%' . $this->params['named']['keyword'] . '%');
		}
		
		$this->set('users', $this->paginate());
	}
	
	public function search() {
		$this->redirect(array('action' => 'index', 'keyword' => (!empty($this->data['User']['keyword']) ? $this->data['User']['keyword'] : null)));
	}
	
	public function login() {
		if ($this->data && $this->Auth->user()) {
			$this->Access->setRememberCookie($this->data);
			$this->redirect($this->Auth->redirect());
		}
	}
	
	public function logout() {
		$this->Access->deleteRememberCookie();
		$this->redirect($this->Auth->logout());
	}
}
?>