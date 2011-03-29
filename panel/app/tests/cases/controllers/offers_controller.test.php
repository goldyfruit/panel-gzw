<?php 
/* SVN FILE: $Id$ */
/* OffersController Test cases generated on: 2009-05-14 18:05:24 : 1242319164*/
App::import('Controller', 'Offers');

class TestOffers extends OffersController {
	var $autoRender = false;
}

class OffersControllerTest extends CakeTestCase {
	var $Offers = null;

	function startTest() {
		$this->Offers = new TestOffers();
		$this->Offers->constructClasses();
	}

	function testOffersControllerInstance() {
		$this->assertTrue(is_a($this->Offers, 'OffersController'));
	}

	function endTest() {
		unset($this->Offers);
	}
}
?>