<?php 
/* SVN FILE: $Id$ */
/* LogsController Test cases generated on: 2010-04-06 17:09:15 : 1270566555*/
App::import('Controller', 'Logs');

class TestLogs extends LogsController {
	var $autoRender = false;
}

class LogsControllerTest extends CakeTestCase {
	var $Logs = null;

	function startTest() {
		$this->Logs = new TestLogs();
		$this->Logs->constructClasses();
	}

	function testLogsControllerInstance() {
		$this->assertTrue(is_a($this->Logs, 'LogsController'));
	}

	function endTest() {
		unset($this->Logs);
	}
}
?>