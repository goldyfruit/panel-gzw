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

class AppController extends Controller {

	/**
	 * Components that are used in this components
	 * @access public
	 * @var array
	 */
	var $components = array('Auth', 'Session', 'Cookie');

	function beforeFilter() {

		/**
		 * Check if the "Auth" component is loaded.
		 * If yes we check everyhing about the login.
		 */
    	if(isset($this->Auth)) {
  
    		/**
    		 * Name of the model that will be use for "Auth".
    		 */
			$this->Auth->userModel = 'User';
			
			/**
			 * Name of the fields "username" and "password" used by "Auth" component.
			 */
			$this->Auth->fields = array('username' => 'name', 'password' => 'password');

			/**
			 * Check if the user is disabled.
			 */
			$this->Auth->userScope = array('User.status' => 0);
			
			/**
			 * Display the login page if the user is not logged.
			 */
			$this->Auth->loginAction = '/users/login';

			/**
			 * Display the login page after disconnect. 
			 */
			$this->Auth->logoutRedirect = '/';
			
			/**
			 * Redirect the user after authentification.
			 */
			$this->Auth->autoRedirect = true;
			
			/**
			 * Check if there are some actions in the controller.
			 * The actions are stored in the "isAuthorized" methode.
			 */
			$this->Auth->authorize = 'controller';

		}

		/**
		 * Check if a member try to go in the admin section.
		 */
		if (isset($this->params['prefix']) && $this->params['prefix'] == 'admin' && $this->Auth->user('profile_id') == 2) {
			$this->redirect('/users/index');
		}

		$this->_setLanguage();

	}
 
	/**
	 * Return "true" if the authentification successfuly.
	 * @see cake/libs/controller/Controller#isAuthorized()
	 */
	function isAuthorized() {
			return true;
	}

	function _setLanguage() {
	
		$this->loadModel('User');
		$userLang = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->user('id')), 'recursive' => 0));
	
		if ($this->Cookie->read('lang') && !$this->Session->check('Config.language')) {
 	   		$this->Session->write('Config.language', $this->Cookie->read('lang'));
		}
		else if (isset($userLang['User']['language']) && ($userLang['User']['language'] !=  $this->Session->read('Config.language'))) {
			$this->Session->write('Config.language',$userLang['User']['language']);
			$this->Cookie->write('lang', $userLang['User']['language'], false, '20 days');
		}
	}
	
}
?>
