<?php
class User extends UsersAppModel {
	public $useDbConfig = 'users_plugin';
	public $displayField = 'username';
	
	public $hasMany = array(
		'Users.Message',
		'Users.ConversationsUser'
	);
}
?>