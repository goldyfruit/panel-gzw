<?php 
/* SVN FILE: $Id$ */
/* FtpusersController Test cases generated on: 2009-05-19 13:05:35 : 1242732395*/
App::import('Controller', 'Ftpusers');

class TestFtpusers extends FtpusersController {
	var $autoRender = false;
}

class FtpusersControllerTest extends CakeTestCase {
	var $Ftpusers = null;

	function setUp() {
		$this->Ftpusers = new TestFtpusers();
		$this->Ftpusers->constructClasses();
	}

	function testFtpusersControllerInstance() {
		$this->assertTrue(is_a($this->Ftpusers, 'FtpusersController'));
	}

	function tearDown() {
		unset($this->Ftpusers);
	}
}
?>