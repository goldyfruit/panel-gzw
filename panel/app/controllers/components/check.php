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

class CheckComponent extends Object {

	/**
	 * Component Name
	 * @access public
	 * @var string
	 */
	var $name = 'Check';

	/**
	 * Components that are used in this components
	 * @access public
	 * @var array
	 */
	var $components = array('Session', 'Auth');

	/**
	 * This function save the controller reference for later use.
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
	 * "domains" function look into the "domains" table to count
	 * the domains who belongs to user.
	 * @param $model
	 */
    function domains($model) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to find all domains.
		 * @var array
		 */
		$conditionsCount = array('conditions' => array($model . '.user_id' => $this->Auth->user('id')));

		/**
		 * Query to count the domains who belongs to the user.
		 * @var string
		 */
		$queryCount = $instanceModel->find('count', $conditionsCount);

		/**
		 * Check if $queryCount is equal to 0.
		 * If $queryCount is equal to 0 an error is display and
		 * the user is redirected to the index action in the controller
		 */
    	if ($queryCount == "0") {
			$this->Session->setFlash(__d('core', 'The domain can\'t be create.', true), 'default', array('class' => 'error'));
			$this->redirectSomewhere(array('action' => 'index'));
		}

    }

	/**
	 * "sqlusers" function look into the "sqlusers" table to count
	 * the sql users who belongs to user.
	 * @param $model
	 */
    function sqlusers($model) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to find all sql users.
		 * @var array
		 */
		$conditionsCount = array('conditions' => array($model . '.user_id' => $this->Auth->user('id')));

		/**
		 * Query to count the sql users who belongs to the user.
		 * @var string
		 */
		$queryCount = $instanceModel->find('count', $conditionsCount);

		/**
		 * Check if $queryCount is equal to 0.
		 * If $queryCount is equal to 0 an error is display and
		 * the user is redirected to the index action in the controller
		 */
    	if ($queryCount == "0") {
			$this->Session->setFlash(__d('core', 'You need to create a SQL user.', true), 'default', array('class' => 'error'));
			$this->redirectSomewhere(array('action' => 'index'));
		}

    }
    
    /**
	 * "offers" function look into the "offers" table to get
	 * the offer name.
	 * @param $model
	 * @param $id
	 */
    function offers($model, $id) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to find the offer.
		 * @var array
		 */
		$conditionsName = array('conditions' => array($model . '.id' => $id), 'recursive' => -1);

		/**
		 * Query to get the offer name.
		 * @var string
		 */
		$queryName = $instanceModel->find('first', $conditionsName);

		/**
		 * Check if $queryName is equal to "free".
		 * If $queryName is equal to "free" an error is display and
		 * the user is redirected to the index action in the controller
		 */
    	if ($queryName['Offer']['name'] == "free") {
			$this->Session->setFlash(__d('core', 'You can\'t do this with this offer.', true), 'default', array('class' => 'error'));
			$this->redirectSomewhere(array('action' => 'index'));
		}

    }

}

?>
