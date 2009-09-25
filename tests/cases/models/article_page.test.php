<?php
/* Tag Test cases generated on: 2009-07-17 22:07:14 : 1247860814*/
App::import('Model', 'ArticlePage');

class ArticlePageTestCase extends CakeTestCase {
	public $fixtures = array('app.article_page','app.article_pages_draft','app.article_pages_rev','app.tag','app.article',
		'app.articles_tag','plugin.users.user','app.category','app.rating',
		'plugin.users.conversation','plugin.users.message','plugin.users.conversations_user','plugin.users.user');
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
			'page_number' => 1,
			'content' => 'first line of code'
		)));
		$this->ArticlePage->save();
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;
		$result = $this->ArticlePage->read();
		$expected = array(
			'id' => 1,
			'article_id' => 1,
			'title' => '',
			'page_number' => 1,
			'content' => ''
		);
		$this->assertEqual($result['ArticlePage'],$expected);

		$this->assertEqual($this->ArticlePage->hasDraft(1), 1);


		$expected = array(
			'id' => 1,
			'article_id' => 1,
			'title' => 'Background',
			'page_number' => 1,
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
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;

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
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;

		$this->assertIdentical($this->ArticlePage->hasDraft(1),0);
		$this->assertEqual($this->ArticlePage->read(array('id','title','content')), array('ArticlePage' => array(
			'id' => 1,
			'title' => 'edit',
			'content' => 'edited'
		))); 
	}

	function testArticleFlow() {
		$this->loadFixtures('User','Category');
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
		$this->ArticlePage->Article->Intro->saveDraft = false;

		$data = array('Intro' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'page_number' => 0,
			'content' => 'Introduction text'
		));
		$this->ArticlePage->Article->Intro->create($data);
		$this->ArticlePage->Article->Intro->save();
		$this->ArticlePage->Article->Intro->showDraft = true;
		$this->ArticlePage->Article->Intro->createRevision();
		$this->ArticlePage->Article->Intro->showDraft = false;


		$data = array('ArticlePage' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'page_number' => 1,
			'title' => 'Background',
			'content' => 'A little Background'
		));
		$this->ArticlePage->create($data);
		$this->ArticlePage->save();
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;

		$data = array('ArticlePage' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'page_number' => 2,
			'title' => 'Code Examples',
			'content' => 'foBar();'
		));
		$this->ArticlePage->create($data);
		$this->ArticlePage->save();
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;

		$data = array('ArticlePage' => array(
			'article_id' => $this->ArticlePage->Article->id,
			'page_number' => 3,
			'title' => 'Code',
			'content' => 'function foBar() {}'
		));
		$this->ArticlePage->create($data);
		$this->ArticlePage->save();
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;

		$this->ArticlePage->create();
		$this->ArticlePage->Article->create();

		/**
		 * At this point, we should have one unpublished Article with 
		 * 3 ArticlePages, plus the Intro, which is also an ArticlePage.
		 * As an author writes an unpublished article, the Intro is not drafted
		 * There are just drafts of the ArticlePages, and each page (and intro)
		 * should have one revision.
		 */
		$this->assertIdentical($this->ArticlePage->Article->find('count'), 1, 'More than one Article : %s');
		$this->ArticlePage->bindModel(array(
			'hasOne' => array(
				'Draft' => array(
					'className' => 'ArticlePagesDraft',
					'foreignKey' => 'id' 
			)),
			'hasMany' => array(
				'Revision' => array(
					'className' => 'ArticlePagesRev',
					'foreignKey' => 'id',
					'order' => 'version_created DESC, version_id DESC'						
				)	
			)
		));
		$articlePageSituation  = $this->ArticlePage->find('all',array('contain' => array('Draft','Revision')));
		$this->assertIdentical(4, sizeof($articlePageSituation), 'In correct number of Pages : %s');
		if ($this->skipIf(4 != sizeof($articlePageSituation),'In correct number of Pages')) return;
		$this->assertTrue(empty($articlePageSituation[0]['Draft']['title']), 'Draft created for Intro : %s');
		$this->assertIdentical('Background',$articlePageSituation[1]['Draft']['title'], 'Draft not created a Page : %s');
		$this->assertIdentical('Code Examples',$articlePageSituation[2]['Draft']['title'], 'Draft not created a Page : %s');
		$this->assertIdentical('Code',$articlePageSituation[3]['Draft']['title'], 'Draft not created a Page : %s');
		$this->assertIdentical(1, sizeof($articlePageSituation[0]['Revision']), 'Incorret number of Revisions : %s');
		$this->assertIdentical(1, sizeof($articlePageSituation[1]['Revision']), 'Incorret number of Revisions : %s');
		$this->assertIdentical(1, sizeof($articlePageSituation[2]['Revision']), 'Incorret number of Revisions : %s');
		$this->assertIdentical(1, sizeof($articlePageSituation[3]['Revision']), 'Incorret number of Revisions : %s');
		$this->assertIdentical('Introduction text', $articlePageSituation[0]['Revision'][0]['content'], 'Content not set in revision : %s');
		$this->assertIdentical('Background', $articlePageSituation[1]['Revision'][0]['title'], 'Title not set in revision : %s');
		$this->assertIdentical('Code Examples', $articlePageSituation[2]['Revision'][0]['title'], 'Title not set in revision : %s');
		$this->assertIdentical('Code', $articlePageSituation[3]['Revision'][0]['title'], 'Title not set in revision : %s');

		// Author edits a page
		$this->ArticlePage->data = null;
		$this->ArticlePage->save(array('ArticlePage' => array(
			'id' => 2,
			'title' => 'edited title',
			'content' => 'edited content'
		)));
		$this->ArticlePage->showDraft = true;
		$this->ArticlePage->createRevision();
		$this->ArticlePage->showDraft = false;

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

		$this->ArticlePage->Article->ArticlePage->bindModel(array(
			'hasOne' => array(
				'Draft' => array(
					'className' => 'ArticlePagesDraft',
					'foreignKey' => 'id'
				)
			)

		));


		$this->ArticlePage->Article->id = 1;
		$this->assertIdentical($this->ArticlePage->Article->field('published'),'1', 'Article is not published : %s');
		// check that article, intro and article pages are all published
		$this->assertIdentical($this->ArticlePage->DraftModel->find('count'), 0, 'Drafts still exist : %s');

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

	function testPageRevisioning() {
		$this->loadFixtures('ArticlePage','ArticlePagesRev','ArticlePagesDraft');
/*
		$Article = $this->ArticlePage->Article;
		$Article->Behaviors->attach('Containable');
		debug($Article->find('first', array('recursive' => 1,'contain' => array('Intro','ArticlePage'))));
*/
		$Page = $this->ArticlePage;
		$Page->Behaviors->attach('Containable');
		$Page->bindModel(array(
			'hasOne' => array(
				'Draft' => array(
					'className' => 'ArticlePagesDraft',
					'foreignKey' => 'id'
				)
			),
			'hasMany' => array(
				'Revision' => array(
					'className' => 'ArticlePagesRev',
					'foreignKey' => 'id',
					'order' => 'version_created DESC, version_id DESC'
				)
			)
		));
		$result = $Page->find('first', array('contain' => array('Draft','Revision')));

		$this->assertFalse(empty($result), 'ArticlePage fixture not loaded : %s');
		if ($this->skipIf(empty($result),'ArticlePage fixture not loaded')) return;
		$this->assertIdentical($result['ArticlePage']['title'], 'Page 1 : Lorem ipsum dolor sit amet');
		$this->assertIdentical($result['Draft']['title'], 'Lorem ipsum dolor sit amet - draft edit');
		$this->assertIdentical(sizeof($result['Revision']),2,'Incorrect number of revisions : %s');
		if ($this->skipIf(sizeof($result['Revision']) != 2,'Incorrect number of revisions')) return;
		$this->assertIdentical($result['Revision'][0]['title'], 'Lorem ipsum dolor sit amet - draft edit');
		$this->assertIdentical($result['Revision'][1]['title'], 'Page 1 : Lorem ipsum dolor sit amet');

		$Page->save(array('ArticlePage' => array('id' => 1, 'title' => '2nd edit', 'content' => '2nd edit content')));

		$Page->showDraft = true;
		$Page->createRevision();
		$Page->showDraft = false;

		sleep(1);

		$result = $Page->find('first', array('contain' => array('Draft','Revision')));
		
		$this->assertIdentical($result['Draft']['title'], '2nd edit');
		$this->assertIdentical(sizeof($result['Revision']),3,'Incorrect number of revisions : %s');
		if ($this->skipIf(sizeof($result['Revision']) != 3,'Incorrect number of revisions')) return;
		$this->assertIdentical($result['Revision'][0]['title'], '2nd edit');

		// User undo's his change before moderator has done anything
		
		$Page->id = 1;
		$Page->undo();
		$Page->showDraft = true;
		$Page->createRevision();
		$Page->showDraft = false;

		$result = $Page->find('first', array('contain' => array('Draft','Revision')));

		/**
		 *  Fixture description :
		 *    - User had created an article with a page
		 *    - A moderator had published the article (and the page)
		 *    - User had edited the article page, but it had not been accepted, it was still a "draft"
		 *
		 *  Test flow :
		 *    - (we test fixture situation
		 *    - User saves a 2nd edit (creating a third revision)
		 *    - (we test correct situation)
		 *    - User undoes change with no publishing of the 2nd edit (creating a fourth revision)
		 *
		 *  Expected tables situation:
		 *	  - Original published page still in live table
		 *    - The original draft from fixture still in draft table
		 *    - Four revisions in revision table,
		 *       * original content (from fixture)
		 *       * draft edit (from fixture)
		 *       * 2nd edit (from test save above)
		 *       * draft edit (from undo)
		 */

		$this->assertIdentical($result['Draft']['title'], 'Lorem ipsum dolor sit amet - draft edit');
		$this->assertIdentical(sizeof($result['Revision']),4,'Incorrect number of revisions : %s');
		if ($this->skipIf(sizeof($result['Revision']) != 4,'Incorrect number of revisions')) return;
		$this->assertIdentical($result['Revision'][0]['title'], 'Lorem ipsum dolor sit amet - draft edit');

		$this->ArticlePage->Behaviors->disable('Revision');
		$this->assertTrue($this->ArticlePage->acceptDraft(1), 'Accepting draft failed');
		$this->ArticlePage->Behaviors->enable('Revision');

		$result = $Page->find('first', array('contain' => array('Draft','Revision')));

		// page published. no longer any draft. 4 revisions
		$this->assertIdentical($result['ArticlePage']['title'], 'Lorem ipsum dolor sit amet - draft edit');
		$this->assertTrue(empty($result['Draft']['draft_id']));
		$this->assertIdentical(sizeof($result['Revision']),4,'Incorrect number of revisions : %s');


		// user makes a 3rd edit - this should leave the accepted page and create a draft and a revision
		$Page->saveDraft = true;
		$Page->save(array('ArticlePage' => array('id' => 1, 'title' => '3rd edit', 'content' => '3rd edit content')));

		$Page->showDraft = true;
		$Page->createRevision();
		$Page->showDraft = false;

		sleep(1);

		$result = $Page->find('first', array('contain' => array('Draft','Revision')));

		$this->assertIdentical($result['ArticlePage']['title'], 'Lorem ipsum dolor sit amet - draft edit');
		$this->assertIdentical($result['Draft']['title'], '3rd edit');
		$this->assertIdentical(sizeof($result['Revision']),5,'Incorrect number of revisions : %s');
		if ($this->skipIf(sizeof($result['Revision']) != 5,'Incorrect number of revisions')) return;
		$this->assertIdentical($result['Revision'][0]['title'], '3rd edit');
	}

}
?>