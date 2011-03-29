<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2009-05-12 21:05:50 : 1242156170*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'profile_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'lastname' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'firstname' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'email' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'password' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'integer', 'null' => true, 'default' => NULL, 'length' => 1),
		'registered' => array('type'=>'datetime', 'null' => false, 'default' => NULL),
		'offer_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'address' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'zipcode' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'city' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'country' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'telephone' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'language' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 20),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'profile_id'  => 1,
		'lastname'  => 'Lorem ipsum dolor sit amet',
		'firstname'  => 'Lorem ipsum dolor sit amet',
		'email'  => 'Lorem ipsum dolor sit amet',
		'name'  => 'Lorem ipsum dolor sit amet',
		'password'  => 'Lorem ipsum dolor sit amet',
		'status'  => 1,
		'registered'  => '2009-05-12 21:22:50',
		'offer_id'  => 1,
		'address'  => 'Lorem ipsum dolor sit amet',
		'zipcode'  => 'Lorem ipsum dolor sit amet',
		'city'  => 'Lorem ipsum dolor sit amet',
		'country'  => 'Lorem ipsum dolor sit amet',
		'telephone'  => 'Lorem ipsum dolor sit amet',
		'language'  => 'Lorem ipsum dolor '
	));
}
?>