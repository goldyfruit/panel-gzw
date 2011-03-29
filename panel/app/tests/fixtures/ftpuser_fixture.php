<?php 
/* SVN FILE: $Id$ */
/* Ftpuser Fixture generated on: 2009-10-10 11:23:25 : 1255166605*/

class FtpuserFixture extends CakeTestFixture {
	var $name = 'Ftpuser';
	var $table = 'ftpusers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'key' => 'unique'),
		'password' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'uid' => array('type'=>'integer', 'null' => true, 'default' => '5500', 'length' => 6),
		'gid' => array('type'=>'integer', 'null' => true, 'default' => '5500', 'length' => 6),
		'homedir' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'shell' => array('type'=>'string', 'null' => false, 'default' => '/sbin/nologin', 'length' => 16),
		'count' => array('type'=>'integer', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'accessed' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
		'status' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'userid' => array('column' => 'name', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'uid'  => 1,
		'gid'  => 1,
		'homedir'  => 'Lorem ipsum dolor sit amet',
		'shell'  => 'Lorem ipsum do',
		'count'  => 1,
		'created'  => '2009-10-10 11:23:25',
		'accessed'  => '2009-10-10 11:23:25',
		'modified'  => '2009-10-10 11:23:25',
		'status'  => 1
	));
}
?>