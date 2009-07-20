<?php
class Message extends AppModel {
	public $useDbConfig = 'user_plug';
	
	public $belongsTo = array(
		'Users.Conversation', 
		'Users.User'
	);
}
?>