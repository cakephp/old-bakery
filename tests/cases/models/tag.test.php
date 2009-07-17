<?php
/* Tag Test cases generated on: 2009-07-17 22:07:14 : 1247860814*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $fixtures = array('app.tag','app.article','app.articles_tag','app.article_page','app.user','app.category');
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
	}

}
?>