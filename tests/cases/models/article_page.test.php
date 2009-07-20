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
		$this->loadFixtures('ArticlePage');
		$this->ArticlePage->id = 1;
		$result = $this->ArticlePage->field('title');
		$this->assertEqual($result,'Lorem ipsum dolor sit amet');

		$this->ArticlePage->save(array('ArticlePage'=>array('id'=>1, 'title' => 'edited title')));

		$this->assertEqual($this->ArticlePage->hasDraft(1), 1);
		$result = $this->ArticlePage->field('title');
		$this->assertEqual($result,'Lorem ipsum dolor sit amet');

		$this->assertTrue($this->ArticlePage->acceptDraft(1));

		$result = $this->ArticlePage->field('title');
		$this->assertEqual($result,'edited title');
	}
	
}
?>