<?php 
/* SVN FILE: $Id$ */
/* Conversation Fixture generated on: 2009-07-19 00:22:13 : 1247955733*/

class ConversationFixture extends CakeTestFixture {
	public $table = 'conversations';
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'sender_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'recipient_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'title' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	public $records = array(array(
		'id'  => 1,
		'sender_id'  => 1,
		'recipient_id'  => 1,
		'title'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-07-19 00:22:13',
		'modified'  => '2009-07-19 00:22:13'
	));
}
?>