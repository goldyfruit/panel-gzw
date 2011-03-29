<?php 
/* SVN FILE: $Id$ */
/* OffersUser Test cases generated on: 2009-09-18 11:09:58 : 1253264998*/
App::import('Model', 'OffersUser');

class OffersUserTestCase extends CakeTestCase {
	var $OffersUser = null;
	var $fixtures = array('app.offers_user', 'app.user', 'app.offer');

	function startTest() {
		$this->OffersUser =& ClassRegistry::init('OffersUser');
	}

	function testOffersUserInstance() {
		$this->assertTrue(is_a($this->OffersUser, 'OffersUser'));
	}

	function testOffersUserFind() {
		$this->OffersUser->recursive = -1;
		$results = $this->OffersUser->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('OffersUser' => array(
			'user_id'  => 1,
			'offer_id'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>