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
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>