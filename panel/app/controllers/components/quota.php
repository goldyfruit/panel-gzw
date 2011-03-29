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

class QuotaComponent extends Object {

	/**
	 * Component Name
	 * @access public
	 * @var string
	 */
	var $name = 'Quota';

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
	 * Check function look into the "quotas" table.
	 * @param $model
	 * @param $field
	 */
    function check($model, $field) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to find the offer of the connected user
		 * @var array
		 */
		$conditionQuota = array('conditions' => array('Quota.offer_id' => $this->Auth->user('offer_id')));

		/**
		 * Query to find the user offer
		 * @var string
		 */
		$queryQuota = $instanceModel->User->Offer->Quota->find('all', $conditionQuota);

		/**
		 * Condition to count the number of occurences about the user
		 * @var array
		 */
		$conditionCount = array('conditions' => array($model . '.user_id' => $this->Auth->user('id')));

		/**
		 * Query to count the occurences
		 * @var string
		 */
		$queryCount = $instanceModel->find('count', $conditionCount);

		/**
		 * Check if $queryCount is more or equal than $queryQuota
		 * If $queryCount is more or equal an error is display and
		 * the user is redirected to the index action ins the controller
		 */
		if ($queryCount >= $queryQuota['0']['Quota'][$field]) {

			/**
			 * Returns a string with the first character capitalized.
			 * See the ucfirst() function : http://php.net/manual/en/function.ucfirst.php
			 * @var string
			 */
			$model = ucfirst(strtolower($model));

			$this->Session->setFlash(($model . ' ' . __d('core', 'quotas exceeded.', true)), 'default', array('class' => 'error'));
			$this->redirectSomewhere(array('action' => 'index'));

		}

    }

	/**
	 * Display function display the "quotas" to the view.
	 * @param $model
	 * @param $field
	 */
    function display($model, $field) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to find the offer of the connected user
		 * @var array
		 */
		$conditionQuota = array('conditions' => array('Quota.offer_id' => $this->Auth->user('offer_id')));

		/**
		 * Query to find the user offer
		 * @var string
		 */
		$queryQuota = $instanceModel->User->Offer->Quota->find('all', $conditionQuota);

		/**
		 * Condition to count the number of occurences about the user
		 * @var array
		 */
		$conditionCount = array('conditions' => array($model . '.user_id' => $this->Auth->user('id')));

		/**
		 * Query to count the occurences
		 * @var string
		 */
		$queryCount = $instanceModel->find('count', $conditionCount);

		/**
		 * Return the quota
		 */
		return $queryCount . ' / ' . $queryQuota['0']['Quota'][$field];

    }

    /**
	 * DisplayTotal function display the "quotas" to the view.
	 * @param $model
	 */
    function displayTotal($model) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to count the number of occurences about the user
		 * @var array
		 */
		$conditionCount = array('conditions' => array($model . '.user_id' => $this->Auth->user('id')));

		/**
		 * Query to count the occurences
		 * @var string
		 */
		$queryCount = $instanceModel->find('count', $conditionCount);

		return $queryCount;

    }

	/**
	 * DisplayDisk function display the disk space to the view.
	 * @param $model
	 */
    function displayDisk($model) {

    	/**
    	 * Import a model from a controller
    	 * $instanceModel = $this->$model
    	 * @var string
    	 */
    	$instanceModel = ClassRegistry::init($model);

		/**
		 * Condition to find space use by the user
		 * @var array
		 */
		$conditionDisk = array('conditions' => array($model . '.user_id' => $this->Auth->user('id')), 'recursive' => -1);

		/**
		 * Query to find the disk space
		 * @var string
		 */
		$queryDisk = $instanceModel->find('all', $conditionDisk);

		return $queryDisk;

	}

}

?>