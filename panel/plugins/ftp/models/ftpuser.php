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

class Ftpuser extends AppModel {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Ftpuser';

	var $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
				'message' => 'Utilisateur FTP déjà existant.'
			),
			'regex' => array(
				'rule' => '/^[a-z0-9@-]{3,}$/i',
				'message' => 'Utilisateur FTP non-valide.'
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

		'confirmPassword' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.',
			)
		),

		'homedir' => array(
			'regex' => array(
				'rule' => '/^[a-z0-9\/-]{1,}$/i',
				'message' => 'Répertoire de destination non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
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
	 * This function check if the user is unique.
	 * @param array $data
	 * @return true or false
	 */
	function checkUnique($data) {

		/**
		 * Contain the ftp user name, example : www @ gzw-000001.
		 */
		$ftpuserName = $this->data[$this->name]['name'] . '@' . $this->data[$this->name]['gzwId'];
		
		if ($this->find('all', array('conditions' => array($this->name . '.name' => $ftpuserName)))) {
				return false;
		}
		return true;

	} 

}

?>