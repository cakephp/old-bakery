<?php
class RevisionCommentsRevisionTagFixture extends CakeTestFixture {
	var $name = 'RevisionCommentsRevisionTag';
	var $fields = array(
			'id' => array(
					'type' => 'integer', 
					'null' => false, 
					'default' => NULL, 
					'key' => 'primary'), 
			'revision_comment_id' => array('type' => 'integer', 'null' => false),  
			'revision_tag_id' => array('type' => 'integer', 'null' => false),  
			'indexes' => array('PRIMARY' => array('column' => 'id')));
	
	var $records = array(
		array(
			'id' => 1, 
			'revision_comment_id' => 1, 
			'revision_tag_id' => 1
		),
		array(
			'id' => 2, 
			'revision_comment_id' => 1, 
			'revision_tag_id' => 2
		),
		array(
			'id' => 3, 
			'revision_comment_id' => 1, 
			'revision_tag_id' => 3
		),
		array(
			'id' => 4, 
			'revision_comment_id' => 2, 
			'revision_tag_id' => 1
		),
		array(
			'id' => 5, 
			'revision_comment_id' => 2, 
			'revision_tag_id' => 3
		),
	);
}
?>