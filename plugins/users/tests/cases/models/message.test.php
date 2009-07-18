<?php 
/* SVN FILE: $Id$ */
/* Message Test cases generated on: 2009-07-19 00:22:59 : 1247955779*/
App::import('Model', 'Users.Message');

class MessageTestCase extends CakeTestCase {
	public $Message = null;
	public $fixtures = array('plugin.users.message', 'plugin.users.conversation', 'plugin.users.user');

	public function startTest() {
		$this->Message =& ClassRegistry::init('Message');
	}

	public function testMessageInstance() {
		$this->assertTrue(is_a($this->Message, 'Message'));
	}

	public function testMessageFind() {
		$this->Message->recursive = -1;
		$results = $this->Message->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Message' => array(
			'id'  => 1,
			'conversation_id'  => 1,
			'user_id'  => 1,
			'message'  => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created'  => '2009-07-19 00:22:59',
			'modified'  => '2009-07-19 00:22:59'
		));
		$this->assertEqual($results, $expected);
	}
}
?>