<?php 
/* SVN FILE: $Id$ */
/* SqldatabasesController Test cases generated on: 2009-09-03 10:09:41 : 1251964841*/
App::import('Controller', 'Sqldatabases');

class TestSqldatabases extends SqldatabasesController {
	var $autoRender = false;
}

class SqldatabasesControllerTest extends CakeTestCase {
	var $Sqldatabases = null;

	function setUp() {
		$this->Sqldatabases = new TestSqldatabases();
		$this->Sqldatabases->constructClasses();
	}

	function testSqldatabasesControllerInstance() {
		$this->assertTrue(is_a($this->Sqldatabases, 'SqldatabasesController'));
	}

	function tearDown() {
		unset($this->Sqldatabases);
	}
}
?>