<?php
/* Tag Test cases generated on: 2009-07-17 22:07:14 : 1247860814*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	public $fixtures = array('app.article_page','app.article_pages_draft','app.article_pages_rev',
			'app.tag','app.article','app.articles_tag','plugin.users.user','app.category','app.rating',
			'plugin.users.conversation','plugin.users.message','plugin.users.conversations_user','plugin.users.user');
	public $autoFixtures = false;
	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function endTest() {
		unset($this->Tag);
		ClassRegistry::flush();
	}

	function testTagCreate() {
		$result = $this->Tag->create(array('Tag' => array('name' => 'Top')));
		$expected = array('Tag' => array('linked'=>0,'name' => 'Top', 'keyname' => 'Top'));
		$this->assertEqual($result, $expected);

		$result = $this->Tag->create(array('Tag' => array('name' => 'Lorem ipsum dorem')));
		$expected = array('Tag' => array('linked'=>0,'name' => 'Lorem ipsum dorem', 'keyname' => 'Lorem_ipsum_dorem'));
		$this->assertEqual($result, $expected);
	}

	function testSaveArticleTag() {
		$result = $this->Tag->saveArticleTags();
		$this->assertNull($result);

		$result = $this->Tag->saveArticleTags('');
		$this->assertNull($result);

		$result = $this->Tag->saveArticleTags('Fun');
		$expected = array(1);
		$this->assertEqual($result,$expected);

		$result = $this->Tag->saveArticleTags('Fun,Love');
		$expected = array(1,2);
		$this->assertEqual($result,$expected);

		$result = $this->Tag->saveArticleTags('Hate,Php');
		$expected = array(3,4);
		$this->assertEqual($result,$expected);

		$result = $this->Tag->saveArticleTags('Love,New,Php');
		$expected = array(2,4,5);
		$this->assertEqual($result,$expected);

		$result = $this->Tag->saveArticleTags('Love,fun,New,Php');
		$expected = array(1,2,4,5);
		$this->assertEqual($result,$expected);
	}

	function testSaveArticleWithTags() {
		$this->loadFixtures('Article','ArticlePage','ArticlesTag','Tag');
		$this->Tag->Behaviors->attach('Containable');
		$this->Tag->Article->Behaviors->attach('Containable');
		$tags = $this->Tag->saveArticleTags('Stuff,Joy,News');
		if ($this->skipIf(
				empty($tags) ||
				!is_array($tags) ||
				sizeof($tags) != 3 ||
				$tags[0] != 1 ||
				$tags[1] != 3 ||
				$tags[2] != 4,
			'saveArticleTags() does not work')) return;

		$articleData = array(
			'Article' => array(
				'parent_id' => 1,
				'title' => 'A tagged article',
				'category_id' => 1,
				'user_id' => 1
			),
			'Intro' => array(
				'content' => 'Intro to a tag system'
			),
			'Tag' => array(
				'Tag' => $tags
			)
		);		
		$this->Tag->Article->create($articleData);
		$this->Tag->Article->Intro->saveDraft = false;
		$this->Tag->Article->ArticlePage->saveDraft = false;
		$this->assertTrue($this->Tag->Article->saveAll());

		$this->Tag->Article->contain('Intro','Tag');
		$result = $this->Tag->Article->read();
		$this->assertFalse(empty($result));
		$this->assertEqual(2, $result['Article']['id']);
		$this->assertEqual('A tagged article', $result['Article']['title']);
		$this->assertEqual('Intro to a tag system', $result['Intro']['content']);
		$this->assertEqual(3, sizeof($result['Tag']), 'Not enough tag saved : %s');
		if ($this->skipIf(3 != sizeof($result['Tag']), 'Not enough tag saved'));
		$this->assertEqual(1,$result['Tag'][0]['id']);
		$this->assertEqual('News',$result['Tag'][0]['name']);
		$this->assertEqual(3,$result['Tag'][1]['id']);
		$this->assertEqual('Stuff',$result['Tag'][1]['name']);
		$this->assertEqual(4,$result['Tag'][2]['id']);
		$this->assertEqual('Joy',$result['Tag'][2]['name']);
	}

}
?>