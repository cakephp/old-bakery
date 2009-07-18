<?php 
/* SVN FILE: $Id$ */
/* Message Fixture generated on: 2009-07-19 00:22:59 : 1247955779*/

class MessageFixture extends CakeTestFixture {
	public $table = 'messages';
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'conversation_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'message' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_messages_conversations' => array('column' => 'conversation_id', 'unique' => 0), 'fk_messages_temps1' => array('column' => 'user_id', 'unique' => 0))
	);
	public $records = array(array(
		'id'  => 1,
		'conversation_id'  => 1,
		'user_id'  => 1,
		'message'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
		'created'  => '2009-07-19 00:22:59',
		'modified'  => '2009-07-19 00:22:59'
	));
}
?>