<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2009-05-12 21:05:51 : 1242156171*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user', 'app.profile', 'app.offer', 'app.domain');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'profile_id'  => 1,
			'lastname'  => 'Lorem ipsum dolor sit amet',
			'firstname'  => 'Lorem ipsum dolor sit amet',
			'email'  => 'Lorem ipsum dolor sit amet',
			'name'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum dolor sit amet',
			'status'  => 1,
			'registered'  => '2009-05-12 21:22:50',
			'offer_id'  => 1,
			'address'  => 'Lorem ipsum dolor sit amet',
			'zipcode'  => 'Lorem ipsum dolor sit amet',
			'city'  => 'Lorem ipsum dolor sit amet',
			'country'  => 'Lorem ipsum dolor sit amet',
			'telephone'  => 'Lorem ipsum dolor sit amet',
			'language'  => 'Lorem ipsum dolor '
		));
		$this->assertEqual($results, $expected);
	}
}
?>