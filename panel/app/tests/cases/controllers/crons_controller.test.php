<?php 
/* SVN FILE: $Id$ */
/* CronsController Test cases generated on: 2009-05-20 14:05:12 : 1242823332*/
App::import('Controller', 'Crons');

class TestCrons extends CronsController {
	var $autoRender = false;
}

class CronsControllerTest extends CakeTestCase {
	var $Crons = null;

	function setUp() {
		$this->Crons = new TestCrons();
		$this->Crons->constructClasses();
	}

	function testCronsControllerInstance() {
		$this->assertTrue(is_a($this->Crons, 'CronsController'));
	}

	function tearDown() {
		unset($this->Crons);
	}
}
?>