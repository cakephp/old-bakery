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
			'fields' => array('id','title','slug')
		),
		'Category' => array(
			'fields' => array('id','name')
		),
		'User' => array(
			'className' => 'Users.User',
			'fields' => array('id','username')
		)
	);
	
	public $hasOne = array(
		'Intro' => array(
			'className' => 'ArticlePage',
			'foreignKey' => 'article_id',
			'dependent' => true,
			'conditions' => array('pagenum' => 0),
			'fields' => array('id','content')
		)
	);

	public $hasMany = array(
		'ArticlePage' => array('conditions' => array('pagenum !=' => 0))
	//	'Attachment',
	//	'Comment',
	//	'Rating'
	);
/**
 *  Coderip from 2.0.x.x branch
 *
 *
	public $hasAndBelongsToMany = array('Tag');

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['tags'])) {
			$tagIds = $this->Tag->saveArticleTags($this->data[$this->alias]['tags']);
			unset($this->data[$this->alias]['tags']);
			$this->data[$this->Tag->alias][$this->Tag->alias] = $tagIds;
		}
	}
 */

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['title']) && !isset($this->data[$this->alias][$this->primaryKey])) {
			$this->data[$this->alias]['slug'] = Inflector::slug($this->data[$this->alias]['title']);
		}

		return true;
	}
}
?>