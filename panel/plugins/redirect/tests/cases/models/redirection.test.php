<?php
/* Redirection Test cases generated on: 2011-03-01 19:03:48 : 1299002928*/
App::import('Model', 'Redirect.Redirection');

class RedirectionTestCase extends CakeTestCase {
	function startTest() {
		$this->Redirection =& ClassRegistry::init('Redirection');
	}

	function endTest() {
		unset($this->Redirection);
		ClassRegistry::flush();
	}

}
?>