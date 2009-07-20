<?php

class RevisionCommentFixture extends CakeTestFixture {
	var $name = 'RevisionComment';
	var $fields = array(
			'id' => array(
					'type' => 'integer', 
					'null' => false, 
					'default' => NULL, 
					'key' => 'primary'), 
			'title' => array('type' => 'string', 'null' => false, 'default' => NULL), 
			'content' => array('type' => 'text', 'null' => false, 'default' => NULL), 
			'indexes' => array('PRIMARY' => array('column' => 'id')));
	var $records = array(
		array(
			'id' => 1, 
			'title' => 'Comment 1', 
			'content' => 'Lorem ipsum dolor sit amet, aliquet feugiat.', 
		),
		array(
			'id' => 2, 
			'title' => 'Comment 2', 
			'content' => 'Lorem ipsum dolor sit.', 
		),
		array(
			'id' => 3, 
			'title' => 'Comment 3', 
			'content' => 'Lorem ipsum dolor sit.', 
		),
	);
}
?>