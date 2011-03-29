<?php 
/* SVN FILE: $Id$ */
/* Domain Test cases generated on: 2009-05-12 22:05:27 : 1242158727*/
App::import('Model', 'Domain');

class DomainTestCase extends CakeTestCase {
	var $Domain = null;
	var $fixtures = array('app.domain', 'app.user', 'app.alias', 'app.mailbox', 'app.subdomain');

	function startTest() {
		$this->Domain =& ClassRegistry::init('Domain');
	}

	function testDomainInstance() {
		$this->assertTrue(is_a($this->Domain, 'Domain'));
	}

	function testDomainFind() {
		$this->Domain->recursive = -1;
		$results = $this->Domain->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Domain' => array(
			'id'  => 1,
			'user_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-05-12 22:05:27'
		));
		$this->assertEqual($results, $expected);
	}
}
?>