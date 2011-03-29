<?php
/* Registers Test cases generated on: 2011-03-24 21:03:48 : 1300997868*/
App::import('Controller', 'Registers');

class TestRegistersController extends RegistersController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RegistersControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.register');

	function startTest() {
		$this->Registers =& new TestRegistersController();
		$this->Registers->constructClasses();
	}

	function endTest() {
		unset($this->Registers);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

	function testAdminIndex() {

	}

	function testAdminView() {

	}

	function testAdminAdd() {

	}

	function testAdminEdit() {

	}

	function testAdminDelete() {

	}

}
?>