<?php 
/* SVN FILE: $Id$ */
/* Quota Test cases generated on: 2009-09-08 11:31:51 : 1252402311*/
App::import('Model', 'Quota');

class QuotaTestCase extends CakeTestCase {
	var $Quota = null;
	var $fixtures = array('app.quota', 'app.offer');

	function startTest() {
		$this->Quota =& ClassRegistry::init('Quota');
	}

	function testQuotaInstance() {
		$this->assertTrue(is_a($this->Quota, 'Quota'));
	}

	function testQuotaFind() {
		$this->Quota->recursive = -1;
		$results = $this->Quota->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Quota' => array(
			'id'  => 1,
			'offer_id'  => 1,
			'ftpuser'  => 'Lor',
			'sqluser'  => 'Lor',
			'database'  => 'Lor',
			'mailbox'  => 'Lor',
			'alias'  => 'Lor',
			'domain'  => 'Lor',
			'subdomain'  => 'Lor',
			'cronjob'  => 'Lor',
			'space'  => 'Lorem ipsum dolor sit amet',
			'taffic'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>