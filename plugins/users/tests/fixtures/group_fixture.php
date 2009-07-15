<?php
class GroupFixture extends CakeTestFixture {
	public $name = 'Group';

	public $import = array('model' => 'Users.Group', 'records' => false);
	
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