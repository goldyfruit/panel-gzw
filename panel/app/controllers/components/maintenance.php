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

class MaintenanceComponent extends Object {

	/**
	 * Component Name
	 * @access public
	 * @var string
	 */
	var $name = 'Maintenance';
	
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
	 * Check function look into the "options" table.
	 */
    function check() {

    	/**
    	 * Import a model from a controller.
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init('Option');

		/**
		 * Query to find all panel options.
		 * @var string
		 */
		$queryMaintenance = $instanceModel->find('all');

		/**
		 * Check if $queryMaintenance['0']['Option']['maintenance'] is equal to 0.
		 * If $queryMaintenance['0']['Option']['maintenance'] is equal to 0 an error is display and
		 * the user is redirected to the index action in the controller
		 */
		if ($queryMaintenance['0']['Option']['maintenance'] == 1) {
			$this->redirectSomewhere('/pages/maintenance');
		}

    }

}

?>