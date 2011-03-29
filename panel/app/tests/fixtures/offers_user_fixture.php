<?php 
/* SVN FILE: $Id$ */
/* OffersUser Fixture generated on: 2009-09-18 11:09:58 : 1253264998*/

class OffersUserFixture extends CakeTestFixture {
	var $name = 'OffersUser';
	var $table = 'offers_users';
	var $fields = array(
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'offer_id' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'indexes' => array()
	);
	var $records = array(array(
		'user_id'  => 1,
		'offer_id'  => 1
	));
}
?>