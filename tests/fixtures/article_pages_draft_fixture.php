<?php
class ArticlePagesDraftFixture extends CakeTestFixture {
	var $name = 'ArticlePagesDraft';

	var $fields = array(
		'draft_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'content' => array('type'=>'text', 'type' => 'text', 'null' => true, 'default' => NULL),
	);

	var $records = array(
		array(
			'draft_id'  => 1,
			'id'  => 1,
			'title'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.'
		),
	);
}
?>