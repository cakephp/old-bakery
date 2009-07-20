<?php
class Rating extends AppModel {
	public $name = 'Rating';
	public $validate = array(
		'value' => array(
			'numeric' => array('rule' => array('numeric')),
		),
	);

	public $belongsTo = array(
		'User' ,
		'Article'
	);
}
?>