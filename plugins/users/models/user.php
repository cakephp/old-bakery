<?php
class User extends UsersAppModel {
	public $useDbConfig = 'user_plug';
	public $displayField = 'username';
	public $hasMany = array(
		'StartedConversation' => array(
			'className' => 'Conversation',
			'foreignKey' => 'sender_id'
		),
		'ReceivedConversation' => array(
			'className' => 'Conversation',
			'foreignKey' => 'recipient_id'
		),
		'Messages'
	);
}
?>