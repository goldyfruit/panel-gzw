<?php 
/* SVN FILE: $Id$ */
/* ProfilesController Test cases generated on: 2009-05-14 18:05:35 : 1242319175*/
App::import('Controller', 'Profiles');

class TestProfiles extends ProfilesController {
	var $autoRender = false;
}

class ProfilesControllerTest extends CakeTestCase {
	var $Profiles = null;

	function startTest() {
		$this->Profiles = new TestProfiles();
		$this->Profiles->constructClasses();
	}

	function testProfilesControllerInstance() {
		$this->assertTrue(is_a($this->Profiles, 'ProfilesController'));
	}

	function endTest() {
		unset($this->Profiles);
	}
}
?>