<?php
/* ArticlePageRev Fixture generated on: 2009-07-17 22:07:54 : 1247863254 */
class ArticlePagesRevFixture extends CakeTestFixture {
	var $name = 'ArticlePagesRev';

	var $fields = array(
		'version_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'version_created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'content' => array('type'=>'text', 'type' => 'text', 'null' => true, 'default' => NULL),
	);

	var $records = array(
		array(
			'version_id'  => 1,
			'version_created' => '2009-01-01 05:05:05',
			'id'  => 1,
			'title'  => 'Page 1 : Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
		array(
			'version_id'  => 2,
			'version_created' => '2009-01-01 06:06:06',
			'id'  => 2,
			'title'  => 'Intro : Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
		array(
			'version_id'  => 3,
			'version_created' => '2009-01-01 07:07:07',
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet - draft edit',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat - draft edit'
		),
	);
}
?>