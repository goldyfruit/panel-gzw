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

class Sqldata extends AppModel {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Sqldata';

	var $belongsTo = array(
		'Sqluser' => array(
			'className' => 'Sqluser',
			'foreignKey' => 'sqluser_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
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
				'message' => 'Base de données SQL déjà existante.'
			),
			'regex' => array(
				'rule' => '/^[a-z0-9]{3,}$/i',
				'message' => 'Base de données SQL non-valide.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ obligatoire.'
			)
		)
	);

	/*************************************************************************
	 * 								FUNCTIONS
	 *************************************************************************/

	/**
	 * This function check if the database is unique.
	 * @param array $data
	 * @return true or false
	 */
	function checkUnique($data) {

		/**
		 * Contain the sql user name, example : www _ gzw-000001.
		 */
		$sqldataName = $this->data[$this->name]['name'] . '_' . $this->data[$this->name]['gzwId'];
		
		if ($this->find('all', array('conditions' => array($this->name . '.name' => $sqldataName)))) {
				return false;
		}
		return true;

	} 

}

?>