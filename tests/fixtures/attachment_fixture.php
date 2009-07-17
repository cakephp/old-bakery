<?php
/* Attachment Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class AttachmentFixture extends CakeTestFixture {
	var $name = 'Attachment';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'link' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'filesize' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'filetype' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'count' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'article_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'link'  => 'Lorem ipsum dolor sit amet',
			'filesize'  => 'Lorem ipsum dolor sit amet',
			'filetype'  => 'Lorem ipsum dolor sit amet',
			'count'  => 1
		),
	);
}
?>