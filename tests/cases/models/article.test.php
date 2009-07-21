<?php
App::import('Model', 'Article');

class TagTestCase extends CakeTestCase {
	public $fixtures = array('app.article_page','app.article_pages_draft','app.article_pages_rev','app.tag','app.article','app.articles_tag','app.user','app.category','app.conversation','app.message','app.rating');
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
	
	function testDelete() {
		$this->loadFixtures('Article','ArticlePage');

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

	}
}
?>