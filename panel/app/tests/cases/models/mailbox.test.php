<?php 
/* SVN FILE: $Id$ */
/* Mailbox Test cases generated on: 2009-05-12 21:05:13 : 1242156253*/
App::import('Model', 'Mailbox');

class MailboxTestCase extends CakeTestCase {
	var $Mailbox = null;
	var $fixtures = array('app.mailbox', 'app.domain');

	function startTest() {
		$this->Mailbox =& ClassRegistry::init('Mailbox');
	}

	function testMailboxInstance() {
		$this->assertTrue(is_a($this->Mailbox, 'Mailbox'));
	}

	function testMailboxFind() {
		$this->Mailbox->recursive = -1;
		$results = $this->Mailbox->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Mailbox' => array(
			'id'  => 1,
			'domain_id'  => 1,
			'name'  => 'Lorem ipsum dolor sit amet',
			'created'  => '2009-05-12 21:24:13',
			'status'  => 1
		));
		$this->assertEqual($results, $expected);
	}
}
?>