<?php
class UserFixture extends CakeTestFixture {
	public $name = 'User';
	
	public $import = array('model' => 'Users.User', 'records' => false);
	
	public $records = array(
		array('id' => 1, 'group_id' => 100, 'realname' => 'Frank de Graaf', 'username' => 'Phally', 'email' => 'phally@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-20 03:16:52', 'modified' => '2009-06-20 03:16:56'),
		array('id' => 2, 'group_id' => 10, 'realname' => 'Registered User', 'username' => 'Registered', 'email' => 'registered@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-21 03:16:52', 'modified' => '2009-06-21 03:16:56'),
		array('id' => 3, 'group_id' => 80, 'realname' => 'Core Developer', 'username' => 'coredev', 'email' => 'coredev@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-22 03:16:52', 'modified' => '2009-06-22 03:16:56'),
		array('id' => 4, 'group_id' => 100, 'realname' => 'Admini Strator', 'username' => 'admini', 'email' => 'admini@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-23 03:16:52', 'modified' => '2009-06-23 03:16:56'),
		array('id' => 5, 'group_id' => 20, 'realname' => 'Accepted Author', 'username' => 'accepted', 'email' => 'accepted@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-24 03:16:52', 'modified' => '2009-06-24 03:16:56'),
		array('id' => 6, 'group_id' => 50, 'realname' => 'Moderating Dude', 'username' => 'moddy', 'email' => 'moddy@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-25 03:16:52', 'modified' => '2009-06-25 03:16:56'),
		array('id' => 7, 'group_id' => 60, 'realname' => 'Editing Dude', 'username' => 'editeur', 'email' => 'editeur@example.com', 'psword' => '86a8c2da8527a1c6978bdca6d7986fe14ae147fe', 'email_authenticated' => true, 'email_token' => null, 'email_token_expires' => null, 'created' => '2009-06-26 03:16:52', 'modified' => '2009-06-26 03:16:56')
	);
}
?>