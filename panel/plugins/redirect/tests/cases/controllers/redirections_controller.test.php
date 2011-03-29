<?php
/* Redirections Test cases generated on: 2011-03-01 19:03:38 : 1299002978*/
App::import('Controller', 'Redirect.Redirections');

class TestRedirectionsController extends RedirectionsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RedirectionsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Redirections =& new TestRedirectionsController();
		$this->Redirections->constructClasses();
	}

	function endTest() {
		unset($this->Redirections);
		ClassRegistry::flush();
	}

}
?>