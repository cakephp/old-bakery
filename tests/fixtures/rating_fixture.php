<?php
/* Rating Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class RatingFixture extends CakeTestFixture {
	var $name = 'Rating';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'article_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'value' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'user_id'  => 1,
			'article_id'  => 1,
			'value'  => 1,
			'created'  => '2009-07-17 22:40:54'
		),
		array(
			'id'  => 2,
			'user_id'  => 2,
			'article_id'  => 1,
			'value'  => 3,
			'created'  => '2009-07-17 22:20:54'
		),
	);
}
?>