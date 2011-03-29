<?php 
/* SVN FILE: $Id$ */
/* Sqldatabasis Fixture generated on: 2009-09-03 10:09:21 : 1251964821*/

class SqldatabasisFixture extends CakeTestFixture {
	var $name = 'Sqldatabasis';
	var $table = 'sqldatabases';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'sqluser_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'type' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'sqluser_id'  => 1,
		'user_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-09-03 10:00:21',
		'modified'  => '2009-09-03 10:00:21',
		'type'  => 'Lorem ipsum dolor sit amet'
	));
}
?>