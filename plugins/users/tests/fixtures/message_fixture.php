<?php 
/* SVN FILE: $Id$ */
/* Message Fixture generated on: 2009-07-19 00:22:59 : 1247955779*/

class MessageFixture extends CakeTestFixture {
	public $table = 'messages';
	public $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'conversation_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'user_id' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'message' => array('type'=>'text', 'null' => false, 'default' => NULL),
		'new' => array('type' => 'boolean', 'null' => false, 'default' => true),
		'created' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'fk_messages_conversations' => array('column' => 'conversation_id', 'unique' => 0), 'fk_messages_temps1' => array('column' => 'user_id', 'unique' => 0))
	);
	public $records = array(
		array(
			'id'  => 1,
			'conversation_id'  => 1,
			'user_id'  => 6,
			'message'  => 'I am experiencing glitches when publishing an article. Can you please look at this?',
			'new' => false,
			'created'  => '2009-07-19 00:22:59',
			'modified'  => '2009-07-19 00:22:59'
		),
		array(
			'id'  => 2,
			'conversation_id'  => 1,
			'user_id'  => 1,
			'message'  => 'What kind of glitches?',
			'new' => false,
			'created'  => '2009-07-19 00:23:59',
			'modified'  => '2009-07-19 00:23:59'
		),
		array(
			'id'  => 3,
			'conversation_id'  => 1,
			'user_id'  => 6,
			'message'  => 'Well, you know, glitches.',
			'new' => false,
			'created'  => '2009-07-19 00:28:59',
			'modified'  => '2009-07-19 00:28:59'
		),
		array(
			'id'  => 4,
			'conversation_id'  => 1,
			'user_id'  => 1,
			'message'  => 'No, I do not know. Please tell me.',
			'new' => false,
			'created'  => '2009-07-19 00:30:59',
			'modified'  => '2009-07-19 00:30:59'
		),
		array(
			'id'  => 5,
			'conversation_id'  => 1,
			'user_id'  => 6,
			'message'  => 'Never mind, it is solved itself.',
			'new' => true,
			'created'  => '2009-07-19 00:33:59',
			'modified'  => '2009-07-19 00:33:59'
		),
		array(
			'id'  => 6,
			'conversation_id'  => 2,
			'user_id'  => 6,
			'message'  => 'Yo dude, there are like 8000 spammers on the Bakery... Do something about it!',
			'new' => false,
			'created'  => '2009-07-19 00:34:59',
			'modified'  => '2009-07-19 00:34:59'
		),
		array(
			'id'  => 7,
			'conversation_id'  => 2,
			'user_id'  => 1,
			'message'  => 'Yeah, that was me testing something. Sorry.',
			'new' => true,
			'created'  => '2009-07-19 00:35:59',
			'modified'  => '2009-07-19 00:35:59'
		),
		array(
			'id'  => 8,
			'conversation_id'  => 3,
			'user_id'  => 1,
			'message'  => 'Hi! Do you have any plans for the upcomming release? Regards, Me',
			'new' => false,
			'created'  => '2009-07-19 00:36:59',
			'modified'  => '2009-07-19 00:36:59'
		),
		array(
			'id'  => 9,
			'conversation_id'  => 3,
			'user_id'  => 3,
			'message'  => 'Of course, but I am not going to tell you.',
			'new' => false,
			'created'  => '2009-07-19 00:37:59',
			'modified'  => '2009-07-19 00:37:59'
		),
		array(
			'id'  => 10,
			'conversation_id'  => 4,
			'user_id'  => null,
			'message'  => 'You have received a comment on your article.',
			'new' => true,
			'created'  => '2009-07-19 00:40:59',
			'modified'  => '2009-07-19 00:40:59'
		)
	);
}
?>