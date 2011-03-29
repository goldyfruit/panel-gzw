<?php 
/* SVN FILE: $Id$ */
/* MailboxesController Test cases generated on: 2009-05-14 18:05:17 : 1242319157*/
App::import('Controller', 'Mailboxes');

class TestMailboxes extends MailboxesController {
	var $autoRender = false;
}

class MailboxesControllerTest extends CakeTestCase {
	var $Mailboxes = null;

	function startTest() {
		$this->Mailboxes = new TestMailboxes();
		$this->Mailboxes->constructClasses();
	}

	function testMailboxesControllerInstance() {
		$this->assertTrue(is_a($this->Mailboxes, 'MailboxesController'));
	}

	function endTest() {
		unset($this->Mailboxes);
	}
}
?>