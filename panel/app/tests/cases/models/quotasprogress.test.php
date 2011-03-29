<?php 
/* SVN FILE: $Id$ */
/* Quotasprogress Test cases generated on: 2010-03-29 18:49:39 : 1269881379*/
App::import('Model', 'Quotasprogress');

class QuotasprogressTestCase extends CakeTestCase {
	var $Quotasprogress = null;
	var $fixtures = array('app.quotasprogress', 'app.user', 'app.offer');

	function startTest() {
		$this->Quotasprogress =& ClassRegistry::init('Quotasprogress');
	}

	function testQuotasprogressInstance() {
		$this->assertTrue(is_a($this->Quotasprogress, 'Quotasprogress'));
	}

	function testQuotasprogressFind() {
		$this->Quotasprogress->recursive = -1;
		$results = $this->Quotasprogress->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Quotasprogress' => array(
			'id' => 1,
			'int' => 1,
			'user_id' => 1,
			'offer_id' => 1,
			'bandwidth' => 1,
			'diskspace' => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>