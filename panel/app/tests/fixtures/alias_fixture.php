<?php 
/* SVN FILE: $Id$ */
/* Alias Fixture generated on: 2009-05-12 21:05:54 : 1242156294*/

class AliasFixture extends CakeTestFixture {
	var $name = 'Alias';
	var $table = 'aliases';
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
		'created'  => '2009-05-12 21:24:54',
		'status'  => 1
	));
}
?>