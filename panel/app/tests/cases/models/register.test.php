<?php
/* Register Test cases generated on: 2011-03-24 21:03:56 : 1300997816*/
App::import('Model', 'Register');

class RegisterTestCase extends CakeTestCase {
	var $fixtures = array('app.register');

	function startTest() {
		$this->Register =& ClassRegistry::init('Register');
	}

	function endTest() {
		unset($this->Register);
		ClassRegistry::flush();
	}

}
?>