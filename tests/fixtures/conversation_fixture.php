<?php
/* Conversation Fixture generated on: 2009-07-20 11:07:14 : 1248081074 */
class ConversationFixture extends CakeTestFixture {
	var $name = 'Conversation';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'sender_id' => array('type'=>'integer', 'type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'recipient_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'sender_id'  => 1,
			'recipient_id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-07-20 11:11:06',
			'modified'  => '2009-07-20 11:11:06'
		),
	);
}
?>