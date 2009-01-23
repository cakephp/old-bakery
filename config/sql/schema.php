<?php 
/* SVN FILE: $Id$ */
/* Bakery schema generated on: 2009-01-23 14:01:15 : 1232750775*/
class BakerySchema extends CakeSchema {
	var $name = 'Bakery';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $articles = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'slug' => array('type' => 'string', 'null' => false, 'length' => 200, 'key' => 'index'),
			'category_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'index'),
			'rate_count' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'rate_sum' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'viewed' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'version' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 45),
			'title' => array('type' => 'string', 'null' => false, 'length' => 200, 'key' => 'index'),
			'intro' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'comments' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 4),
			'body' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'isdraft' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
			'allow_comments' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
			'moderate_comments' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
			'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'multipage' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'published_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'deleted' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'deleted_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'key' => 'index'),
			'modified' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00', 'key' => 'index'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'DATE_INDEX' => array('column' => 'created', 'unique' => 0), 'MOD_INDEX' => array('column' => 'modified', 'unique' => 0), 'DRAFT_INDEX' => array('column' => 'isdraft', 'unique' => 0), 'USER_INDEX' => array('column' => 'user_id', 'unique' => 0), 'ARTICLE_INDEX' => array('column' => 'title', 'unique' => 0), 'SLUG_INDEX' => array('column' => 'slug', 'unique' => 0))
		);
	var $articles_tags = array(
			'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'tag_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'indexes' => array()
		);
	var $attachments = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'link' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'filesize' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'filetype' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'count' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $categories = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'parent_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'name' => array('type' => 'string', 'null' => false),
			'icon' => array('type' => 'string', 'null' => false),
			'description' => array('type' => 'text', 'null' => false),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $comment_types = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'public' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $comments = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'comment_type_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'comment_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'created' => array('type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'title' => array('type' => 'string', 'null' => false),
			'body' => array('type' => 'text', 'null' => false),
			'subscribed' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'published' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'PUBLISHED_INDEX' => array('column' => 'published', 'unique' => 0))
		);
	var $config = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'property' => array('type' => 'string', 'null' => false, 'length' => 64),
			'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $featured = array(
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
			'level_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $leafs = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'article_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'title' => array('type' => 'string', 'null' => false),
			'pagenum' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 3),
			'content' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $levels = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'value' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 3),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
		);
	var $profiles = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'key' => 'unique'),
			'published' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'location' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'interests' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'occupation' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'icq' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 20),
			'aim' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'yahoo' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'msnm' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'jabber' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'time_zone' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'birthday' => array('type' => 'date', 'null' => true, 'default' => NULL),
			'user_icon' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'signature' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'url' => array('type' => 'string', 'null' => true, 'default' => NULL),
			'bio' => array('type' => 'text', 'null' => true, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USER_ID_UNIQUE_INDEX' => array('column' => 'user_id', 'unique' => 1))
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
			'linked' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10),
			'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20),
			'keyname' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 20, 'key' => 'unique'),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'KEYNAME_UNIQUE_INDEX' => array('column' => 'keyname', 'unique' => 1))
		);
	var $users = array(
			'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'group_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'level_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
			'realname' => array('type' => 'string', 'null' => false),
			'username' => array('type' => 'string', 'null' => false, 'key' => 'unique'),
			'email' => array('type' => 'string', 'null' => false, 'key' => 'unique'),
			'psword' => array('type' => 'string', 'null' => false),
			'temppassword' => array('type' => 'string', 'null' => false),
			'tos' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
			'mail_comments' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
			'email_authenticated' => array('type' => 'boolean', 'null' => true, 'default' => NULL),
			'email_token' => array('type' => 'string', 'null' => false, 'length' => 45),
			'email_token_expires' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
			'display_name' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 1),
			'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'USERNAME_UNIQUE_INDEX' => array('column' => 'username', 'unique' => 1), 'EMAIL_UNIQUE_INDEX' => array('column' => 'email', 'unique' => 1))
		);
}
?>