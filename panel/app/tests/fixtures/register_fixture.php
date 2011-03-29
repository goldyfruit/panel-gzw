<?php
/* Register Fixture generated on: 2011-03-24 21:03:54 : 1300997814 */
class RegisterFixture extends CakeTestFixture {
	var $name = 'Register';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'lastname' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'firstname' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'website' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'mail' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'offers' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'phone' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'address' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'zipcode' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'city' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'country' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'registered' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'newsletter' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'idTransaction' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'hipayAccount' => array('type' => 'string', 'null' => false, 'default' => NULL),
		'validated' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => 1,
			'lastname' => 'Lorem ipsum dolor sit amet',
			'firstname' => 'Lorem ipsum dolor sit amet',
			'website' => 'Lorem ipsum dolor sit amet',
			'mail' => 'Lorem ipsum dolor sit amet',
			'offers' => 'Lorem ipsum dolor sit amet',
			'phone' => 'Lorem ipsum dolor sit amet',
			'address' => 'Lorem ipsum dolor sit amet',
			'zipcode' => 'Lorem ipsum dolor sit amet',
			'city' => 'Lorem ipsum dolor sit amet',
			'country' => 'Lorem ipsum dolor sit amet',
			'registered' => '1300997814',
			'newsletter' => 1,
			'idTransaction' => 'Lorem ipsum dolor sit amet',
			'hipayAccount' => 'Lorem ipsum dolor sit amet',
			'validated' => 1
		),
	);
}
?>