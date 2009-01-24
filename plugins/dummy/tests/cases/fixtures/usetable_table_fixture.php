<?php
class UsetableTableFixture extends CakeTestFixture {
    var $name = 'UsetableTable';
    
    var $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'title' => array('type' => 'string', 'length' => 255, 'null' => false), 
    );
    var $records = array(
		array('id' => 1, 'title' => 'First Table' ),
		array('id' => 2, 'title' => 'Second Table' )
	);
}
?>