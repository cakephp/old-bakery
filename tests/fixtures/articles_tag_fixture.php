<?php
/* ArticlesTag Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class ArticlesTagFixture extends CakeTestFixture {
	var $name = 'ArticlesTag';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'tag_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'article_id'  => 1,
			'tag_id'  => 1
		),
	);
}
?>