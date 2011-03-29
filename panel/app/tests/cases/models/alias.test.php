<?php 
/* SVN FILE: $Id$ */
/* Alias Test cases generated on: 2009-05-12 21:05:54 : 1242156294*/
App::import('Model', 'Alias');

class AliasTestCase extends CakeTestCase {
	var $Alias = null;
	var $fixtures = array('app.alias', 'app.domain');

	function startTest() {
		$this->Alias =& ClassRegistry::init('Alias');
	}

	function testAliasInstance() {
		$this->assertTrue(is_a($this->Alias, 'Alias'));
	}

	function testAliasFind() {
		$this->Alias->recursive = -1;
		$results = $this->Alias->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Alias' => array(
			'id'  => 1,
			'domain_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-05-12 21:24:54',
			'status'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>