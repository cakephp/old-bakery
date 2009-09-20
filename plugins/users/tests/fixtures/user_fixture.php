<?php
class UserFixture extends CakeTestFixture {
	public $name = 'User';
	
	public $fields = array(
		// Primary identifier.
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		
		// Permission group id.
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		
		// Login details.
		'username' => array('type' => 'string', 'null' => false, 'key' => 'unique'),
		'password' => array('type' => 'string', 'null' => false),
		
		// E-mail details.
		'email' => array('type' => 'string', 'null' => false, 'key' => 'unique'),
		'email_authenticated' => array('type' => 'boolean', 'null' => false),
		
		// Time details.
		'last_login' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	
	public $records = array(
		array('id' => 1, 'group_id' => 100, 'username' => 'Phally', 'email' => 'phally@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-20 03:16:52', 'modified' => '2009-06-20 03:16:56'),
		array('id' => 2, 'group_id' => 10, 'username' => 'Registered', 'email' => 'registered@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-21 03:16:52', 'modified' => '2009-06-21 03:16:56'),
		array('id' => 3, 'group_id' => 80, 'username' => 'coredev', 'email' => 'coredev@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-22 03:16:52', 'modified' => '2009-06-22 03:16:56'),
		array('id' => 4, 'group_id' => 100, 'username' => 'admini', 'email' => 'admini@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-23 03:16:52', 'modified' => '2009-06-23 03:16:56'),
		array('id' => 5, 'group_id' => 20, 'username' => 'accepted', 'email' => 'accepted@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-24 03:16:52', 'modified' => '2009-06-24 03:16:56'),
		array('id' => 6, 'group_id' => 50, 'username' => 'moddy', 'email' => 'moddy@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-25 03:16:52', 'modified' => '2009-06-25 03:16:56'),
		array('id' => 7, 'group_id' => 60, 'username' => 'editeur', 'email' => 'editeur@example.com', 'password' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'created' => '2009-06-26 03:16:52', 'modified' => '2009-06-26 03:16:56')
	);
}
?>