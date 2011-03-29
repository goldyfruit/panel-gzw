<?php 
/* SVN FILE: $Id$ */
/* Mailbox Fixture generated on: 2009-05-12 21:05:13 : 1242156253*/

class MailboxFixture extends CakeTestFixture {
	var $name = 'Mailbox';
	var $table = 'mailboxes';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'domain_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'domain_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-05-12 21:24:13',
		'status'  => 1
	));
}
?>