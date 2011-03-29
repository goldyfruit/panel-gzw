<?php 
/* SVN FILE: $Id$ */
/* QuotasController Test cases generated on: 2009-09-07 13:49:38 : 1252324178*/
App::import('Controller', 'Quotas');

class TestQuotas extends QuotasController {
	var $autoRender = false;
}

class QuotasControllerTest extends CakeTestCase {
	var $Quotas = null;

	function startTest() {
		$this->Quotas = new TestQuotas();
		$this->Quotas->constructClasses();
	}

	function testQuotasControllerInstance() {
		$this->assertTrue(is_a($this->Quotas, 'QuotasController'));
	}

	function endTest() {
		unset($this->Quotas);
	}
}
?>