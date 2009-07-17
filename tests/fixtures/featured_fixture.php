<?php
/* Featured Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class FeaturedFixture extends CakeTestFixture {
	var $name = 'Featured';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'category_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'published_date' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'end_date' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'article_id'  => 1,
			'category_id'  => 1,
			'published_date'  => '2009-07-17 22:40:54',
			'end_date'  => '2009-07-17 22:40:54',
			'created'  => '2009-07-17 22:40:54',
			'modified'  => '2009-07-17 22:40:54'
		),
	);
}
?>