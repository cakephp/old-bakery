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
	
	public function acceptAllChangesToArticle($articleId) {
		$this->DraftModel->alias = 'Draft';
		$idlist = $this->DraftModel->find('all', array(
			'fields' => array('Draft.id','Draft.title','Draft.draft_id','Draft.content','Live.id','Live.title','Live.content','Live.article_id'),
			'conditions' => array('Live.article_id' => $articleId),
			'joins' => array(
				array(
					'table' => $this->tablePrefix.$this->table,
					'alias' => 'Live',
					'type' => 'left',
					'foreignKey' => false,
					'conditions'=> array('Draft.id = Live.id')
				)
			)
		));
		$this->DraftModel->alias = $this->alias;
		$this->Behaviors->disable('Revision');
		foreach ($idlist as $page) {
			$this->acceptDraft($page['Live']['id']);
		}
		$this->Behaviors->enable('Revision');
	//	debug($idlist);
	}

}
?>