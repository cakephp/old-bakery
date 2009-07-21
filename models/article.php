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
		'ArticlePage' => array(
			'dependent' => true,
			'conditions' => array('pagenum !=' => 0)),
	//	'Attachment',
	//	'Comment',
		'Rating'
	);
	
	public $hasAndBelongsToMany = array('Tag' => array(
		'fields' => array('id','name')
	));

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['title']) && !isset($this->data[$this->alias][$this->primaryKey])) {
			$this->data[$this->alias]['slug'] = Inflector::slug($this->data[$this->alias]['title']);
		}

		if (isset($this->data[$this->alias]['tags']) && !empty($this->data[$this->alias]['tags'])) {
			$tagIds = $this->Tag->saveArticleTags($this->data[$this->alias]['tags']);
			unset($this->data[$this->alias]['tags']);
			$this->data[$this->Tag->alias][$this->Tag->alias] = $tagIds;
		}

		if (isset($this->data[$this->alias]['published']) && $this->data[$this->alias]['published'])
			$this->set('published_date', date('Y-m-d H:i:s'));

		if (isset($this->data[$this->alias]['deleted']) && $this->data[$this->alias]['deleted'])
			$this->set('deleted_date', date('Y-m-d H:i:s'));

		return true;
	}

	public function publish($id){
		$this->set(array(
			'id' => $id,
			'published' => 1,
			'published_date' => date('Y-m-d H:i:s')
		));
		return $this->save();
	}

	public function published($id) {
		return $this->find('count', array('recursive' => -1,'conditions' => array(
			$this->primaryKey => $id,
			'published' => true,
			'deleted' => false
		)));
	}

	public function delete($id = null, $soft = true) {
		if (!empty($id)) {
            $this->id = $id;
        }
        $id = $this->id;
		if (!$this->exists())
			return null;
		if ($soft) {
			return $this->save(array(
				'id' => $id,
				'deleted' => true,
				'published' => false,
				'deleted_date' => date('Y-m-d H:i:s')
			),false);
		} else {
			$pageIDs = $this->ArticlePage->find('list',array(
				'fields' => array('id'),
				'recursive' => -1,
				'conditions' => array('article_id' => $id)));
			if (parent::delete($id)) {
				return $this->ArticlePage->ShadowModel->deleteAll(array('id' => $pageIDs));
			}
		}
	}
}
?>