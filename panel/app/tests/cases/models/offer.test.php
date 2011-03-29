<?php 
/* SVN FILE: $Id$ */
/* Offer Test cases generated on: 2009-09-08 11:31:35 : 1252402295*/
App::import('Model', 'Offer');

class OfferTestCase extends CakeTestCase {
	var $Offer = null;
	var $fixtures = array('app.offer', 'app.quota', 'app.user');

	function startTest() {
		$this->Offer =& ClassRegistry::init('Offer');
	}

	function testOfferInstance() {
		$this->assertTrue(is_a($this->Offer, 'Offer'));
	}

	function testOfferFind() {
		$this->Offer->recursive = -1;
		$results = $this->Offer->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Offer' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'status'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>