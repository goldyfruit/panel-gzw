<?php 
/* SVN FILE: $Id$ */
/* Domain Fixture generated on: 2009-05-12 22:05:27 : 1242158727*/

class DomainFixture extends CakeTestFixture {
	var $name = 'Domain';
	var $table = 'domains';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'created' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'user_id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'created'  => '2009-05-12 22:05:27'
	));
}
?>