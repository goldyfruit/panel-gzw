<?php 
/* SVN FILE: $Id$ */
/* Virtualdomain Fixture generated on: 2009-10-19 15:02:41 : 1255957361*/

class VirtualdomainFixture extends CakeTestFixture {
	var $name = 'Virtualdomain';
	var $table = 'virtualdomains';
	var $fields = array(
		'domain' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'description' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'aliases' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'mailboxes' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'maxquota' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'transport' => array('type'=>'string', 'null' => true, 'default' => NULL),
		'backupmx' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'active' => array('type'=>'boolean', 'null' => false, 'default' => '1'),
		'indexes' => array('PRIMARY' => array('column' => 'domain', 'unique' => 1))
	);
	var $records = array(array(
		'domain'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet',
		'aliases'  => 1,
		'mailboxes'  => 1,
		'maxquota'  => 1,
		'transport'  => 'Lorem ipsum dolor sit amet',
		'backupmx'  => 1,
		'created'  => '2009-10-19 15:02:41',
		'modified'  => '2009-10-19 15:02:41',
		'active'  => 1
	));
}
?>