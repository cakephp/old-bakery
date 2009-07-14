<?php
class UsersAppController extends AppController {
	public $components = array('Auth', 'Users.Access');
	
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Access->salt = false;
		$this->Auth->fields = array('username' => 'username', 'password' => 'psword');
	}
}
?>