<?php 
/* SVN FILE: $Id$ */
/* Quota Fixture generated on: 2009-09-08 11:31:50 : 1252402310*/

class QuotaFixture extends CakeTestFixture {
	var $name = 'Quota';
	var $table = 'quotas';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'offer_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'ftpuser' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'sqluser' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'database' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'mailbox' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'alias' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'domain' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'subdomain' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'cronjob' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'space' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'taffic' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'offer_id'  => 1,
		'ftpuser'  => 'Lor',
		'sqluser'  => 'Lor',
		'database'  => 'Lor',
		'mailbox'  => 'Lor',
		'alias'  => 'Lor',
		'domain'  => 'Lor',
		'subdomain'  => 'Lor',
		'cronjob'  => 'Lor',
		'space'  => 'Lorem ipsum dolor sit amet',
		'taffic'  => 'Lorem ipsum dolor sit amet'
	));
}
?>