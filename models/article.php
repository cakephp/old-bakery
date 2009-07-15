<?php
class Article extends AppModel {

	public $name = 'Article';
	/*
	var $validate = array(
		'lang' => array('notempty'),
		'slug' => array('notempty'),
		'category_id' => array('numeric'),
		'user_id' => array('numeric'),
		'rate_count' => array('numeric'),
		'rate_sum' => array('numeric'),
		'viewed' => array('numeric'),
		'title' => array('notempty'),
		'comment_count' => array('numeric'),
		'published' => array('numeric'),
		'deleted' => array('numeric')
	);
*/

	public $belongsTo = array(
		'Parent' => array(
			'className' => 'Article',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'Users.User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasOne = array(
		'Intro' => array(
			'className' => 'ArticlePage',
			'foreignKey' => 'article_id',
			'dependent' => true,
			'conditions' => array('pagenum' => 0),
		)
	);

	var $hasMany = array(
		'ArticlePage' => array(
			'className' => 'ArticlePage',
			'foreignKey' => 'article_id',
			'dependent' => true,
			'conditions' => array('pagenum !=' => 0),
			'fields' => '',
			'order' => 'pagenum',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	/**	'Attachment' => array(
			'className' => 'Attachment',
			'foreignKey' => 'article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Featured' => array(
			'className' => 'Featured',
			'foreignKey' => 'article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Rating' => array(
			'className' => 'Rating',
			'foreignKey' => 'article_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)*/
	);
/*
	var $hasAndBelongsToMany = array(
		'Tag' => array(
			'className' => 'Tag',
			'joinTable' => 'articles_tags',
			'foreignKey' => 'article_id',
			'associationForeignKey' => 'tag_id',
			'unique' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
*/
}
?>