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

class Support extends AppModel {

	/**
	 * Model Name
	 * @access public
	 * @var string
	 */
	var $name = 'Support';

	/**
	 * Here we don't need database.
	 * @var string
	 */
	var $useTable = false;

	/*************************************************************************
	 * 								VALIDATE
	 *************************************************************************/
	
	var $validate = array(
	    'name' => array(
	        'rule' => '/.+/',
			'allowEmpty' => false,
	        'required' => true,
	    ),
		'subject' => array(
	        'rule' => array('minLength', 5),
			'message' => 'Le sujet n\'est pas assez long.'
	    ),
		'email' => array(
	        'rule' => 'email',
			'message' => 'Adresse email non valide.'
	    ),
	    'message' => array(
	    	'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Ce champ est obligatoire.'
			)
	    )
	);

	/**
	 * This function generate the form's fields.
	 * @see cake/libs/model/Model#schema($field)
	 * lenght = Max lenght
	 */
	function schema() {

		return array (
			'name' => array('type' => 'string'),
			'email' => array('type' => 'string'),
			'message' => array('type' => 'text', 'length' => 2000),
			'subject' => array('type' => 'string', 'length' => 100),
		);

	}

}

?>