<?php
/* Tag Test cases generated on: 2009-07-17 22:07:14 : 1247860814*/
App::import('Model', 'ArticlePage');

class TagTestCase extends CakeTestCase {
	public $fixtures = array('app.article_page','app.article_pages_draft','app.article_pages_rev','app.tag','app.article','app.articles_tag','app.user','app.category','app.conversation','app.message','app.rating');
	public $autoFixtures = false;
	private $ArticlePage = null;
	function startTest() {
		$this->ArticlePage =& ClassRegistry::init('ArticlePage');
		$this->ArticlePage->recursive = -1;
		$this->ArticlePage->Article->recursive = -1;
	}

	function endTest() {
		unset($this->ArticlePage);
		ClassRegistry::flush();
	}

	function testHasAndAcceptDraft() {
		$this->loadFixtures('ArticlePage','ArticlePagesDraft');
		$this->assertEqual($this->ArticlePage->hasDraft(1), 1);
		$this->assertTrue($this->ArticlePage->acceptDraft(1));
		$this->assertEqual($this->ArticlePage->hasDraft(1), 0);
	}

	function testSaveNew() {

		$this->ArticlePage->create(array('ArticlePage' => array(
			'article_id' => 1,
			'title' => 'Background',
			'pagenum' => 1,
			'content' => 'first line of code'
		)));
		$this->ArticlePage->save();
		$result = $this->ArticlePage->read();
		$expected = array(
			'id' => 1,
			'article_id' => 1,
			'title' => '',
			'pagenum' => 1,
			'content' => ''
		);
		$this->assertEqual($result['ArticlePage'],$expected);

		$this->assertEqual($this->ArticlePage->hasDraft(1), 1);


		$expected = array(
			'id' => 1,
			'article_id' => 1,
			'title' => 'Background',
			'pagenum' => 1,
			'content' => 'first line of code',
			'draft_id' => 1
		);
		$this->ArticlePage->showDraft = true;
		$result = $this->ArticlePage->read();
		$this->assertEqual($result['ArticlePage'],$expected);
	}


	function testEdit() {
		$this->loadFixtures('ArticlePage','ArticlePagesDraft');
		$this->ArticlePage->id = 1;
		$result = $this->ArticlePage->field('title');
		$this->assertEqual($result,'Page 1 : Lorem ipsum dolor sit amet');

		$this->ArticlePage->save(array('ArticlePage'=>array('id'=>1, 'title' => 'edited title')));

		$this->assertEqual($this->ArticlePage->hasDraft(1), 1);
		$result = $this->ArticlePage->field('title');
		$this->assertEqual($result,'Page 1 : Lorem ipsum dolor sit amet');

		$this->assertTrue($this->ArticlePage->acceptDraft(1));

		$result = $this->ArticlePage->field('title');
		$this->assertEqual($result,'edited title');
	}

	function testDirectEdit() {
		$this->loadFixtures('ArticlePage');
		$this->ArticlePage->saveDraft = false;
		$this->ArticlePage->save(array('id' => 1, 'title' => 'edit','content' => 'edited'));

		$this->assertIdentical($this->ArticlePage->hasDraft(1),0);
		$this->assertEqual($this->ArticlePage->read(array('id','title','content')), array('ArticlePage' => array(
			'id' => 1,
			'title' => 'edit',
			'content' => 'edited'
		))); 
	}

	function testArticleFlow() {
		$this->loadFixtures('User');
		$data = array('Article' => array(
			'title' => 'Test Article',
			'category_id' => 2,
			'user_id' => 1
		));
		$this->ArticlePage->Article->create($data);
		$this->ArticlePage->Article->save();

		/** Should this setting be automatic?
		 *  ie check if Article publish status = 0 + publised_data = null
		 */
		$this->ArticlePage->saveDraft = false;
		$this->ArticlePage->Article->Intro->saveDraft = false;

		$data = array('Intro' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'pagenum' => 0,
			'content' => 'Introdcution text'
		));
		$this->ArticlePage->Article->Intro->create($data);
		$this->ArticlePage->Article->Intro->save();

		$data = array('ArticlePage' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'pagenum' => 1,
			'title' => 'Background',
			'content' => 'A little Background'
		));
		$this->ArticlePage->create($data);
		$this->ArticlePage->save();

		$data = array('ArticlePage' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'pagenum' => 2,
			'title' => 'Code Examples',
			'content' => 'foBar();'
		));
		$this->ArticlePage->create($data);
		$this->ArticlePage->save();

		$data = array('ArticlePage' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'pagenum' => 3,
			'title' => 'Code',
			'content' => 'function foBar() {}'
		));
		$this->ArticlePage->create($data);
		$this->ArticlePage->save();

		$this->ArticlePage->create();
		$this->ArticlePage->Article->create();

		/**
		 * At this point, we should have one unpublished Article with 
		 * 3 ArticlePages, plus the Intro, which is also an ArticlePage.
		 * As an author writes an unpublished article, there isn no need for
		 * draft, only changes needs to be drafted. So there should be no drafts
		 * of any of the ArticlePages, but each page should have one revision.
		 * 
		 */

		$this->assertIdentical($this->ArticlePage->Article->find('count'), 1, 'More than one Article : %s');
		$this->assertIdentical($this->ArticlePage->find('count'), 4, 'In correct number of Pages : %s');
		$this->assertIdentical($this->ArticlePage->DraftModel->find('count'), 0, 'Drafts created : %s');
		$this->assertIdentical($this->ArticlePage->ShadowModel->find('count'), 4, 'Incorret number of Revisions : %s');

		// Author edits a page 
		$this->ArticlePage->save(array('ArticlePage' => array(
			'id' => 2,
			'title' => 'edited title',
			'content' => 'edited content'
		)));

		/**
		 * At this point the article is still unpublished, so edit should go
		 * straight to live table. Therefore, still no drafts, but 2 revisions
		 * for this Page
		 */
		$this->assertIdentical($this->ArticlePage->find('count'), 4, 'In correct number of Pages : %s');
		$this->assertIdentical($this->ArticlePage->ShadowModel->find('count', array('conditions'=> array(
			'id' => 2))), 2, 'Incorret number of Revisions : %s');
		
		//Moderator publishes the article
		$this->assertTrue($this->ArticlePage->Article->publish(1), 'Article publishing failed : %s');

		$this->ArticlePage->Article->id = 1;
		$this->assertIdentical($this->ArticlePage->Article->field('published'),'1', 'Article is not published : %s');
		
		/** Should this setting be automatic?
		 *  ie check if Article publish status = 0 + publised_data = null
		 */
		$this->ArticlePage->saveDraft = true;
		$this->ArticlePage->Article->Intro->saveDraft = true;

		// Author edits a page again
		/** this should generate a revision */
		$this->ArticlePage->save(array('ArticlePage' => array(
			'id' => 2,
			'title' => 'edited title again',
			'content' => 'edited content again'
		)));
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;
		/**
		 * @todo revision should be created automatically
		 * problem with drafted compatability
		 */

		/**
		 * With an edit on a live page, the current situation should be:
		 * Article still published
		 * Edited Page should still show version from when moderator published
		 * There should be one draft, containing edited content
		 * There should be a total of 3 revisions for this page
		 */
		$this->ArticlePage->Article->id = 1;
		$this->assertIdentical($this->ArticlePage->Article->field('published'),'1', 'Article is not published : %s');

		$result = $this->ArticlePage->find('first', array('conditions' => array('id' => 2)));
		$this->assertEqual($result['ArticlePage']['content'], 'edited content', 'Page has incorrect content : %s');

		$this->assertIdentical($this->ArticlePage->DraftModel->find('count'), 1, 'Incorrect number of drafts : %s');
		$this->assertIdentical($this->ArticlePage->hasDraft(2),1, 'Page does not have draft');
		$result = $this->ArticlePage->DraftModel->find('first', array('conditions' => array('id' => 2)));
		$this->assertEqual($result['ArticlePage']['content'], 'edited content again');

		$this->assertIdentical($this->ArticlePage->ShadowModel->find('count', array('conditions'=> array(
			'id' => 2))), 3, 'Incorret number of Revisions : %s');

		// Moderator accepts this edit
		/* this should not create a revision */
		$this->ArticlePage->Behaviors->disable('Revision');
		$this->assertTrue($this->ArticlePage->acceptDraft(2), 'Accepting draft failed');
		$this->ArticlePage->Behaviors->enable('Revision');
		
		/**
		 * There should be no drafts, article should be published with
		 * all pages updated. There should still be 3 revisions of page 1 (id=2)
		 */

		$result = $this->ArticlePage->find('first', array('conditions' => array('id' => 2)));
		$this->assertEqual($result['ArticlePage']['content'], 'edited content again', 'Page has incorrect content : %s');
		$this->assertIdentical($this->ArticlePage->DraftModel->find('count'), 0, 'Should be no drafts : %s');
		$this->assertIdentical($this->ArticlePage->ShadowModel->find('count', array('conditions'=> array(
			'id' => 2))), 3, 'Incorret number of Revisions : %s');

	}
}
?>