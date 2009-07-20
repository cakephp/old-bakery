<?php
class UsersController extends UsersAppController {
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->autoRedirect = false;
	}
	
	public function login() {
		if ($this->data) {
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