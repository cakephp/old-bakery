<?php
class Conversation extends UsersAppModel {
	public $useDbConfig = 'users_plugin';
	
	public $hasAndBelongsToMany = array(
		'Users.User' => array(
			'with' => 'Users.ConversationsUser',
		)
	);

	public $hasMany = array(
		'Users.Message'
	);

}
?>