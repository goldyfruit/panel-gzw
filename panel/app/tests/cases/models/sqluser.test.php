<?php 
/* SVN FILE: $Id$ */
/* Sqluser Test cases generated on: 2009-08-19 10:08:25 : 1250669425*/
App::import('Model', 'Sqluser');

class SqluserTestCase extends CakeTestCase {
	var $Sqluser = null;
	var $fixtures = array('app.sqluser', 'app.user');

	function startTest() {
		$this->Sqluser =& ClassRegistry::init('Sqluser');
	}

	function testSqluserInstance() {
		$this->assertTrue(is_a($this->Sqluser, 'Sqluser'));
	}

	function testSqluserFind() {
		$this->Sqluser->recursive = -1;
		$results = $this->Sqluser->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Sqluser' => array(
			'id'  => 1,
			'user_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-08-19 10:10:25',
			'modified'  => '2009-08-19 10:10:25',
			'status'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>