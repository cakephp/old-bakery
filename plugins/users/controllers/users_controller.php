<?php
class UsersController extends UsersAppController {
	public function login() {
	}
	
	public function logout() {
		$this->redirect($this->Auth->logout());
	}
}
?>