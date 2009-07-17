<?php
/* Article Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class ArticleFixture extends CakeTestFixture {
	var $name = 'Article';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type'=>'integer', 'type' => 'integer', 'null' => true, 'default' => NULL),
		'lang' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => 'eng', 'length' => 5),
		'slug' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'key' => 'index'),
		'category_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'user_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
		'rate_count' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'rate_sum' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'viewed' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'key' => 'index'),
		'comment_count' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'article_page_count' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'published' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'published_date' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type'=>'date', 'type' => 'date', 'null' => true, 'default' => NULL),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'DATE_INDEX' => array('column' => 'created', 'unique' => 0), 'MOD_INDEX' => array('column' => 'modified', 'unique' => 0), 'USER_INDEX' => array('column' => 'user_id', 'unique' => 0), 'ARTICLE_INDEX' => array('column' => 'title', 'unique' => 0), 'SLUG_INDEX' => array('column' => 'slug', 'unique' => 0))
	);

	var $records = array(
		array(
			'id'  => 1,
			'parent_id'  => 1,
			'lang'  => 'Lor',
			'slug'  => 'Lorem ipsum dolor sit amet',
			'category_id'  => 1,
			'user_id'  => 1,
			'rate_count'  => 1,
			'rate_sum'  => 1,
			'viewed'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'comment_count'  => 1,
			'article_page_count'  => 1,
			'published'  => 1,
			'published_date'  => '2009-07-17 22:40:54',
			'deleted'  => 1,
			'deleted_date'  => '2009-07-17',
			'created'  => '2009-07-17 22:40:54',
			'modified'  => '2009-07-17 22:40:54'
		),
	);
}
?>