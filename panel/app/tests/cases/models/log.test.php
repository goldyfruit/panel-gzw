<?php 
/* SVN FILE: $Id$ */
/* Log Test cases generated on: 2010-04-08 14:52:41 : 1270731161*/
App::import('Model', 'Log');

class LogTestCase extends CakeTestCase {
	var $Log = null;
	var $fixtures = array('app.log', 'app.user');

	function startTest() {
		$this->Log =& ClassRegistry::init('Log');
	}

	function testLogInstance() {
		$this->assertTrue(is_a($this->Log, 'Log'));
	}

	function testLogFind() {
		$this->Log->recursive = -1;
		$results = $this->Log->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Log' => array(
			'id' => 1,
			'user_id' => 1,
			'action' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'date' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida,phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam,vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit,feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'type' => 'Lorem ipsum dolor sit amet',
			'ip' => 'Lorem ipsum d'
		));
		$this->assertEqual($results, $expected);
	}
}
?>