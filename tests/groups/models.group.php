<?php
class ModelsGroupTest extends GroupTest {
  var $label = 'Models';

  function modelsGroupTest() {
  //  TestManager::addTestCasesFromDirectory($this, APP_TEST_CASES . DS . 'models' );
	TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models' . DS . 'article.test.php');
	TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models' . DS . 'article_page.test.php');
	TestManager::addTestFile($this, APP_TEST_CASES . DS . 'models' . DS . 'tag.test.php');
  }
}
?>