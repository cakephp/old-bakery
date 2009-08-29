<?php 
class ConversationsUserFixture extends CakeTestFixture {
	public $table = 'conversations_users';
	
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'conversation_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'new' => array('type' => 'boolean', 'null' => false, 'default' => true),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_conversations_users_conversations' => array('column' => 'conversation_id', 'unique' => 0), 'fk_conversations_users_users' => array('column' => 'user_id', 'unique' => 0))
	);
	
	public $records = array(
		array(
			'id'  => 1,
			'conversation_id' => 1,
			'user_id' => 1,
			'new' => true,
			'created'  => '2009-07-19 00:22:13',
			'modified'  => '2009-07-19 00:22:13'
		),
		array(
			'id'  => 2,
			'conversation_id' => 1,
			'user_id' => 6,
			'new' => false,
			'created'  => '2009-07-19 00:22:13',
			'modified'  => '2009-07-19 00:22:13'
		),
		array(
			'id'  => 3,
			'conversation_id' => 2,
			'user_id' => 1,
			'new' => true,
			'created'  => '2009-07-19 00:24:13',
			'modified'  => '2009-07-19 00:24:13'
		),
		array(
			'id'  => 4,
			'conversation_id' => 2,
			'user_id' => 6,
			'new' => false,
			'created'  => '2009-07-19 00:24:13',
			'modified'  => '2009-07-19 00:24:13'
		),
	);
}
?>