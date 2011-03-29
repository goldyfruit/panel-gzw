<?php 
/* SVN FILE: $Id$ */
/* Subdomain Test cases generated on: 2009-05-12 22:05:27 : 1242158667*/
App::import('Model', 'Subdomain');

class SubdomainTestCase extends CakeTestCase {
	var $Subdomain = null;
	var $fixtures = array('app.subdomain', 'app.domain');

	function startTest() {
		$this->Subdomain =& ClassRegistry::init('Subdomain');
	}

	function testSubdomainInstance() {
		$this->assertTrue(is_a($this->Subdomain, 'Subdomain'));
	}

	function testSubdomainFind() {
		$this->Subdomain->recursive = -1;
		$results = $this->Subdomain->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Subdomain' => array(
			'id'  => 1,
			'domain_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-05-12 22:04:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>