<?php
class User extends UsersAppModel {
	public $useDbConfig = 'users_plugin';
	public $displayField = 'username';
	
	public $hasAndBelongsToMany = array(
		'Users.Conversation' => array(
			'with' => 'Users.ConversationsUser'
		)
	);
	
	public $hasMany = array(
		'Users.Message'
	);
}
?>