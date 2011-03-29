<?php
class Quotasprogress extends AppModel {

	var $name = 'Quotasprogress';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Offer' => array(
			'className' => 'Offer',
			'foreignKey' => 'offer_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
?>