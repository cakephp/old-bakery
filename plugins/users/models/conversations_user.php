<?php
class ConversationsUser extends UsersAppModel {
	public $useDbConfig = 'users_plugin';
	
	public $belongsTo = array(
		'Users.Conversation',
		'Users.User'
	);
}
?>