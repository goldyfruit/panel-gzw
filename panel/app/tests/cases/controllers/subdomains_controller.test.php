<?php 
/* SVN FILE: $Id$ */
/* SubdomainsController Test cases generated on: 2009-05-14 18:05:07 : 1242319207*/
App::import('Controller', 'Subdomains');

class TestSubdomains extends SubdomainsController {
	var $autoRender = false;
}

class SubdomainsControllerTest extends CakeTestCase {
	var $Subdomains = null;

	function startTest() {
		$this->Subdomains = new TestSubdomains();
		$this->Subdomains->constructClasses();
	}

	function testSubdomainsControllerInstance() {
		$this->assertTrue(is_a($this->Subdomains, 'SubdomainsController'));
	}

	function endTest() {
		unset($this->Subdomains);
	}
}
?>