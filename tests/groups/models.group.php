<?php
class ModelsGroupTest extends GroupTest {
  var $label = 'Models';

  function modelsGroupTest() {
    TestManager::addTestCasesFromDirectory($this, APP_TEST_CASES . DS . 'models' );
  }
}
?>