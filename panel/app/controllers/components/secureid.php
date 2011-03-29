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

class SecureidComponent extends Object {

	/**
	 * Component Name
	 * @access public
	 * @var string
	 */
	var $name = 'Secureid';

	/**
	 * Components that are used in this components
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html');

	/**
	 * Components that are used in this components
	 * @access public
	 * @var array
	 */
	var $components = array('Session', 'Auth');

	/**
	 * This function save the controller reference for later use
	 * @param $controller
	 * @param $settings
	 */
	function initialize(&$controller, $settings = array()) {
		$this->controller =& $controller;
	}

	/**
	 * This function redirect to an action, it's very similar than the original
	 * redirect() function from CakePHP but this function is necessary in a component
	 * See : http://book.cakephp.org/view/65/MVC-Class-Access-Within-Components
	 * @param $value
	 */
	function redirectSomewhere($value) {
		$this->controller->redirect($value);
	}

	/**
	 * This function chck is the item that the user want edit, delete, enable or disable belongs to him.
	 * @param $model
	 * @param $id
	 * @param $user
	 */
	function check($model, $id, $user) {

		/**
		 * Import a model from a controller
		 * $instanceModel = $this->$model
		 * @var string
		 */
		$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to select ID of the item.
		 * @var array
		 */
		$conditionId = array('conditions' => array($model . '.id' => $id, $model . '.user_id' => $user));
    	
		/**
		 * Query to check if the item belongs to the user.
		 * @var string
		 */
		$queryId = $instanceModel->find('first', $conditionId);

		/**
		 * If $queryId is empty an error is display and
		 * the user is redirected to the index action ins the controller
		 */
		if (!$queryId) {
			$this->redirectSomewhere(array('action' => 'index'));
		}

	}

}

?>