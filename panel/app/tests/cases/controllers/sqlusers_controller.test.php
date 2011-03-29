<?php 
/* SVN FILE: $Id$ */
/* SqlusersController Test cases generated on: 2009-08-19 16:08:29 : 1250692769*/
App::import('Controller', 'Sqlusers');

class TestSqlusers extends SqlusersController {
	var $autoRender = false;
}

class SqlusersControllerTest extends CakeTestCase {
	var $Sqlusers = null;

	function setUp() {
		$this->Sqlusers = new TestSqlusers();
		$this->Sqlusers->constructClasses();
	}

	function testSqlusersControllerInstance() {
		$this->assertTrue(is_a($this->Sqlusers, 'SqlusersController'));
	}

	function tearDown() {
		unset($this->Sqlusers);
	}
}
?>