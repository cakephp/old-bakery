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
			'title'  => 'Lorem ipsum dolor sit amet - draft edit',
			'content'  => 'Lorem ipsum dolor sit amet, aliquet feugiat - draft edit'
		),
	);
}
?>