<?php 
/* SVN FILE: $Id$ */
/* ModulesController Test cases generated on: 2009-06-03 13:06:42 : 1244027802*/
App::import('Controller', 'Modules');

class TestModules extends ModulesController {
	var $autoRender = false;
}

class ModulesControllerTest extends CakeTestCase {
	var $Modules = null;

	function setUp() {
		$this->Modules = new TestModules();
		$this->Modules->constructClasses();
	}

	function testModulesControllerInstance() {
		$this->assertTrue(is_a($this->Modules, 'ModulesController'));
	}

	function tearDown() {
		unset($this->Modules);
	}
}
?>