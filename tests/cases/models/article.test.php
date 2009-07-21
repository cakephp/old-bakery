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


}
?>