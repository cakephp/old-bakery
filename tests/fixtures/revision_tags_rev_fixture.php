<?php

class RevisionTagsRevFixture extends CakeTestFixture {
	var $name = 'RevisionTagsRev';
	var $fields = array(	
			'version_id' => array('type' => 'integer','null' => false,'default' => NULL,'key' => 'primary'), 
			'version_created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
			'id' => array('type' => 'integer', 'null' => false,'default' => NULL), 
			'title' => array('type' => 'string', 'null' => false, 'default' => NULL)
	);
	
	var $records = array(
		array(
			'version_id' => 1, 
			'version_created' => '2008-12-24 11:00:01',
			'id' => 1,
			'title' => 'Fun'
		),
		array(
			'version_id' => 2, 
			'version_created' => '2008-12-24 11:00:02',
			'id' => 2,
			'title' => 'Hard'
		),
		array(
			'version_id' => 3, 
			'version_created' => '2008-12-24 11:00:03',
			'id' => 3,
			'title' => 'Tricks'
		),
		array(
			'version_id' => 4, 
			'version_created' => '2008-12-24 11:00:04',
			'id' => 3,
			'title' => 'Trick'
		),
		array(
			'version_id' => 5, 
			'version_created' => '2008-12-24 11:00:22',
			'id' => 4,
			'title' => 'News'
		),
	);
}

?>