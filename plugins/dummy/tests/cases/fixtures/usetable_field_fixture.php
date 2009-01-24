<?php
class UsetableFieldFixture extends CakeTestFixture {
    var $name = 'UsetableField';
    
    var $fields = array(
        'id' => array('type' => 'integer', 'key' => 'primary'),
        'title' => array('type' => 'string', 'length' => 255, 'null' => false),
        'usetable_table_id' => array('type' => 'integer', 'null' => false)        
    );
    var $records = array(
		array('id' => 1, 'title' => 'Sixth Field', 'usetable_table_id' => 1 ),
		array('id' => 2, 'title' => 'Fifth Field', 'usetable_table_id' => 1 ),
		array('id' => 3, 'title' => 'First Field', 'usetable_table_id' => 1 ),
		array('id' => 4, 'title' => 'Second Field','usetable_table_id' => 2 ),
		array('id' => 5, 'title' => 'Third Field', 'usetable_table_id' => 2 ),
		array('id' => 6, 'title' => 'Fourth Field','usetable_table_id' => 2 )
    );
}
?>
