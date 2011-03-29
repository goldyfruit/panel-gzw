<?php 
/* SVN FILE: $Id$ */
/* Profile Test cases generated on: 2009-05-12 21:05:55 : 1242156235*/
App::import('Model', 'Profile');

class ProfileTestCase extends CakeTestCase {
	var $Profile = null;
	var $fixtures = array('app.profile', 'app.user');

	function startTest() {
		$this->Profile =& ClassRegistry::init('Profile');
	}

	function testProfileInstance() {
		$this->assertTrue(is_a($this->Profile, 'Profile'));
	}

	function testProfileFind() {
		$this->Profile->recursive = -1;
		$results = $this->Profile->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Profile' => array(
			'id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>