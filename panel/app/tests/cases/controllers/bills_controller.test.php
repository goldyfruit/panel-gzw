<?php
/* Bills Test cases generated on: 2011-01-16 19:01:39 : 1295200959*/
App::import('Controller', 'Bills');

class TestBillsController extends BillsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class BillsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.bill', 'app.user', 'app.profile', 'app.offer', 'app.quota', 'app.domain', 'app.ftpuser', 'app.cron');

	function startTest() {
		$this->Bills =& new TestBillsController();
		$this->Bills->constructClasses();
	}

	function endTest() {
		unset($this->Bills);
		ClassRegistry::flush();
	}

}
?>