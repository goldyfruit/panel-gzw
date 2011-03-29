<?php 
/* SVN FILE: $Id$ */
/* Sqluser Fixture generated on: 2009-08-19 10:08:25 : 1250669425*/

class SqluserFixture extends CakeTestFixture {
	var $name = 'Sqluser';
	var $table = 'sqlusers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'password' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-08-19 10:10:25',
		'modified'  => '2009-08-19 10:10:25',
		'status'  => 1
	));
}
?>