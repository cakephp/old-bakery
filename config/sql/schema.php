<?php 
/* SVN FILE: $Id$ */
/* Bakery schema generated on: 2009-07-20 11:07:43 : 1248080743*/
class BakerySchema extends CakeSchema {
	var $name = 'Bakery';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $article_page_drafts = array(
		'draft_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'draft_id', 'unique' => 1))
	);
	var $article_page_revs = array(
		'version_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'version_id', 'unique' => 1))
	);
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
	var $attachments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'link' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'filesize' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'filetype' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $categories = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'parent_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'icon' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'description' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $comment_types = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'public' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $comments = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'comment_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'comment_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'body' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'subscribed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'published' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'PUBLISHED_INDEX' => array('column' => 'published', 'unique' => 0))
	);
	var $conversations = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'sender_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
		'recipient_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'title' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $dum_dummy_fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'tablename' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'field_type' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'allow_null' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'default' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'custom_min' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'custom_max' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'custom_variable' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $dum_dummy_tables = array(
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'active' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'number' => array('type' => 'integer', 'null' => false, 'default' => '10', 'length' => 6),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'name', 'unique' => 1))
	);
	var $featureds = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'published_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'end_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $groups = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $messages = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'author_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'content' => array('type' => 'text', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $ratings = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'value' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $tags = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'linked' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'keyname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'KEYNAME_UNIQUE_INDEX' => array('column' => 'keyname', 'unique' => 1))
	);
	var $user_plug_users = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'username' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'email' => array('type' => 'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'psword' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'tmp_password' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'email_authenticated' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'email_token' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
		'email_token_expires' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USERNAME_UNIQUE_INDEX' => array('column' => 'username', 'unique' => 1), 'EMAIL_UNIQUE_INDEX' => array('column' => 'email', 'unique' => 1))
	);
	var $user_profiles = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'unique'),
		'group_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'location' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'time_zone' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'user_icon' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'signature' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'url' => array('type' => 'string', 'null' => true, 'default' => NULL),
		'realname' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'bio' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USER_ID_UNIQUE_INDEX' => array('column' => 'user_id', 'unique' => 1))
	);
}
?>