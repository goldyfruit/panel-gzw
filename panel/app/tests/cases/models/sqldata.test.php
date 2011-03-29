<?php 
/* SVN FILE: $Id$ */
/* Sqldata Test cases generated on: 2009-09-03 10:26:38 : 1251966398*/
App::import('Model', 'Sqldata');

class SqldataTestCase extends CakeTestCase {
	var $Sqldata = null;
	var $fixtures = array('app.sqldata', 'app.sqluser', 'app.user');

	function startTest() {
		$this->Sqldata =& ClassRegistry::init('Sqldata');
	}

	function testSqldataInstance() {
		$this->assertTrue(is_a($this->Sqldata, 'Sqldata'));
	}

	function testSqldataFind() {
		$this->Sqldata->recursive = -1;
		$results = $this->Sqldata->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Sqldata' => array(
			'id'  => 1,
			'sqluser_id'  => 1,
			'user_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-09-03 10:26:38',
			'modified'  => '2009-09-03 10:26:38',
			'type'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>