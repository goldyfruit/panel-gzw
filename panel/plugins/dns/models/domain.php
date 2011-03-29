<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2011  GoldZone Web - gaetan.trellu@goldzoneweb.info

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Domain extends AppModel {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Domain';

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Alias' => array(
			'className' => 'Alias',
			'foreignKey' => 'domain_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Mailbox' => array(
			'className' => 'Mailbox',
			'foreignKey' => 'domain_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Subdomain' => array(
			'className' => 'Subdomain',
			'foreignKey' => 'domain_id',
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

	/*************************************************************************
	 * 								VALIDATE
	 *************************************************************************/

	var $validate = array(
	
		'name' => array(
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Nom de domaine déjà existant.'
			),
			'regex' => array(
				'rule' => '/^[a-z0-9-]{3,}[.]{1,}[a-z.]{2,}$/i',
				'message' => 'Nom de domaine non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),
			
		'registrar' => array(
        	'regex' => array(
				'rule' => '/^[a-z0-9éèàêëûüäà& -]{3,}$/i',
				'message' => 'Registrar non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),
		'description' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		)
	);

}

?>