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

class UsersController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Users';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Text', 'Status');

	/**
	 * Components that are used in this controller
	 * @access public
	 * @var array
	 */
	var $components = array('Quota', 'Maintenance', 'Check', 'Robot', 'Logs', 'Email');

	/**
	 * The "users" controller use the "user" and "option" models.
	 * @var array
	 */
	var $uses = array('User', 'Option');

	/**
	 * Allow the "lostpassword" action if there is no login.
	 */
	function beforeFilter() {
		$this->Auth->allow('lostPassword');
		parent::beforeFilter();
	}

	/*************************************************************************
	 * 								LOGIN PART
	 *************************************************************************/

	function login() {

		/**
		 * Update and display the date of the last login.
		 */
		if ($this->Auth->user('id')) {
			/**
			 * Pass the $lastLogin to the view.
			 */
			$this->Session->write('lastLogin', $this->User->findById($this->Auth->user('id')));

			/**
			 * Update the date of the last login.
			 */
			$this->User->id = $this->Auth->user('id');
			$this->User->saveField('last_time', date('Y-m-d H:i:s'));
		}

		/**
		 * Check if the user is already connected, if yes he is redirect to the main page.
		 */
		if ($this->Auth->user('id') && $this->Auth->user('status') == 0) {
			$this->redirect('/');
		}

		/**
		 * Template used by the login() method.
		 */
		$this->layout = 'login';

    }
	
    function logout() {
    	
    	/**
    	 * Logout the user and redirect to login page.
    	 */
		$this->redirect($this->Auth->logout());

    }

	/*************************************************************************
	 * 								LOST PASSWORD
	 *************************************************************************/
	
	function lostPassword() {

		/**
		 * Use a special layout for the lost password form.
		 **/
		$this->layout = 'lostpassword';

		/**
		 * Prepare the random generation password.
		 * 
		 * $lengthPassword = Size of the password
		 * $newPassword = New declaration, to avoid PHP error
		 * $possibleChar = Characters use in the random generation 
		 *
		 **/
		$lengthPassword = "10";
		$newPassword = "";
		$i = 0;
		$possibleChar = "0123456789bcdfghjkmnpqrstvwxyz"; 

        /**
         * Add random characters to $password until $lengthPassword is reached.
         */
		while ($i < $lengthPassword) {

            /**
             * Pick a random character from the possible ones.
             */
            $char = substr($possibleChar, mt_rand(0, strlen($possibleChar)-1), 1);

            /**
             * We don't want this character if it's already in the password.
             */
            if (!strstr($newPassword, $char)) { 
                $newPassword .= $char;
                $i++;
			}
		}

		/**
		 * Get some options from "Option" model.
		 */
		$optionForPassword = ClassRegistry::init('Option')->index();

		if (!empty($this->data)) {

			/**
			 * Select some informations about the user.
			 */
			$userByName = $this->User->findByName($this->data['User']['name']);

			/**
			 * Save the new user password.
			 */
			if ($this->User->save($this->data)) {
				$this->User->id = $userByName['User']['id'];
				$this->User->saveField('password', $newPassword);

				/**
				 * Support address.
				 */
				$this->Email->to = $userByName['User']['email'];

				/**
				 * ReplyTo address.
				 */
				$this->Email->replyTo = $userByName['User']['email'];

				/**
				 * Email sender.
				 */
				$this->Email->from = $optionForPassword['0']['Option']['mail_robot'] . ' <' . $optionForPassword['0']['Option']['mail_robot'] . '>';

				/**
				 * Email subject.
				 */
				$this->Email->subject = $optionForPassword['0']['Option']['name'] . ' - New password';

				/**
				 * We used the "lostpassword" template.
				 * The templates are in views/layout/email/
				 */
				$this->Email->template = 'lostpassword';

				/**
				 * Choose which templates that it will be used.
				 * 'html' = HTML template
				 * 'text" = TEXT template
				 * 'both' = HTML and TEXT templates
				 */
    			$this->Email->sendAs = 'html';

    			/**
				 * Put the member name in "name".
				 * $name will be available in the email template.
				 */
    			$this->set('name', $userByName['User']['firstname']);
   
    			/**
				 * Put all informations in some variables "message".
				 * variables will be availables in the email template.
				 */
				$this->set('passwordToView', $newPassword);
				$this->set('platformName', $optionForPassword['0']['Option']['name']);
   				$this->set('supportAddress', $optionForPassword['0']['Option']['mail_support']);

				$this->Email->send();

			}
		}
	}

	/*************************************************************************
	 * 								MEMBER PART
	 *************************************************************************/

    /**
	 * This function return the informations about the connected user.
	 * @return array
	 */
	function index() {

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->User->recursive = 0;

		/**
		 * Select all informations about the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('User.id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all informations in "users".
		 * $users will be available in the view.
		 */
		$this->set('users', $this->paginate());

	}

	/**
	 * This function allows a user to edit his profile.
	 * The user is seleted by ID.
	 * @param var $id
	 * @return array
	 */
	function edit($id = null) {

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		/**
		 * Check if the user try to edit an another profile.
		 * If yes, the user is redirect to the index page.
		 */
		elseif ($id != $this->Auth->user('id')) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {

			/**
			 * Save the user after edit.
			 */
			if ($this->User->save($this->data)) {

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ Profile ]</strong> ' . __d('core', 'Informations about you have been edited.', true), 'CORE', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the user is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The user has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the user is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The user has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}

	}

	/**
	 * This function delete a user by ID.
	 * When the user is deleted, all mailboxes, aliases, domains, etc... are deleted too.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The user ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}
		/**
		 * Check if the user try to delete an another user.
		 * If yes, the user is redirect to the index page.
		 */
		elseif ($id != $this->Auth->user('id')) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Delete the user.
		 * Redirect the user to logout page.
		 */
		if ($this->User->del($id)) {
			$this->Session->setFlash(__d('core', 'The user has been deleted.', true));
			$this->redirect(array('action' => 'logout'));
		}

	}

	/**
	 * This function allows the user to edite his password.
	 * @param $id
	 */
	function password($id = null) {

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();		

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid user password.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password', $id));
		}
		/**
		 * Check if the user try to edit an another user password.
		 * If yes, the user is redirect to the index page.
		 */
		elseif ($id != $this->Auth->user('id')) {
			$this->Session->setFlash(__d('core', 'Invalid user password', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the user password after edit.
			 */
			if ($this->User->save($this->data)) {

				/**
				 * Insert the change password action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ Password ]</strong> ' . __d('core', 'Access panel password has been changed.', true), 'CORE', $_SERVER["REMOTE_ADDR"]);
				
				/**
				 * If the user password is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The user password has been changed.', true));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the user password is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The user password has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}

	}

	/**
	 * This function display the user quotas.
	 * @return array
	 */
	function quotas() {

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Display SQL databases quota.
		 * Call the "Quota" component to check.
		 * $quotasSqldata will be available in the view.
		 */
		$this->set('quotasSqldata', $this->Quota->displayTotal('Sqldata'));
		
		/**
		 * Display FTP users quota.
		 * Call the "Quota" component to check.
		 * $quotasFtpuser will be available in the view.
		 */
		$this->set('quotasFtpuser', $this->Quota->displayTotal('Ftpuser'));
		
		/**
		 * Display SQL users quota.
		 * Call the "Quota" component to check.
		 * $quotasSqluser will be available in the view.
		 */
		$this->set('quotasSqluser', $this->Quota->displayTotal('Sqluser'));
		
		/**
		 * Display mailboxes quota.
		 * Call the "Quota" component to check.
		 * $quotasMailbox will be available in the view.
		 */
		$this->set('quotasMailbox', $this->Quota->displayTotal('Mailbox'));
		
		/**
		 * Display aliases quota.
		 * Call the "Quota" component to check.
		 * $quotasAlias will be available in the view.
		 */
		$this->set('quotasAlias', $this->Quota->displayTotal('Alias'));
		
		/**
		 * Display domains quota.
		 * Call the "Quota" component to check.
		 * $quotasDomain will be available in the view.
		 */
		$this->set('quotasDomain', $this->Quota->displayTotal('Domain'));
		
		/**
		 * Display subdomains quota.
		 * Call the "Quota" component to check.
		 * $quotasSubdomain will be available in the view.
		 */
		$this->set('quotasSubdomain', $this->Quota->displayTotal('Subdomain'));
		
		/**
		 * Display cronjobs quota.
		 * Call the "Quota" component to check.
		 * $quotasCron will be available in the view.
		 */
		$this->set('quotasCron', $this->Quota->displayTotal('Cron'));

		/**
		 * Display disk quota.
		 * Call the "Quota" component to check.
		 * $quotasDisk will be available in the view.
		 */
		$this->set('quotasDisk', $this->Quota->displayDisk('Quotasprogress'));

		/**
		 * Select all quotas about the offer who belongs to the user.
		 * @var array
		 */
		$conditionQuota = array('conditions' => array('Quota.offer_id' => $this->Auth->user('offer_id')));

		/**
		 * Display the total of quotas.
		 * Call the "Quota" component to check.
		 * $quotasTotal will be available in the view.
		 */
		$this->set('quotasTotal', $this->User->Offer->Quota->find('all', $conditionQuota));

	}
	
	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all users insert in the table.
	 * @return array
	 */
	function admin_index() {

		$this->User->recursive = 0;

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set('users', $this->paginate());

	}

	/**
	 * This function allows an administrator to create a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			$this->User->create();

			/**
			 * Save new user.
			 */
			if ($this->User->save($this->data)) {

				/**
				 * If the new user is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The user has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the user is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The user has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all profiles (Administrator or Member).
		 * @var array
		 */
		$profiles = $this->User->Profile->find('list');

		/**
		 * Select all offers enabled.
		 * @var array
		 */
		$offers = $this->User->Offer->find('list');

		/**
		 * Put all profiles in "profiles" and offers in "offers".
		 * $profiles and $offers will be available in the view.
		 */
		$this->set(compact('profiles', 'offers'));

	}

	/**
	 * This function allows an administrator to edit a user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the user after edit.
			 */
			if ($this->User->save($this->data)) {

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['User']['name'] . ' ]</strong> ' . __d('core', 'User edited by (' . $this->Auth->user('name') . ').', true) , 'CORE', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new user is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The user has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the user is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The user has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}

		/**
		 * Select all profiles (Administrator or Member).
		 * @var array
		 */
		$profiles = $this->User->Profile->find('list');

		/**
		 * Select all offers enabled.
		 * @var array
		 */
		$offers = $this->User->Offer->find('list');

		/**
		 * Put all profiles in "profiles" and offers in "offers".
		 * $profiles and $offers will be available in the view.
		 */
		$this->set(compact('profiles', 'offers'));

	}

	/**
	 * This function allows an administrator to delete a user by ID.
	 * When the user is deleted, all mailboxes, aliases, domains, etc... are deleted too.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The user ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Delete the user.
		 * Redirect the administrator to index page.
		 */
		if ($this->User->delete($id)) {
			$this->Session->setFlash(__d('core', 'The user has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * This function allows an administrator to edite a user password.
	 * @param $id
	 */
	function admin_password($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the user password after edit.
			 */
			if ($this->User->save($this->data)) {

				/**
				 * Select the subdomain name with the ID.
				 * It's necessary for the insert in the "robot" table.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'User');

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['User']['name']  . ' ]</strong> ' . __d('core', 'User password changed by (' . $this->Auth->user('name') . ').', true) , 'CORE', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new user password is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The user password has been changed.', true));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the user password is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The user password has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}

	}

	/**
	 * This function allows an administrator to disable a user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$user = $this->User->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($user)) {

			$user['User']['status'] = 1;

			/**
			 * Change the user status.
			 * Redirect the administrator to index page.
			 */
			if ($this->User->save($user)) {
				$this->Session->setFlash(__d('core', 'The user has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

	/**
	 * This function allows an administrator to enable a user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$user = $this->User->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($user)) {

			$user['User']['status'] = 0;

			/**
			 * Change the user status.
			 * Redirect the administrator to index page.
			 */
			if ($this->User->save($user)) {
				$this->Session->setFlash(__d('core', 'The user has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

}
?>