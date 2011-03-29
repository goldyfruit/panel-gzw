<?php 
/* SVN FILE: $Id$ */
/* Module Test cases generated on: 2009-06-03 13:06:18 : 1244027778*/
App::import('Model', 'Module');

class ModuleTestCase extends CakeTestCase {
	var $Module = null;
	var $fixtures = array('app.module');

	function startTest() {
		$this->Module =& ClassRegistry::init('Module');
	}

	function testModuleInstance() {
		$this->assertTrue(is_a($this->Module, 'Module'));
	}

	function testModuleFind() {
		$this->Module->recursive = -1;
		$results = $this->Module->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Module' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'link'  => 'Lorem ipsum dolor sit amet',
			'version'  => 'Lor',
			'status'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>