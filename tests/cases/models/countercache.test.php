<?php
class CounterArticle extends CakeTestModel {
	public $alias = 'Article';
	public $useTable = 'articles';
	public $recursive = -1;
	public $belongsTo = array('Category' => array('className' => 'CounterCategory'));
	public $hasMany = array('Page' => array('className' => 'CounterPage'));
}
class CounterPage extends CakeTestModel {
	public $alias = 'Page';
	public $useTable = 'article_pages';
	public $belongsTo = array('Article' => array(
		'counterCache' => 'article_page_count',
		'counterScope' => array('page_number !=' => 0),
		'className' => 'CounterArticle'));
}
class CounterCategory extends CakeTestModel {
	public $alias = 'Category';
	public $useTable = 'categories';
	public $belongsTo = array('Article' => array('className' => 'CounterArticle'));
}



class ArticleTestCase extends CakeTestCase {
	public $fixtures = array('app.article_page','app.article','app.category');
	public $autoFixtures = false;
	private $Article = null;

	function startTest() {
		$this->Article =& ClassRegistry::init('CounterArticle');
	}

	function endTest() {
		unset($this->Article);
		ClassRegistry::flush();
	}

	function testCounterCacheQueries() {
		$this->loadFixtures('Article','Category','ArticlePage');
		$result = $this->Article->find('first');
		$this->assertEqual(1, $result['Article']['article_page_count']);

		$this->Article->Page->save(array('Page' => array(
			'article_id' => 1, 'page_number' => 2, 'title' => 'test title', 'content' => 'test_content')));
		$result = $this->Article->find('first');
		$this->assertEqual(2, $result['Article']['article_page_count']);

		$this->Article->Page->create();
		$this->Article->Page->save(array('Page' => array(
			'article_id' => 1, 'page_number' => 3, 'title' => 'test title', 'content' => 'test_contentd')));
		$thirdPageId = $this->Article->Page->id;
		$result = $this->Article->find('first');
		$this->assertEqual(3, $result['Article']['article_page_count']);

		$this->Article->Page->create();
		$this->Article->Page->save(array('Page' => array(
			'article_id' => 1, 'page_number' => 4, 'title' => 'test title', 'content' => 'test_contendt')));
		$result = $this->Article->find('first');
		$this->assertEqual(4, $result['Article']['article_page_count']);

		$this->Article->Page->create();
		$this->Article->Page->save(array('Page' => array('id' => $thirdPageId,'title' => 'edit title')));
		$result = $this->Article->find('first');
		$this->assertEqual(4, $result['Article']['article_page_count']);
	}
}
?>
