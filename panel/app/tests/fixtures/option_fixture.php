<?php 
/* SVN FILE: $Id$ */
/* Option Fixture generated on: 2009-06-04 16:06:08 : 1244125028*/

class OptionFixture extends CakeTestFixture {
	var $name = 'Option';
	var $table = 'options';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'version' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 10),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'maintenance' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 4),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'version'  => 'Lorem ip',
		'name'  => 'Lorem ipsum dolor sit amet',
		'maintenance'  => 1
	));
}
?>