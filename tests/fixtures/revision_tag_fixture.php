<?php
class RevisionTagFixture extends CakeTestFixture {
	var $name = 'RevisionTag';
	var $fields = array(
			'id' => array(
					'type' => 'integer', 
					'null' => false, 
					'default' => NULL, 
					'key' => 'primary'), 
			'title' => array('type' => 'string', 'null' => false, 'default' => NULL),
			'indexes' => array('PRIMARY' => array('column' => 'id')));
	
	var $records = array(
		array(
			'id' => 1, 
			'title' => 'Fun', 
		),
		array(
			'id' => 2, 
			'title' => 'Hard'
		),
		array(
			'id' => 3, 
			'title' => 'Trick'
		),
		array(
			'id' => 4, 
			'title' => 'News'
		),
	);
}
?>