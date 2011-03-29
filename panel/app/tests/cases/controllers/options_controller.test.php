<?php 
/* SVN FILE: $Id$ */
/* OptionsController Test cases generated on: 2009-06-04 16:06:31 : 1244125051*/
App::import('Controller', 'Options');

class TestOptions extends OptionsController {
	var $autoRender = false;
}

class OptionsControllerTest extends CakeTestCase {
	var $Options = null;

	function setUp() {
		$this->Options = new TestOptions();
		$this->Options->constructClasses();
	}

	function testOptionsControllerInstance() {
		$this->assertTrue(is_a($this->Options, 'OptionsController'));
	}

	function tearDown() {
		unset($this->Options);
	}
}
?>