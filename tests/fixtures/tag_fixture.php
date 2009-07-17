<?php
/* Tag Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class TagFixture extends CakeTestFixture {
	var $name = 'Tag';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'linked' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => 0, 'length' => 10),
		'name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'keyname' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'KEYNAME_UNIQUE_INDEX' => array('column' => 'keyname', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'linked'  => 1,
			'name'  => 'Lorem ipsum dolor ',
			'keyname'  => 'Lorem ipsum dolor '
		),
	);
}
?>