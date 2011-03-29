<?php 
/* SVN FILE: $Id$ */
/* SqldatasController Test cases generated on: 2009-09-03 10:26:50 : 1251966410*/
App::import('Controller', 'Sqldatas');

class TestSqldatas extends SqldatasController {
	var $autoRender = false;
}

class SqldatasControllerTest extends CakeTestCase {
	var $Sqldatas = null;

	function startTest() {
		$this->Sqldatas = new TestSqldatas();
		$this->Sqldatas->constructClasses();
	}

	function testSqldatasControllerInstance() {
		$this->assertTrue(is_a($this->Sqldatas, 'SqldatasController'));
	}

	function endTest() {
		unset($this->Sqldatas);
	}
}
?>