<?php
/*
class DraftedBook extends CakeTestModel {
	public $name = 'DraftedBook';
	public $alias = 'Book';
	public $actsAs = array( 'Drafted' );
	

}*/

class DraftedPost extends CakeTestModel {
	public $name = 'DraftedPost';
	public $alias = 'Post';
	public $actsAs = array( 'Drafted' => array('fields' => array('title','body')));
	
	public function acceptDraft($id) {
		if ($this->Behaviors->Drafted->acceptDraft($this, $id))  {
			$this->id = $id;
			return $this->saveField('published',1);
		}
	}
}


class DraftedCase extends CakeTestCase {
	public $fixtures = array(
	#	'app.drafted_book',
	#	'app.drafted_books_draft',
		'app.drafted_post',
		'app.drafted_posts_draft',
	);
	
	function endTest() {
        ClassRegistry::flush();
	}
	
	function testFind() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost','DraftedPostsDraft');
		
		$result = $Post->findById(1);
		$expected = array('id'=>1,'title'=>'Rock and Roll','body'=>'I love rock and roll!', 'published' => 1);
		$this->assertEqual($result['Post'],$expected);
		
		$result = $Post->findById(2);
		$expected = array('id'=>2,'title'=>'Music','body'=>'Rock and roll is cool', 'published' => 1);
		$this->assertEqual($result['Post'],$expected);
	}

	function testFindDraft() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost','DraftedPostsDraft');
		
		$Post->showDraft = true;
		$result = $Post->findById(2);
		$expected = array('id'=>2,'title'=>'Musical','body'=>'Rock and roll is awesome!', 'published' => 1,'draft_id'=>1);
		$this->assertEqual($result['Post'],$expected);
	}

	function testFindAll() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost','DraftedPostsDraft');
		
		$result = $Post->find('all', array('fields' => array('id','title')));
		$expected = array(
			array('Post' => array('id' => 1, 'title' => 'Rock and Roll')),
			array('Post' => array('id' => 2, 'title' => 'Music')),
			array('Post' => array('id' => 3, 'title' => 'Food'))
		);
		$this->assertEqual($result,$expected);
	}
	
	function testFindAllWithDrafts() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost','DraftedPostsDraft');
		
		$Post->showDraft = true;
		$result = $Post->find('all', array('fields' => array('Post.id','Post.title')));
		$expected = array(
			array('Post' => array('id' => 1, 'title' => 'Rock and Roll', 'draft_id' => NULL)),
			array('Post' => array('id' => 2, 'title' => 'Musical', 'draft_id' => 1)),
			array('Post' => array('id' => 3, 'title' => 'Food', 'draft_id' => NULL))
		);
		$this->assertEqual($result,$expected);
	}
	
	function testfindDrafts() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost','DraftedPostsDraft');
		
		$result = $Post->findDrafts();
		$this->assertNoErrors();
		$expected = array(
			0 => array(
				'Post' => array(
					'id' => 2,
					'title' => 'Musical',
					'draft_id' => 1
				) 
			)
		);
		$this->assertEqual($result,$expected);
	}
	
	function testfindDraftsCheck() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost','DraftedPostsDraft');
		
		$this->assertFalse($Post->hasDraft(1));
		$this->assertTrue($Post->hasDraft(2));
		$this->assertFalse($Post->hasDraft(3));
	}	
	/***/
	
	function testSaveDirect() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost');

		$findDrafts = $Post->findDrafts();
		
		$Post->saveDraft = false;
		$Post->create(array('title' => 'new post', 'body' => 'lorem ipsum'));
		$this->assertTrue($Post->save());		
		
		$post_save_findDrafts = $Post->findDrafts();		
		$this->assertEqual($findDrafts, $post_save_findDrafts);		
		$this->assertEqual($Post->find('count'),4);
	}
	
	function testSave() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost');
			
		$Post->create(array('title' => 'new post', 'body' => 'lorem ipsum', 'published' => false));
		$this->assertTrue($Post->save());		
		
		$result = $Post->findDrafts();		
		$expected = array(
			array('Post' => array('id' => 2,'title' => 'Musical', 'draft_id' => 1)),
			array('Post' => array('id' => 4,'title' => 'new post','draft_id' => 2)),
		);
		$this->assertEqual($result, $expected);		
		$this->assertEqual($Post->find('count'),4);
	}
	
	function testSaveEdit() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost');
			
		$Post->save(array('id' => 1, 'title' => 'edit', 'body' => 'edited lorem'));
		
		$result = $Post->findDrafts();		
		$expected = array(
			array('Post' => array('id' => 2,'title' => 'Musical', 'draft_id' => 1)),
			array('Post' => array('id' => 1,'title' => 'edit','draft_id' => 2)),
		);
		$this->assertEqual($result, $expected);		
		$this->assertEqual($Post->find('count'),3);
		$result = $Post->findById(1);
		$this->assertEqual($result['Post']['title'],'Rock and Roll');
		
		$Post->save(array('id' => 1, 'title' => 'edit again', 'body' => 'edited lorem'));
		
		
		$result = $Post->findDrafts();		
		$expected = array(
			array('Post' => array('id' => 2,'title' => 'Musical', 'draft_id' => 1)),
			array('Post' => array('id' => 1,'title' => 'edit again','draft_id' => 2)),
		);
		$this->assertEqual($result, $expected);		
		$this->assertEqual($Post->find('count'),3);
		$result = $Post->findById(1);
		$this->assertEqual($result['Post']['title'],'Rock and Roll');
	}
	
	function testSaveEditDirect() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost');
		
		$Post->saveDraft = false;
		$Post->save(array('id' => 1, 'title' => 'edit', 'body' => 'edited lorem'));
		
		$this->assertFalse($Post->hasDraft(1));
		
		$result = $Post->findById(1);
		$this->assertEqual($result['Post']['title'],'edit');
	}	
	/***/
	
	function testModerartionAcceptOnEdit() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost');
		
		$this->assertFalse($Post->acceptDraft(1));
		
		$this->assertTrue($Post->acceptDraft(2));
		$this->assertEqual($Post->DraftModel->find('count'),0);
		$result = $Post->findById(2);
		$expected = array('Post' => array(
			 'id' => 2, 'title' => 'Musical', 'body' => 'Rock and roll is awesome!','published' => 1
		));
		$this->assertEqual($result, $expected);	
	}
	
	function testModerationAcceptOnCreate() {
		$Post = ClassRegistry::init('DraftedPost','model');
		$this->loadFixtures('DraftedPost');
			
		$Post->create(array('title' => 'new post', 'body' => 'lorem ipsum', 'published' => false ));
		$this->assertTrue($Post->save());	
		
		$result = $Post->findDrafts();		
		$expected = array(
			array('Post' => array('id' => 2,'title' => 'Musical', 'draft_id' => 1)),
			array('Post' => array('id' => 4,'title' => 'new post','draft_id' => 2)),
		);
		
		$result = $Post->findById(4);
		$expected = array('Post'=>array('id' => 4, 'title' => null, 'body' => null,'published' => 0));
		$this->assertEqual($expected, $result);
		
		$this->assertTrue($Post->acceptDraft(4));
		
		$result = $Post->findById(4);
		$expected = array('Post'=>array('id' => 4, 'title' => 'new post', 'body' => 'lorem ipsum','published' => 1));
		$this->assertEqual($expected, $result);		
	}	
	
	/***/
}
?>
