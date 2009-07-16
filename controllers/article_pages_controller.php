<?php
class ArticlePagesController extends AppController {

	var $name = 'ArticlePages';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->ArticlePage->recursive = 0;
		$this->set('articlePages', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid ArticlePage.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('articlePage', $this->ArticlePage->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->data['ArticlePage']['article_id'] = $this->Session->read('Article');
			$this->ArticlePage->create($this->data);
			if ($this->ArticlePage->save()) {
				$this->Session->setFlash(__('The ArticlePage has been saved', true));
				$this->redirect(array('controller'=>'articles','action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ArticlePage could not be saved. Please, try again.', true));
			}
		}
		$articles = $this->ArticlePage->Article->find('list');
		$this->set(compact('articles'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ArticlePage', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ArticlePage->save($this->data)) {
				$this->Session->setFlash(__('The ArticlePage has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ArticlePage could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ArticlePage->read(null, $id);
		}
		$articles = $this->ArticlePage->Article->find('list');
		$this->set(compact('articles'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ArticlePage', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ArticlePage->del($id)) {
			$this->Session->setFlash(__('ArticlePage deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>