<?php
class ArticlePage extends AppModel {

	public $name = 'ArticlePage';
	public $actsAs = array(
		'Revision',
		'Draft'
	);

	public $belongsTo = array(
		'Article' => array(
			'className' => 'Article',
			'foreignKey' => 'article_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>