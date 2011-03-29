<?php 
/* SVN FILE: $Id$ */
/* Cron Fixture generated on: 2009-05-20 14:05:01 : 1242823321*/

class CronFixture extends CakeTestFixture {
	var $name = 'Cron';
	var $table = 'crons';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'path' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'description' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'type' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'path'  => 'Lorem ipsum dolor sit amet',
		'description'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-05-20 14:42:01',
		'type'  => 'Lorem ipsum dolor sit amet'
	));
}
?>