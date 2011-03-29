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

class RobotComponent extends Object {

	/**
	 * Component Name
	 * @access public
	 * @var string
	 */
	var $name = 'Robot';
	
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
	 * This function insert into the "robot" table some actions that the robot script must execute.
	 * Used this controllers : Domains, Subdomains, Sqldatas, Sqlusers
	 * @param $data
	 * @param $type
	 * @param $user
	 * @param $email
	 * @param $domain
	 * @param $tmp
	 * @param $status
	 */
	function insert($data, $type, $user, $email = '', $domain = '', $tmp = '', $status) {

		/**
		 * Import a model from a controller
		 * $instanceModel = $this->$model
		 * @var string
		 */
		$instanceModel = ClassRegistry::init('Robot');

		/**
		 * Save action.
		 */
		$instanceModel->create();
		$instanceModel->saveField('data', $data);
		$instanceModel->saveField('type', $type);
		$instanceModel->saveField('user', $user);
		$instanceModel->saveField('email', $email);
		$instanceModel->saveField('domain', $domain);
		$instanceModel->saveField('tmp', $tmp);

		/**
		 * Status codes.
		 */
		switch($status) {

			/**
			 * 1 = Add action
			 */
			case 1:
				$instanceModel->saveField('action', 'ADDED');
			break;
			/**
			 * 2 = Delete action
			 */
			case 2:
				$instanceModel->saveField('action', 'DELETED');
			break;
			/**
			 * 3 = Edit action
			 */
			case 3:
				$instanceModel->saveField('action', 'EDITED');
			break;
			/**
			 * 4 = Disable action
			 */
			case 4:
				$instanceModel->saveField('action', 'DISABLED');
			break;
			/**
			 * 5 = Enable action
			 */
			case 5:
				$instanceModel->saveField('action', 'ENABLED');
			break;
			/**
			 * 6 = Change action
			 */
			case 6:
				$instanceModel->saveField('action', 'CHANGED');
			break;
			/**
			 * If there is no action the status is "ERROR".
			 */
			default:
				$instanceModel->saveField('action', 'ERROR');
			break;
		}

		/**
		 * Save the action status.
		 */
		$instanceModel->saveField('status', $status);

	}

	/**
	 * Find ID of the item that we want delete.
	 * Only used in Domains, Subdomains, Sqlusers, Sqldatas
	 * @param var $id
	 * @param var $model
	 * @return string
	 */
	function search($id, $model) {

		/**
		 * Import a model from a controller
		 * $instanceModel = $this->$model
		 * @var string
		 */
		$instanceModel = ClassRegistry::init($model);
		
		/**
		 * Query to find the ID.
		 * @var string
		 */
		$queryId = $instanceModel->findById($id);

		/**
		 * Return the ID.
		 */
		return $queryId;

	}

}

?>