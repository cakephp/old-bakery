<?php
/* ArticlePage Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class ArticlePageFixture extends CakeTestFixture {
	var $name = 'ArticlePage';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'article_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'page_number' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 3),
		'content' => array('type'=>'text', 'type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id'  => 1,
			'article_id'  => 1,
			'title'  => 'Page 1 : Lorem ipsum dolor sit amet',
			'page_number'  => 1,
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
		array(
			'id'  => 2,
			'article_id'  => 1,
			'title'  => 'Intro : Lorem ipsum dolor sit amet',
			'page_number'  => 0,
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>