<?php
class ArticlePage extends AppModel {

	public $name = 'ArticlePage';
	public $actsAs = array(
		'Drafted' => array('fields' => array('title','content')),
		'Revision'
	);

	public $belongsTo = array(
		'Article' => array(
			'counterCache' => true,
			'counterScope' => array('pagenum !=' => 0),
			'fields' => array('id','title','slug')
		)
	);

	public function create($data = array()) {
		if (isset($data[$this->alias])) {
			if (!isset($data[$this->alias]['pagenum']) && isset($data[$this->alias]['article_id'])) {
				$this->Article->id = $data[$this->alias]['article_id'];
				$data[$this->alias]['pagenum'] = $this->Article->field('article_page_count')+1;
			}
		} else {
			// if alias level is not used
		}
		return parent::create($data);
	}
}
?>