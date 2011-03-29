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

class MailboxesController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Mailboxes';

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
	var $components = array('Quota', 'Module', 'Maintenance', 'Secureid', 'Check', 'Robot', 'Logs', 'Email');

	/*************************************************************************
	 * 								MEMBER PART
	 *************************************************************************/

	/**
	 * This function return a mailbox list who belongs to the user.
	 * @return array
	 */
	function index() {

/*
		App::import('Vendor', 'zend_include_path');
		App::import('Vendor', 'Zend_Gdata', true, false, 'Zend/Gdata.php');

		Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
		Zend_Loader::loadClass('Zend_Gdata_Gapps');
		Zend_Loader::loadClass('Zend_Gdata_Query');

		$username = 'user@domain.tld';
		$password = '***';
		$domain = 'domain.tld';
		$type= 'apps';

		$client = Zend_Gdata_ClientLogin::getHttpClient($username, $password, $type);
		$gdata = new Zend_Gdata_Gapps($client, $domain);
		$feed = $gdata->retrieveAllUsers();

		$this->set('feed', $feed);
*/

	
		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Find all domains belongs to the user.
		 * @var array
		 */
		$conditionDomainId = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$queryDomainId = $this->Mailbox->Domain->find('all', $conditionDomainId);

		/**
		 * Select all mailboxes who belongs to the user.
		 * Selected by user_id and domain_id.
		 * @var array
		 */
		@$paginate = array('conditions' => array('Domain.user_id' => $queryDomainId['0']['Domain']['user_id']));
		$this->paginate = $paginate;

		$this->Mailbox->recursive = 0;

		/**
		 * Put all informations in "mailboxes".
		 * $mailboxes will be available in the view.
		 */
		$this->set('mailboxes', $this->paginate());

		/**
		 * Display mailbox quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Mailbox', 'mailbox'));

	}

	/**
	 * This function create the new mailbox.
	 * @return array
	 */
	function add() {

		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if at least one domain is created.
		 * If not the user is redirected with an error message.
		 * Call the "Check" component.
		 */
		$this->Check->domains('Domain');

		/**
		 * Check if mailbox quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Mailbox', 'mailbox');

		if (!empty($this->data)) {

			/**
			 * Crypt password with crypt() function.
			 */
			$passwordField = $this->data['Mailbox']['password'];
			$cryptedPassword = crypt($passwordField);

			/**
			 * Find domain name by the ID.
			 * @var array
			 */
			$conditionDomainId = array('conditions' => array('Domain.id' => $this->data['Mailbox']['domain_id']));
			$queryDomainId = $this->Mailbox->Domain->find('first', $conditionDomainId);

			/**
			 * Split the email address string in an array. 
			 * @var array
			 */
			$analyze = explode('@', $this->data['Mailbox']['name']);

			/**
			 * Check if the domain name in the email address is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && $analyze['1'] != $queryDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('mail', 'The mailbox domain is wrong.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			$this->Mailbox->create();
			if ($this->Mailbox->save($this->data)) {

				/**
				 * Save user ID.
				 */
				$this->Mailbox->saveField('user_id', $this->Auth->user('id'));

				/**
				 * Save crypted password.
				 */
				$this->Mailbox->saveField('password', $cryptedPassword);
				
				/**
				 * Save mail directory.
				 */
				$this->Mailbox->saveField('maildir', $this->data['Mailbox']['name']. '/');

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'The mailbox has been saved.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * Send an email for the mailbox creation.
				 */
				$this->Email->from = 'robot@goldzoneweb.info';
				$this->Email->to = $this->data['Mailbox']['name'];
				$this->Email->subject = __d('mail', 'Mailbox creation.', true);
				$this->Email->send(__d('mail', 'The new mailbox has been created.
												You can delete this email.',
										true
									)
								);

				/**
				 * If the new mailbox is save, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the mailbox is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select domain(s) belongs to the user.
		 * @var array
		 */
		$conditions = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$domains = $this->Mailbox->Domain->find('list', $conditions);

		/**
		 * Display domains.
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function edit a mailbox.
	 * The cronjob is seleted by ID.
	 * @param var $id
	 * @return array
	 */
	function edit($id = null) {

		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		* Find domain name by the ID.
		* @var array
		*/
		$conditionDomainId = array('conditions' => array('Domain.id' => $this->data['Mailbox']['domain_id']));
		$queryDomainId = $this->Mailbox->Domain->find('first', $conditionDomainId);

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The mailbox ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('mail', 'Invalid mailbox.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the mailbox belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Mailbox', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Split the email address string in an array. 
			 * @var array
			 */
			$analyze = explode('@', $this->data['Mailbox']['name']);

			/**
			 * Check if the domain name in the email address is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && $analyze['1'] != $queryDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('mail', 'The mailbox domain is wrong.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'edit', $id));
			}

			if ($this->Mailbox->save($this->data)) {

				/**
				 * Save user ID.
				 */
				$this->Mailbox->saveField('Mailbox.user_id', $this->Auth->user('id'));

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'The mailbox has been edited.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * Display a success message.
				 * Redirect the user to index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the mailbox is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has not been edit.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {

			$this->data = $this->Mailbox->read(null, $id);

			/**
			 * Select the domain name of the email address.
			 * @var array
			 */
			$conditionDomainId = array('conditions' => array('Domain.id' => $this->data['Mailbox']['domain_id']));
			$queryDomainId = $this->Mailbox->Domain->find('list', $conditionDomainId);

			/**
			 * Put the domain in "domain".
			 * $domain will be available in the view.
			 */
			$this->set('domain',$queryDomainId);

		}

	}

	/**
	 * This delete a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {
		
		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The mailbox ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('mail', 'Invalid mailbox.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the mailbox belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Mailbox', $id, $this->Auth->user('id'));

		/**
		 * Select the mailbox name with the ID.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Mailbox');

		/**
		 * Delete the mailbox.
		 * Redirect the user to index page.
		 */
		if ($this->Mailbox->delete($id)) {

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'The mailbox has been deleted.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('mail', 'The mailbox has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function disable a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function disable($id = null) {

		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if the mailbox belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Mailbox', $id, $this->Auth->user('id'));

		$mailbox = $this->Mailbox->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($mailbox)) {

			$mailbox['Mailbox']['status'] = 1;

			/**
			 * Change the mailbox status.
			 * Redirect the user to index page.
			 */
			if ($this->Mailbox->save($mailbox)) {
			
				/**
				 * Select the mailbox name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Mailbox');
			
				/**
				 * Insert the disable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'The mailbox has been disabled.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('mail', 'The mailbox has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

	/**
	 * This function enable a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function enable($id = null) {

		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$mailbox = $this->Mailbox->read(null, $id);

		/**
		 * Check if the mailbox belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Mailbox', $id, $this->Auth->user('id'));

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($mailbox)) {
			
			$mailbox['Mailbox']['status'] = 0;
			
			/**
			 * Change the mailbox status.
			 * Redirect the user to index page.
			 */
			if ($this->Mailbox->save($mailbox)) {
			
				/**
				 * Select the mailbox name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Mailbox');

				/**
				 * Insert the enable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'The mailbox has been enabled.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);
			
				$this->Session->setFlash(__d('mail', 'The mailbox has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

	/**
	 * This function change the mailbox password by ID.
	 * @param var $id
	 * @return array
	 */
	function password($id = null) {

		/**
		 * Check if EMAIL module is enabled.
		 * Call "Module" component to check.
		 * 'EMAIL' is the module name (check in database).
		 */
		$this->Module->check('EMAIL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The mailbox ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('mail', 'Invalid mailbox.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password'));
		}

		/**
		 * Check if the mailbox belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Mailbox', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Crypt password with crypt() function.
			 */
			$passwordField = $this->data['Mailbox']['password'];
			$cryptedPassword = crypt($passwordField);

			/**
			 * Save the mailbox password.
			 */
			if ($this->Mailbox->save($this->data)) {

				/**
				 * Save crypted password.
				 */
				$this->Mailbox->saveField('password', $cryptedPassword);

				/**
				 * Select the mailbox name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Mailbox');

				/**
				 * Insert the change action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'The mailbox password has been changed.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new mailbox is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox password has been changed.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the mailbox is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox password has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Mailbox->read(null, $id);
		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all mailbox inserts in the table.
	 * @return array
	 */
	function admin_index() {
		
		$this->Mailbox->recursive = 0;
		
		/**
		 * Put all informations in "mailboxes".
		 * $mailboxes will be available in the view.
		 */
		$this->set('mailboxes', $this->paginate());
	}

	/**
	 * This function allows an administrator to create a mailbox for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			/**
			 * Crypt the mailbox password with the PHP crypt() function.
			 * @var array
			 */
			$passwordField = $this->data['Mailbox']['password'];
			$cryptedPassword = crypt($passwordField);

			/**
			 * Select domain ID.
			 * @var array
			 */
			$conditionDomainId = array('conditions' => array('id' => $this->data['Mailbox']['domain_id']));
			$domainId = $this->Mailbox->Domain->find('all', $conditionDomainId);
			$userId = $domainId['0']['Domain']['user_id'];

			/**
			 * Save the new mailbox.
			 */
			$this->Mailbox->create();
			if ($this->Mailbox->save($this->data)) {

				/**
				 * Save the password.
				 */
				$this->Mailbox->saveField('password', $cryptedPassword);

				/**
				 * Save the user ID.
				 */
				$this->Mailbox->saveField('user_id', $userId);

				/**
				 * Save mail directory.
				 */
				$this->Mailbox->saveField('maildir', $this->data['Mailbox']['name']. '/');

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'Mailbox added by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new mailbox is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the mailbox is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all domains.
		 * @var array
		 */
		$domains = $this->Mailbox->Domain->find('list');

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function allows an administrator to edit a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The mailbox ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('mail', 'Invalid mailbox.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the mailbox after edit.
			 */
			if ($this->Mailbox->save($this->data)) {

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'Mailbox edited by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new mailbox is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the mailbox is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Mailbox->read(null, $id);
		}

		/**
		 * Select all domains.
		 * @var array
		 */
		$domains = $this->Mailbox->Domain->find('list');

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function allows an administrator to delete a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The mailbox ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('mail', 'Invalid mailbox.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the mailbox name with the ID.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Mailbox');

		/**
		 * Delete the mailbox.
		 * Redirect the administrator to index page.
		 */
		if ($this->Mailbox->delete($id)) {

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'Mailbox deleted by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('mail', 'The mailbox has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function allows an administrator to change the mailbox password by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_password($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The mailbox ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('mail', 'Invalid mailbox.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password'));
		}

		if (!empty($this->data)) {;

			/**
			 * Crypt password with crypt() function.
			 */
			$passwordField = $this->data['Mailbox']['password'];
			$cryptedPassword = crypt($passwordField);

			/**
			 * Save the mailbox password.
			 */
			if ($this->Mailbox->save($this->data)) {

				/**
				 * Save crypted password.
				 */
				$this->Mailbox->saveField('password', $cryptedPassword);

				/**
				 * Select the mailbox name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Mailbox');

				/**
				 * Insert the change action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'Mailbox password changed by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the mailbox password is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox password has been changed.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the mailbox password is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mailbox password has not been changed.', true), 'default', array('class' => 'error'));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Mailbox->read(null, $id);
		}
	}

	/**
	 * This function allows an administrator to disable a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$mailbox = $this->Mailbox->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($mailbox)) {

			$mailbox['Mailbox']['status'] = 1;

			/**
			 * Change the mailbox status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Mailbox->save($mailbox)) {

				/**
				 * Select the mailbox name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Mailbox');

				/**
				 * Insert the disable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'Mailbox disabled by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('mail', 'The mailbox has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

	/**
	 * This function allows an administrator to enable a mailbox by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$mailbox = $this->Mailbox->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($mailbox)) {

			$mailbox['Mailbox']['status'] = 0;

			/**
			 * Change the mailbox status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Mailbox->save($mailbox)) {

				/**
				 * Select the mailbox name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Mailbox');

				/**
				 * Insert the enable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Mailbox']['name'] . ' ]</strong> ' . __d('mail', 'Mailbox enabled by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('mail', 'The mailbox has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

}

?>