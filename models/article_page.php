<?php
class ArticlePage extends AppModel {

	public $name = 'ArticlePage';
	public $actsAs = array(
		'Revision',
		'Drafted' => array('fields' => array('title','content'))
	);

	public $belongsTo = array(
		'Article' => array(
			'counterCache' => true,
			'counterScope' => array('page_number !=' => 0),
			'fields' => array('id','title','slug'),
			'dependent' => true
		)
	);

	public function create($data = array()) {
		if (isset($data[$this->alias])) {
			if (!isset($data[$this->alias]['page_number']) && isset($data[$this->alias]['article_id'])) {
				$this->Article->id = $data[$this->alias]['article_id'];
				$data[$this->alias]['page_number'] = $this->Article->field('article_page_count')+1;
			}
		} else {
			// if alias level is not used
		}
		return parent::create($data);
	}
}
?>