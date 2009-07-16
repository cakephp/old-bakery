<?php
class Category extends AppModel {
	public $name = 'Category';
/*
	public $belongsTo = array(
		'Parent' => array(
			'className' => 'Category',
			'foreignKey' => 'parent_id',
		)
	);

	public $hasMany = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'category_id',
			'dependent' => false,
			'conditions' => array('Article.published' => true,'Article.deleted' => false),
			'fields' => array('id','title','slug'),
			'order' => 'Article.published DESC',
			'limit' => 10
		),
	//	'Featured'
	);
*/
}
?>