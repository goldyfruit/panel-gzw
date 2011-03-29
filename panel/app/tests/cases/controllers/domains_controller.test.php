<?php 
/* SVN FILE: $Id$ */
/* DomainsController Test cases generated on: 2009-05-14 18:05:17 : 1242319097*/
App::import('Controller', 'Domains');

class TestDomains extends DomainsController {
	var $autoRender = false;
}

class DomainsControllerTest extends CakeTestCase {
	var $Domains = null;

	function startTest() {
		$this->Domains = new TestDomains();
		$this->Domains->constructClasses();
	}

	function testDomainsControllerInstance() {
		$this->assertTrue(is_a($this->Domains, 'DomainsController'));
	}

	function endTest() {
		unset($this->Domains);
	}
}
?>