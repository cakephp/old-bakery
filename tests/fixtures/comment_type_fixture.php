<?php
/* CommentType Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class CommentTypeFixture extends CakeTestFixture {
	var $name = 'CommentType';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'public' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor ',
			'public'  => 1
		),
	);
}
?>