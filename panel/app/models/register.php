<?php
class Register extends AppModel {
	var $name = 'Register';
	
	var $hasMany = array(
		'Offer' => array(
			'className' => 'Offer',
			'foreignKey' => 'offer_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>