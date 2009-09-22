<?php
App::import('Model', 'Article');

class ArticleTestCase extends CakeTestCase {
	public $fixtures = array('app.article_page','app.article_pages_draft','app.article_pages_rev','app.tag',
		'app.article','app.articles_tag','app.category','app.rating',
		'plugin.users.conversation','plugin.users.message','plugin.users.conversations_user','plugin.users.user');
	public $autoFixtures = false;
	private $Article = null;

	function startTest() {
		$this->Article =& ClassRegistry::init('Article');
		$this->Article->recursive = -1;
		$this->Article->Intro->recursive = -1;
		$this->Article->ArticlePage->recursive = -1;
		$this->Article->Rateing->recursive = -1;
		$this->Article->User->recursive = -1;
	}

	function endTest() {
		unset($this->Article);
		ClassRegistry::flush();
	}

	function testArticleFixtures() {
		$this->loadFixtures('Article','ArticlePage','User','Tag','ArticlesTag','Category','Rating');
		$this->Article->recursive = 1;
		$result = $this->Article->findById(1);
		
		$this->assertNotNull($result,'Corrupt data : article not found : %s');

		$this->assertTrue(isset($result['Parent']), 'Parent assoc not present : %s');
		$this->assertTrue(isset($result['Category']), 'Category assoc not present : %s');
		$this->assertTrue(isset($result['User']), 'User assoc not present : %s');
		$this->assertTrue(isset($result['Intro']), 'Intro assoc not present : %s');
		$this->assertTrue(isset($result['ArticlePage']), 'ArticlePage assoc not present : %s');
		$this->assertTrue(isset($result['Rating']), 'Rating assoc not present : %s');
		$this->assertTrue(isset($result['Tag']), 'Tag assoc not present : %s');

		$this->assertTrue(empty($result['Parent']['id']), 'Parent assoc data not present : %s');
		$this->assertFalse(empty($result['Category']['id']), 'Category assoc data not present : %s');
		$this->assertFalse(empty($result['User']['id']), 'User assoc data not present : %s');
		$this->assertFalse(empty($result['Intro']['id']), 'Intro assoc data not present : %s');
		$this->assertFalse(empty($result['ArticlePage']), 'ArticlePage assoc data not present : %s');
		$this->assertFalse(empty($result['Rating']), 'Rating assoc data not present : %s');
		$this->assertFalse(empty($result['Tag']), 'Tag assoc data not present : %s');

		$this->assertIdentical(sizeof($result['ArticlePage']), 1, 'More than one Article Page : %s');
		$this->assertIdentical(sizeof($result['Rating']), 2, 'Incorret number of Ratings : %s');
		$this->assertIdentical(sizeof($result['Tag']), 2, 'Incorrect number of Tags : %s');

		/**
		 * @todo update as Comments, attachments and any other model is associated with Article. 
		 */

		#debug($result);
	}

	function testPublish() {
		$this->loadFixtures('User','Category');
		$data = array('Article' => array(
			'title' => 'Test Article',
			'category_id' => 2,
			'user_id' => 1
		));
		$this->Article->create($data);
		$this->Article->save();

		/**
		 *  @todo Should this setting be automatic?
		 *  ie check if Article publish status = 0 + publised_data = null
		 */
		$this->saveDraft = false;
		$this->Article->Intro->saveDraft = false;

		$result = $this->Article->find('first', array(
			'recursive' => -1,
			'fields' => array('id','published','published_date','deleted'),
			'conditions' => array('id' => 1)));
		$this->assertFalse($result['Article']['published'], 'Article started out published : %S');
		$this->assertNull($result['Article']['published_date'], 'Article started out with published date : %S');
		$this->assertFalse($result['Article']['deleted'], 'Article started out deleted : %S');

		$this->assertTrue($this->Article->publish(1), 'Failed to publish Article : %s');

		$result = $this->Article->find('first', array(
			'recursive' => -1,
			'fields' => array('id','published','published_date','deleted'),
			'conditions' => array('id' => 1)));
		$this->assertTrue($result['Article']['published'], 'Article did not get published : %S');
		$this->assertNotNull($result['Article']['published_date'], 'Article did not get published date : %S');
		$this->assertFalse($result['Article']['deleted'], 'Article got deleted : %S');
	}

	function testUnPublish() {
		$this->loadFixtures('User','Category', 'Article', 'ArticlePage');

		$this->assertTrue($this->Article->published(1), 'Article not published : %s');

		$this->assertTrue($this->Article->unPublish(1), 'Article unPublish() failed : %s');

		$this->assertFalse($this->Article->published(1), 'Article published after running unPublish() : %s');
	}

	function testDelete() {
		$this->loadFixtures('Article','ArticlePage','ArticlePagesDraft','ArticlePagesRev');

		$this->Article->Behaviors->attach('Containable');
		$result = $this->Article->find('first', array(
			'contain' => array('ArticlePage','Intro'),
			'fields' => array('Article.id','Article.published','Article.published_date','Article.deleted','Article.deleted_date',
				'Intro.id','Intro.article_id','Intro.content'),
			'conditions' => array('Article.id' => 1)
		));

		$this->assertTrue($result['Article']['published'], 'Article isnt published : %S');
		$this->assertNotNull($result['Article']['published_date'], 'Article does not have published date : %S');
		$this->assertFalse($result['Article']['deleted'], 'Article is deleted : %S');
		$this->assertNull($result['Article']['deleted_date'], 'Article has deleted date : %S');
		$this->assertFalse(empty($result['ArticlePage']), 'Article has no pages : %S');
		$this->assertFalse(empty($result['Intro']), 'Article has no Intro : %S');

		$pageIDs = Set::extract('/ArticlePage/id', $result);
		$pageIDs[] = $result['Intro']['id'];

		$this->assertTrue($this->Article->delete(1), 'Failed to delete article : %s');

		$result = $this->Article->find('first', array(
			'contain' => array('ArticlePage','Intro'),
			'fields' => array('Article.id','Article.published','Article.published_date','Article.deleted','Article.deleted_date',
				'Intro.id','Intro.article_id','Intro.content'),
			'conditions' => array('Article.id' => 1)
		));

		$this->assertFalse($result['Article']['published'], 'Article is published : %S');
		$this->assertNotNull($result['Article']['published_date'], 'Article does not have published date : %S');
		$this->assertTrue($result['Article']['deleted'], 'Article isn\'t deleted : %S');
		$this->assertNotNull($result['Article']['deleted_date'], 'Article does not have deleted date : %S');
		$this->assertFalse(empty($result['ArticlePage']), 'Article has no pages : %S');
		$this->assertFalse(empty($result['Intro']), 'Article has no Intro : %S');

		/**
		 * At this point the Article is unpublished and in the "bin". The article pages still exist in the live table
		 * Doing a permanent erasing, should remove the pages, as well as their history
		 */

		$this->assertTrue($this->Article->delete(1,false), 'Hard delete failed : %s');
		$this->assertFalse($this->Article->read(null,1), 'Article still exists : %s');
		$result = $this->Article->ArticlePage->find('count', array(
			'recursive' => -1,
			'conditions' => array('article_id' => 1)));
		$this->assertIdentical($result, 0, 'Article still has pages : %s');
		$result = $this->Article->ArticlePage->DraftModel->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => $pageIDs)));
		$this->assertIdentical($result, 0, 'Article\'s pages still has drafts : %s');

		$result = $this->Article->ArticlePage->ShadowModel->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => $pageIDs)));
		$this->assertIdentical($result, 0, 'Article\'s pages still has revisions : %s');

	}

	function testPublishFlow() {
		$this->loadFixtures('User','Category');
		$data = array('Article' => array(
			'title' => 'Test Article',
			'category_id' => 2,
			'user_id' => 1
		));
		$this->Article->create($data);
		$this->Article->save();

		/**
		 *  @todo Should this setting be automatic?
		 *  ie check if Article publish status = 0 + publised_data = null
		 */
		$this->saveDraft = false;
		$this->Article->Intro->saveDraft = false;

		$this->assertFalse($this->Article->published(1), 'Article started out published : %S');

		$this->assertTrue($this->Article->publish(1), 'Failed to publish Article : %s');

		$this->assertTrue($this->Article->published(1), 'Article did not get published : %S');

		$this->assertTrue($this->Article->delete(1), 'Failed to softdelete article : %s');

		$this->assertFalse($this->Article->published(1), 'Article deletion did not unpublish : %S');

		$this->assertTrue($this->Article->undelete(1), 'Failed to undelete article : %s');

		$this->assertFalse($this->Article->published(1), 'Article undelete published article : %S');
		
		$this->assertTrue($this->Article->delete(1, false), 'Failed to harddelete article : %s');

		$result = $this->Article->find('all');
		$this->assertTrue(empty($result), 'Article wasnt deleted : %s');
	}

	function testLanguage() {
		$this->loadFixtures('Article','ArticlePage');
		$this->Article->Behaviors->attach('Containable');

		$result = $this->Article->find('first', array(
			'conditions' => array('Article.id' => 1),
			'contain' => array('Intro','ArticlePage' )
		));

		//verify good start data
		$this->assertFalse(empty($result['Article']));
		if ($this->skipIf(empty($result['Article']),'No Article')) return;
		$this->assertTrue(empty($result['Article']['parent_id']));
		$this->assertFalse(empty($result['Intro']));
		$this->assertFalse(empty($result['Intro']['content']));
		$this->assertEqual('eng', $result['Article']['lang']);
		$this->assertEqual(1, sizeof($result['ArticlePage']));
		if ($this->skipIf(empty($result['ArticlePage']),'No Article pages')) return;

		// create a norwegian version
		$NorwegianData = array(
			'Article' => array(
				'parent_id' => 1,
				'lang' => 'nob',
				'title' => 'Norsk Artikkel',
				'category_id' => 2,
				'user_id' => 1
			),
			'Intro' => array(
				'content' => 'introduksjon'
			)
		);
		$NorwegianDataPageOne = array(
			'ArticlePage' => array(
				'page_number' => 1,
				'title' => 'side 1',
				'content' => 'innhold 1'
			)
		);
		// Do not save drafts for this test
		$this->Article->Intro->saveDraft = false;
		$this->Article->ArticlePage->saveDraft = false;
		$this->Article->create($NorwegianData);
		$this->Article->saveAll();
		$NorwegianDataPageOne['ArticlePage']['article_id'] = $this->Article->id;
		$this->Article->ArticlePage->create($NorwegianDataPageOne);
		$this->Article->ArticlePage->save();

		$result = $this->Article->find('first', array(
			'conditions' => array('Article.id' => 2),
			'contain' => array('Intro','ArticlePage')
		));
		$this->assertFalse(empty($result['Article']));
		if ($this->skipIf(empty($result['Article']),'No Norwegian Article')) return;
		$this->assertEqual(1,$result['Article']['parent_id']);
		$this->assertFalse(empty($result['Intro']));
		$this->assertFalse(empty($result['Intro']['content']));
		$this->assertEqual('nob', $result['Article']['lang']);
		$this->assertEqual(1, sizeof($result['ArticlePage']));
		$this->assertFalse(empty($result['ArticlePage']));

		$result = $this->Article->find('all', array(
			'conditions' => array('lang' => 'nob'),
			'contain' => array(),
			'fields' => array('id','title','slug','parent_id','lang')
		));
		$this->assertEqual(1, sizeof($result));
		$this->assertEqual('Norsk Artikkel',$result[0]['Article']['title']);
		
		$result = $this->Article->find('all', array(
			'conditions' => array('lang' => 'eng'),
			'contain' => array(),
			'fields' => array('id','title','slug','parent_id','lang')
		));
		$this->assertEqual(1, sizeof($result));
		$this->assertEqual('Lorem ipsum dolor sit amet',$result[0]['Article']['title']);

		$result = $this->Article->languages(1); // ask for all languages for this article
		$expected = array('eng' => 'Lorem ipsum dolor sit amet','nob' => 'Norsk Artikkel');
		$this->assertEqual($result,$expected);

		$result = $this->Article->languages(1, false); // ask for other all languages
		$expected = array('nob' => 'Norsk Artikkel');
		$this->assertEqual($result,$expected);
	}

}
?>