<?php
class GroupFixture extends CakeTestFixture {
	public $name = 'Group';

	public $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	
	public $records = array(
		array('id' => 0, 'name' => 'Guests'),
		array('id' => 10, 'name' => 'Registered users'),
		array('id' => 20, 'name' => 'Accepted authors'),
		array('id' => 50, 'name' => 'Moderators'),
		array('id' => 60, 'name' => 'Editors'),
		array('id' => 80, 'name' => 'CakePHP developers'),
		array('id' => 100, 'name' => 'Administrators'),
	);
}
?>