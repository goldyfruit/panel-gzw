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

class Sqluser extends AppModel {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Sqluser';

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
		'Sqldata' => array(
			'className' => 'Sqldata',
			'foreignKey' => 'sqluser_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/*************************************************************************
	 * 								VALIDATE
	 *************************************************************************/

	var $validate = array(

		'name' => array(
			'unique' => array(
				'rule' => 'checkUnique',
				'message' => 'Utilisateur SQL déjà existant.'
			),
			'regex' => array(
				'rule' => '/^[a-z0-9]{3,}$/i',
				'message' => 'Utilisateur SQL non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			),
			'length' => array(
				'rule' => array('maxLength', 5),
				'message' => '16 caractères maximum pour le nom du nouvel utilisateur SQL.'
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
	 * This function compare two fields.
	 * @param array $data
	 * @return true or false
	 */
	function checkPasswords($data) {

		if ($this->data[$this->name]['password'] == $this->data[$this->name]['confirmPassword']) {
			return true;
		}
		elseif ($this->data[$this->name]['password'] && !isset($this->data[$this->name]['confirmPassword'])) {
			return true;
		}
		else {
			return false;
		}

	}

	/**
	 * This function check if the user is unique.
	 * @param array $data
	 * @return true or false
	 */
	function checkUnique($data) {

		/**
		 * Contain the sql user name, example : www @ gzw-000001.
		 */
		$sqluserName = $this->data[$this->name]['name'] . '@' . $this->data[$this->name]['gzwId'];
		
		if ($this->find('all', array('conditions' => array($this->name . '.name' => $sqluserName)))) {
				return false;
		}
		return true;

	} 

}

?>