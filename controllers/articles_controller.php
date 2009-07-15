<?php
class ArticlesController extends AppController {

	var $name = 'Articles';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Article->recursive = 0;
		$this->set('articles', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Article.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('article', $this->Article->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Article->create($this->data);
			$this->Article->set('user_id', 1); /* @todo change to logged in user */
			$this->Article->Intro->create($this->data);
			if ($this->Article->validates() && $this->Article->Intro->validates()) {
				$this->Article->save(null,false);
				$this->Article->Intro->set('article_id',$this->Article->id);
				$this->Article->Intro->save(null,false);

				$this->Session->write('Article',$this->Article->id);
				$this->redirect(array('controller'=>'article_pages','action'=>'add','page'=>1));
		/*		$this->Session->setFlash(__('The Article has been saved', true));
				$this->redirect(array('action'=>'index'));*/
			} else {
				$this->Session->setFlash(__('The Article could not be saved. Please, try again.', true));
			}
		}
		$parents = $this->Article->find('list');
		$categories = $this->Article->Category->find('list');
		$this->set(compact('parents', 'categories'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Article', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Article->save($this->data)) {
				$this->Session->setFlash(__('The Article has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Article could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Article->read(null, $id);
		}
		$parents = $this->Article->Parent->find('list');
		$categories = $this->Article->Category->find('list');
		$users = $this->Article->User->find('list');
		$this->set(compact('parents','categories','users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Article', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Article->del($id)) {
			$this->Session->setFlash(__('Article deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>