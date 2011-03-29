<?php 
/* SVN FILE: $Id$ */
/* Sqldata Fixture generated on: 2009-09-03 10:26:38 : 1251966398*/

class SqldataFixture extends CakeTestFixture {
	var $name = 'Sqldata';
	var $table = 'sqldatas';
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
		'created'  => '2009-09-03 10:26:38',
		'modified'  => '2009-09-03 10:26:38',
		'type'  => 'Lorem ipsum dolor sit amet'
	));
}
?>