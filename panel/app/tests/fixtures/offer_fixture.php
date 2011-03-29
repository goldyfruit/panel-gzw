<?php 
/* SVN FILE: $Id$ */
/* Offer Fixture generated on: 2009-09-08 11:31:34 : 1252402294*/

class OfferFixture extends CakeTestFixture {
	var $name = 'Offer';
	var $table = 'offers';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type'=>'string', 'null' => false, 'default' => NULL),
		'status' => array('type'=>'boolean', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id'  => 1,
		'name'  => 'Lorem ipsum dolor sit amet',
		'status'  => 1
	));
}
?>