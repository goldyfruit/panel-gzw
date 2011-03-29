<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2010  GoldZone Web - gaetan.trellu@goldzoneweb.info 

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

class LogsComponent extends Object {

	/**
	 * Component Name
	 * @access public
	 * @var string
	 */
	var $name = 'Logs';
	
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
	 * This function insert into the "logs" table some actions that the user has execute.
	 * @param $user
	 * @param $action
	 * @param $type
	 * @param $ip
	 */
	function insert($user, $action, $type, $ip) {

		/**
		 * Import a model from a controller
		 * $instanceModel = $this->$model
		 * @var string
		 */
		$instanceModel = ClassRegistry::init('Logs');

		/**
		 * Save action.
		 */
		$instanceModel->create();
		$instanceModel->saveField('user_id', $user);
		$instanceModel->saveField('action', $action);
		$instanceModel->saveField('type', $type);
		$instanceModel->saveField('ip', $ip);

	}
	
	function deleteAllLogs($id = null, $ip) {

		/**
		 * Import a model from a controller
		 * $instanceModel = $this->$model
		 * @var string
		 */
		$instanceModel = ClassRegistry::init('Logs');

		$instanceModel->deleteAll(array('Logs.user_id' => $id));

		$instanceModel->create();
		$instanceModel->saveField('user_id', $id);
		$instanceModel->saveField('action', __d('core', 'Delete all event logs', true));
		$instanceModel->saveField('type', __d('core', 'LOG', true));
		$instanceModel->saveField('ip', $ip);
	}

}

?>