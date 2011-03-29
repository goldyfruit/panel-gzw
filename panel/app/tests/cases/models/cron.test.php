<?php 
/* SVN FILE: $Id$ */
/* Cron Test cases generated on: 2009-05-20 14:05:01 : 1242823321*/
App::import('Model', 'Cron');

class CronTestCase extends CakeTestCase {
	var $Cron = null;
	var $fixtures = array('app.cron', 'app.user');

	function startTest() {
		$this->Cron =& ClassRegistry::init('Cron');
	}

	function testCronInstance() {
		$this->assertTrue(is_a($this->Cron, 'Cron'));
	}

	function testCronFind() {
		$this->Cron->recursive = -1;
		$results = $this->Cron->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Cron' => array(
			'id'  => 1,
			'user_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'path'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-05-20 14:42:01',
			'type'  => 'Lorem ipsum dolor sit amet'
		));
		$this->assertEqual($results, $expected);
	}
}
?>