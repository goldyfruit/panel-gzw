<?php 
/* SVN FILE: $Id$ */
/* Virtualdomain Test cases generated on: 2009-10-19 15:02:41 : 1255957361*/
App::import('Model', 'Virtualdomain');

class VirtualdomainTestCase extends CakeTestCase {
	var $Virtualdomain = null;
	var $fixtures = array('app.virtualdomain');

	function startTest() {
		$this->Virtualdomain =& ClassRegistry::init('Virtualdomain');
	}

	function testVirtualdomainInstance() {
		$this->assertTrue(is_a($this->Virtualdomain, 'Virtualdomain'));
	}

	function testVirtualdomainFind() {
		$this->Virtualdomain->recursive = -1;
		$results = $this->Virtualdomain->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Virtualdomain' => array(
			'domain'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet',
			'aliases'  => 1,
			'mailboxes'  => 1,
			'maxquota'  => 1,
			'transport'  => 'Lorem ipsum dolor sit amet',
			'backupmx'  => 1,
			'created'  => '2009-10-19 15:02:41',
			'modified'  => '2009-10-19 15:02:41',
			'active'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>