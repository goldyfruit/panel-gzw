<?php 
/* SVN FILE: $Id$ */
/* AliasesController Test cases generated on: 2009-05-14 18:05:03 : 1242319023*/
App::import('Controller', 'Aliases');

class TestAliases extends AliasesController {
	var $autoRender = false;
}

class AliasesControllerTest extends CakeTestCase {
	var $Aliases = null;

	function startTest() {
		$this->Aliases = new TestAliases();
		$this->Aliases->constructClasses();
	}

	function testAliasesControllerInstance() {
		$this->assertTrue(is_a($this->Aliases, 'AliasesController'));
	}

	function endTest() {
		unset($this->Aliases);
	}
}
?>