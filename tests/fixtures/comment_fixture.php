<?php
/* Comment Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class CommentFixture extends CakeTestFixture {
	var $name = 'Comment';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'comment_type_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'article_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'comment_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'user_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => NULL),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'body' => array('type'=>'text', 'type' => 'text', 'null' => false, 'default' => NULL),
		'subscribed' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'published' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0', 'key' => 'index'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'PUBLISHED_INDEX' => array('column' => 'published', 'unique' => 0))
	);

	var $records = array(
		array(
			'id'  => 1,
			'comment_type_id'  => 1,
			'article_id'  => 1,
			'comment_id'  => 1,
			'user_id'  => 1,
			'created'  => '2009-07-17 22:40:54',
			'title'  => 'Lorem ipsum dolor sit amet',
			'body'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'subscribed'  => 1,
			'published'  => 1
		),
	);
}
?>