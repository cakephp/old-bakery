<?php 
class UsersSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after($event = array()) {
	}

	public $users_plugin_users = array(
		
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
}
?>