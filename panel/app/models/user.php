<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2009  Gaëtan Trellu - goldyfruit@free.fr

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

class User extends AppModel {

	/**
	 * Model Name
	 * @access public
	 * @var string
	 */
	var $name = 'User';

	var $belongsTo = array(
		'Profile' => array(
			'className' => 'Profile',
			'foreignKey' => 'profile_id',
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

	var $hasMany = array(
		'Domain' => array(
			'className' => 'Domain',
			'foreignKey' => 'user_id',
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
		'Ftpuser' => array(
			'className' => 'Ftpuser',
			'foreignKey' => 'user_id',
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
		'Cron' => array(
			'className' => 'Cron',
			'foreignKey' => 'user_id',
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
		'Bill' => array(
			'className' => 'Bill',
			'foreignKey' => 'user_id',
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
		'lastname' => array(
			'regex' => array(
				'rule' => '/^[a-z0-9éèàêëûüäà -]{3,}$/i',
				'message' => 'Nom de famille non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'firstname' => array(
			'regex' => array(
				'rule' => '/^[a-z0-9éèàêëûüäà -]{3,}$/i',
				'message' => 'Prénom non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'email' => array(
        	'regex' => array(
        		'rule' => 'email',
				'message' => 'Adresse email non-valide.',
			),
			'check' => array(
				'rule' => 'checkUniqueEmail',
				'message' => 'Adresse email déjà existante.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'address' => array(
			'regex' => array(
				'rule' => '/^[a-z0-9éèàêëûüäà -,]{3,}$/i',
				'message' => 'Adresse postale non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'zipcode' => array(
			'regex' => array(
				'rule' => '/^[a-z0-9 -]{3,}$/i',
				'message' => 'Code postal non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'city' => array(
			'regex' => array(
				'rule' => '/^[a-z -]{3,}$/i',
				'message' => 'Ville non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'country' => array(
			'regex' => array(
				'rule' => '/^[a-z -]{3,}$/i',
				'message' => 'Pays non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'language' => array(
			'regex' => array(
				'rule' => '/^[a-z ]{2,}$/i',
				'message' => 'Langue non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'telephone' => array(
			'regex' => array(
				'rule' => '/^[0-9 +]{3,}$/i',
				'message' => 'Numéro de téléphone non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
		),

		'password' => array(
			'lenght' => array(
				'rule' => array('minLength', 8),
				'message' => 'Le mot de passe est trop court.',
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.',
			),
            'check' => array(
                'rule' => 'checkPasswords',
                'message' => 'Les mots de passe ne sont pas identiques.'
            )
		),

		'oldPassword' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.',
			)
		),

		'confirmPassword' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.',
			)
		)
	);

	/*************************************************************************
	 * 								FUNCTIONS
	 *************************************************************************/

	/**
	 * This function crypt the user password with the CakePHP salt before insert.
	 * @see cake/libs/model/Model#beforeSave($options)
	 */
	function beforeSave() {

		/**
		 * Check if "password" field is set.
		 */
		if(isset($this->data[$this->name]['password'])) {

			/**
			 * Crypt the password with Security::hash() function.
			 * This function is available if the Auth component is called.
			 */
			$this->data[$this->name]['password'] = Security::hash($this->data[$this->name]['password'], null, true);
			return true;

		} else {
			return true;
		}

	}

	/**
	 * This function compare two fields.
	 * @param array $data
	 * @return true or false
	 */
	function checkPasswords($data) {
		if ($this->data[$this->name]['password'] && !isset($this->data[$this->name]['confirmPassword'])) {
			return true;
		}
		elseif ($this->data[$this->name]['password'] == $this->data[$this->name]['confirmPassword']) {
			return true;
		}
		else {
			return false;
		}
	}

	/**
	 * This function check if two email address can be duplicate.
	 * @param array $data
	 * @return true or false
	 */
	function checkUniqueEmail() {
		$uniqueStatus = ClassRegistry::init('Option')->index();
		
		if ($uniqueStatus['0']['Option']['duplicate_email'] != 0) {
			return false;
		} else {
			return true;
		}
	}

}

?>