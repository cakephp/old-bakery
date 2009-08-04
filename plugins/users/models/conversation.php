<?php
class Conversation extends UsersAppModel {
	public $useDbConfig = 'users_plugin';
	
	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a title.'
			),
			'maxlength' => array(
				'rule' => array('maxLength', 100),
				'message' => 'Your title can\'t be longer than 100 characters.'
			)
		)
	);
	
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