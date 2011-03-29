<?php
/* Bill Test cases generated on: 2011-01-16 18:01:03 : 1295200743*/
App::import('Model', 'Bill');

class BillTestCase extends CakeTestCase {
	var $fixtures = array('app.bill', 'app.user', 'app.profile', 'app.offer', 'app.quota', 'app.domain', 'app.ftpuser', 'app.cron');

	function startTest() {
		$this->Bill =& ClassRegistry::init('Bill');
	}

	function endTest() {
		unset($this->Bill);
		ClassRegistry::flush();
	}

}
?>