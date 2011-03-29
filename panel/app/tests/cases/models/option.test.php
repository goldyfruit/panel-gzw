<?php 
/* SVN FILE: $Id$ */
/* Option Test cases generated on: 2009-06-04 16:06:08 : 1244125028*/
App::import('Model', 'Option');

class OptionTestCase extends CakeTestCase {
	var $Option = null;
	var $fixtures = array('app.option');

	function startTest() {
		$this->Option =& ClassRegistry::init('Option');
	}

	function testOptionInstance() {
		$this->assertTrue(is_a($this->Option, 'Option'));
	}

	function testOptionFind() {
		$this->Option->recursive = -1;
		$results = $this->Option->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Option' => array(
			'id'  => 1,
			'version'  => 'Lorem ip',
			'name'  => 'Lorem ipsum dolor sit amet',
			'maintenance'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>