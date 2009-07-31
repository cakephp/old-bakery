<?php
class Conversation extends UsersAppModel {
	public $useDbConfig = 'user_plug';
	
	public $belongsTo = array(
		'Sender' => array(
			'className' => 'Users.User',
			'foreignKey' => 'sender_id',
		),
		'Recipient' => array(
			'className' => 'Users.User',
			'foreignKey' => 'recipient_id',
		)
	);

	public $hasMany = array(
		'Message'
	);

}
?>