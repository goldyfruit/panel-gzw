<?php 
/* SVN FILE: $Id$ */
/* Profile Fixture generated on: 2009-05-12 21:05:55 : 1242156235*/

class ProfileFixture extends CakeTestFixture {
	var $name = 'Profile';
	var $table = 'profiles';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet'
	));
}
?>