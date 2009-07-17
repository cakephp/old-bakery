<?php
/* UserProfile Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class UserProfileFixture extends CakeTestFixture {
	var $name = 'UserProfile';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'unique'),
		'group_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL),
		'location' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'time_zone' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'user_icon' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'signature' => array('type'=>'text', 'type' => 'text', 'null' => true, 'default' => NULL),
		'url' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'realname' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'bio' => array('type'=>'text', 'type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USER_ID_UNIQUE_INDEX' => array('column' => 'user_id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'user_id'  => 1,
			'group_id'  => 1,
			'location'  => 'Lorem ipsum dolor sit amet',
			'time_zone'  => 'Lorem ipsum dolor sit amet',
			'user_icon'  => 'Lorem ipsum dolor sit amet',
			'signature'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'url'  => 'Lorem ipsum dolor sit amet',
			'realname'  => 'Lorem ipsum dolor sit amet',
			'bio'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>