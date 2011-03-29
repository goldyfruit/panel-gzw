<?php 
/* SVN FILE: $Id$ */
/* Sqldatabasis Test cases generated on: 2009-09-03 10:09:24 : 1251964824*/
App::import('Model', 'Sqldatabasis');

class SqldatabasisTestCase extends CakeTestCase {
	var $Sqldatabasis = null;
	var $fixtures = array('app.sqldatabasis', 'app.sqluser', 'app.user');

	function startTest() {
		$this->Sqldatabasis =& ClassRegistry::init('Sqldatabasis');
	}

	function testSqldatabasisInstance() {
		$this->assertTrue(is_a($this->Sqldatabasis, 'Sqldatabasis'));
	}

	function testSqldatabasisFind() {
		$this->Sqldatabasis->recursive = -1;
		$results = $this->Sqldatabasis->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Sqldatabasis' => array(
			'id'  => 1,
			'sqluser_id'  => 1,
			'user_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-09-03 10:00:21',
			'modified'  => '2009-09-03 10:00:21',
			'type'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>