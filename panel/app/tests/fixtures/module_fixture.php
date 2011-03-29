<?php 
/* SVN FILE: $Id$ */
/* Module Fixture generated on: 2009-06-03 13:06:18 : 1244027778*/

class ModuleFixture extends CakeTestFixture {
	var $name = 'Module';
	var $table = 'modules';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'link' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'version' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 5),
		'status' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'link'  => 'Lorem ipsum dolor sit amet',
		'version'  => 'Lor',
		'status'  => 1
	));
}
?>