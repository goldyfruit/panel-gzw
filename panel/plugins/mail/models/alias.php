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

class Alias extends AppModel {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Alias';

	var $belongsTo = array(
		'Domain' => array(
			'className' => 'Domain',
			'foreignKey' => 'domain_id',
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
        	'regex' => array(
        		'rule' => 'email',
				'message' => 'Redirection email non-valide.',
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Redirection email déjà existante.'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ obligatoire.'
			)
		),

		'destination' => array(
        	'regex' => array(
        		'rule' => 'email',
				'message' => 'Adresse email de destination non-valide.',
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ obligatoire.'
			),
		)
	);

}

?>