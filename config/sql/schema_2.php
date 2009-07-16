<?php 
/* SVN FILE: $Id$ */
/* Bakery schema generated on: 2009-07-16 13:07:39 : 1247745219*/
class BakerySchema extends CakeSchema {
	var $name = 'Bakery';

	var $file = 'schema_2.php';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $article_pages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'pagenum' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $articles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'lang' => array('type' => 'string', 'null' => false, 'default' => 'eng', 'length' => 5),
		'slug' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'key' => 'index'),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
		'rate_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'rate_sum' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'viewed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'key' => 'index'),
		'comment_count' => array('type' => 'integer', 'null' => false, 'default' => '0'),
		'article_page_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'published_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'deleted_date' => array('type' => 'date', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'DATE_INDEX' => array('column' => 'created', 'unique' => 0), 'MOD_INDEX' => array('column' => 'modified', 'unique' => 0), 'USER_INDEX' => array('column' => 'user_id', 'unique' => 0), 'ARTICLE_INDEX' => array('column' => 'title', 'unique' => 0), 'SLUG_INDEX' => array('column' => 'slug', 'unique' => 0))
	);
	var $articles_tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'tag_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'linked' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'keyname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'KEYNAME_UNIQUE_INDEX' => array('column' => 'keyname', 'unique' => 1))
	);
}
?>