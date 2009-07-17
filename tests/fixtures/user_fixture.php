<?php
/* UserPlugUser Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'username' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'email' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'psword' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'tmp_password' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'email_authenticated' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => NULL),
		'email_token' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'email_token_expires' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USERNAME_UNIQUE_INDEX' => array('column' => 'username', 'unique' => 1), 'EMAIL_UNIQUE_INDEX' => array('column' => 'email', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'username'  => 'Lorem ipsum dolor sit amet',
			'email'  => 'Lorem ipsum dolor sit amet',
			'psword'  => 'Lorem ipsum dolor sit amet',
			'tmp_password'  => 'Lorem ipsum dolor sit amet',
			'email_authenticated'  => 1,
			'email_token'  => 'Lorem ipsum dolor sit amet',
			'email_token_expires'  => '2009-07-17 22:40:54',
			'created'  => '2009-07-17 22:40:54',
			'modified'  => '2009-07-17 22:40:54'
		),
	);
}
?>