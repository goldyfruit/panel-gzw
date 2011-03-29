<?php 
/* SVN FILE: $Id$ */
/* Quotasprogress Fixture generated on: 2010-03-29 18:49:38 : 1269881378*/

class QuotasprogressFixture extends CakeTestFixture {
	var $name = 'Quotasprogress';
	var $table = 'quotasprogresses';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'int' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'offer_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'bandwidth' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'diskspace' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $records = array(array(
		'id' => 1,
		'int' => 1,
		'user_id' => 1,
		'offer_id' => 1,
		'bandwidth' => 1,
		'diskspace' => 1
	));
}
?>