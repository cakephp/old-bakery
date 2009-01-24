<?php
class DummyTablesController extends AppController {
	public $name = 'DummyTables';	
	
	function admin_index() {
		$tables = $this->DummyTable->find('all', array(
			'recursive' => -1
		));
		if (empty($tables)) {
			$this->Session->setFlash(__('No tables. Analyze database', true));
			$this->redirect(array('action' => 'analyze_all','admin'=>true));
		}
		$this->set('editable', ($this->DummyTable->useTable !== false));
		$this->set('data', $tables);
		
	}

	function admin_view($tablename = null) {
		if (!$tablename) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array('action' => 'index','admin'=>true));
		}
		$data = $this->DummyTable->find('first', 
			array(
				'conditions' => array('name' => $tablename),
				'recursive' => -1
			)
		);
		$this->helpers[] = 'Time';
		$this->set('editable', ($this->DummyTable->useTable !== false));
		$data['DummyTable']['contents'] = $this->DummyTable->contents($tablename);
		$this->set('data',$data );
	}
	
	function admin_generate_all() {
		$tables = $this->DummyTable->find('all', array(
				'recursive' => -1,
				'conditions' => array('active' => true)));
		$tables = Set::extract($tables, '{n}.DummyTable.name');
		foreach ($tables as $tablename) {
			$this->DummyTable->id = $tablename;
			$this->DummyTable->read();
			
			if (!$this->DummyTable->generate($tablename)) {
				$this->Session->setFlash(__('Failed to generate table : ', true) . $tablename);
				$this->redirect(array('action' => 'index', 'admin' => true));
			}
		}
		
		$this->Session->setFlash(__('Generated Tables.', true));
		$this->redirect(array('action' => 'index', 'admin' => true));
	}
	
	function admin_generate($tablename = null) {
		if (!$tablename) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array('action' => 'index','admin'=>true));
		}
		$this->DummyTable->id = $tablename;
		$this->DummyTable->read();
		if (!$this->DummyTable->data['DummyTable']['active']) {
			$this->Session->setFlash(__('Table inactive.', true));
			$this->redirect(array('controller'=>'dummy_fields','action'=>'index',$tablename,'admin'=>true,'plugin'=>'dummy'));			
		}
		$number_rows_generated = $this->DummyTable->generate($tablename);
		if ($number_rows_generated > 0) {
			$this->Session->setFlash(sprintf(__('Generated %s of %s rows.', true), $number_rows_generated, $this->DummyTable->data['DummyTable']['number']));
			$this->redirect(array('controller'=>'dummy_fields','action'=>'index',$tablename,'admin'=>true,'plugin'=>'dummy'));
		} else {		
			//debug($this->DummyTable->DummyField->validationErrors,TRUE);
			$this->Session->setFlash(__('Failed to generate any rows.', true));
		}
		$this->redirect(array('controller'=>'dummy_fields','action'=>'index',$tablename,'admin'=>true,'plugin'=>'dummy'));
	}

	function admin_analyze($tablename) {
		if ($this->DummyTable->analyze($tablename)) {
			$this->Session->setFlash(__('Tables analyzed.', true));
			$this->redirect(array('controller'=>'dummy_fields','action' => 'index',$tablename,'admin'=>true));			
		}
	}
	
	function admin_analyze_all() {
		if ($this->DummyTable->analyze()) {
			$this->Session->setFlash(__('Tables analyzed.', true));
			$this->redirect(array('action' => 'index','admin'=>true));			
		}
		$this->render('admin_analyze');
	}
		
	function admin_deactivate($tablename = null) {
		if (!$tablename) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array( 'action' => 'index','admin'=>true));			
		}
		$table = $this->DummyTable->find('first', array('recursive'=>-1,'conditions'=>array('name'=>$tablename),'fields'=>array('name','active')));
		if (!$table) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array( 'action' => 'index','admin'=>true));				
		}
		$table['DummyTable']['active'] = false;
		if ($this->DummyTable->save($table,false)) {
			$this->Session->setFlash(__('Table deactivated', true));
		} else {
			$this->Session->setFlash(__('Table save failed.', true));
		}
		$this->redirect(array('action' => 'index','admin'=>true));		
	}
		
	function admin_activate($tablename = null) {
		if (!$tablename) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array( 'action' => 'index','admin'=>true));			
		}
		$table = $this->DummyTable->find('first', array('recursive'=>-1,'conditions'=>array('name'=>$tablename),'fields'=>array('name','active')));
		if (!$table) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array( 'action' => 'index','admin'=>true));				
		}
		$table['DummyTable']['active'] = true;
		if ($this->DummyTable->save($table,false)) {
			$this->Session->setFlash(__('Table deactivated', true));
		} else {
			$this->Session->setFlash(__('Table save failed.', true));
		}
		$this->redirect(array('action' => 'index','admin'=>true));		
	}
	
	function admin_truncate($tablename = null) {
		if (!$tablename) {
			$this->Session->setFlash(__('Invalid Table.', true));
			$this->redirect(array( 'action' => 'index','admin'=>true));			
		}
		$this->DummyTable->useDbConfig = 'default';
		if ($this->DummyTable->query('TRUNCATE '.$tablename)) {
			$this->Session->setFlash(__('Could not empty table.', true));
		} else {			
			$this->Session->setFlash(__('Table emptied!', true));			
		}
		$this->redirect(array('controller'=>'dummy_fields' ,'action' => 'index',$tablename,'admin'=>true));	
	}
	
}
?>
