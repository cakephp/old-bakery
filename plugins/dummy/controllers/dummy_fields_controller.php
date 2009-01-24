<?php
class DummyFieldsController extends DummyAppController {
	public $name = 'DummyFields';
	
	function admin_index($tablename) {
		$fields = $this->DummyField->find('all', array('conditions'=>array(
			'DummyField.tablename'=>$tablename,
		)));
		if (empty($fields)) {
			$field_count = $this->DummyField->find('count');
			if ($field_count == 0) {				
				$this->Session->setFlash(__('No fields. Analyze database', true));
				$this->redirect(array('action' => 'analyze_all','admin'=>true));
			} else {				
				$this->Session->setFlash(__('No fields for this table. Analyze table', true));
				$this->redirect(array('action' => 'analyze',$tablename,'admin'=>true));
			}
		}
		$this->set('types', $this->DummyField->DummyType->options());
		$this->set('editable', ($this->DummyField->useTable !== false));
		$this->set('contents', $this->DummyField->DummyTable->contents($tablename));
		$this->set('table', $tablename);
		$this->set('data',$fields);
	}
	
	function admin_deactivate($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Field.', true));
			$this->redirect(array('controller'=>'dummy_tables', 'action' => 'index','admin'=>true));			
		}
		$field = $this->DummyField->find('first', array('recursive'=>-1,'conditions'=>array('id'=>$id),'fields'=>array('id','active','tablename')));
		if (!$field) {
			$this->Session->setFlash(__('Invalid Field.', true));
			$this->redirect(array('controller'=>'dummy_tables', 'action' => 'index','admin'=>true));				
		}
		$field['DummyField']['active'] = false;
		if ($this->DummyField->save($field,false)) {
			$this->Session->setFlash(__('Field deactivated', true));
		} else {
			$this->Session->setFlash(__('Field save failed.', true));
		}
		$this->redirect(array('action' => 'index',$field['DummyField']['tablename'],'admin'=>true));		
	}
		
	function admin_activate($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Field.', true));
			$this->redirect(array('controller'=>'dummy_tables', 'action' => 'index','admin'=>true));			
		}
		$field = $this->DummyField->find('first', array('recursive'=>-1,'conditions'=>array('id'=>$id),'fields'=>array('id','active','tablename')));
		if (!$field) {
			$this->Session->setFlash(__('Invalid Field.', true));
			$this->redirect(array('controller'=>'dummy_tables', 'action' => 'index','admin'=>true));				
		}
		$field['DummyField']['active'] = true;
		if ($this->DummyField->save($field,false)) {
			$this->Session->setFlash(__('Field activated', true));
		} else {
			$this->Session->setFlash(__('Field save failed.', true));
		}
		$this->redirect(array('action' => 'index',$field['DummyField']['tablename'],'admin'=>true));		
	}
	
	function admin_analyze_all() {
		if ($this->DummyField->analyze()) {
			$this->Session->setFlash(__('Fields analyzed.', true));
			$this->redirect(array('controller'=>'dummy_tables', 'action' => 'index','admin'=>true));			
		}
		$this->render('admin_analyze');
	}
	
	function admin_analyze($tablename = null) {
		if (!$tablename) {
			$this->redirect(404);
		}
		if ($this->DummyField->analyze($tablename)) {
			$this->Session->setFlash(__('Fields analyzed.', true));
			$this->redirect(array('action' => 'index',$tablename,'admin'=>true));			
		}		
	}
	
	function admin_change($tablename) {
		if (!empty($this->data)) {
			if ($this->DummyField->save($this->data,false)) {
				$this->Session->setFlash(__('Field updated.', true));
			} else {
				$this->Session->setFlash(__('Field update failed!', true));				
			}
		}
		$this->redirect(array('action' => 'index',$tablename,'admin'=>true));	
	}	
	
	function admin_edit($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Field.', true));
			$this->redirect(array('controller'=>'dummy_tables', 'action' => 'index','admin'=>true));			
		}
		if (!empty($this->data)) {
			if ($this->DummyField->save($this->data)) {
				$this->Session->setFlash(__('Field updated.', true));
				if (isset($this->data['DummyField']['tablename'])) {
					$tablename = $this->data['DummyField']['tablename'];
				} else {
					$this->DummyField->read(array('id','tablename'));
					$tablename = $this->DummyField->data['DummyField']['tablename'];					
				}
				$this->redirect(array('action' => 'index',$tablename,'admin'=>true));
			} else {
				$this->Session->setFlash(__('Field update failed!', true));						
			}
		} else {
			$this->DummyField->id = $id;
			$this->data = $this->DummyField->read();	
		}
	}
	
 }
