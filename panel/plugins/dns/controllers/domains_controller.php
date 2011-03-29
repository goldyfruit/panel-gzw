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

class DomainsController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Domains';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Ajax', 'Text', 'Status');

	/**
	 * Components that are used in this controller
	 * @access public
	 * @var array
	 */
	var $components = array('Quota', 'Module', 'Maintenance', 'Secureid', 'Robot', 'Check', 'Logs');

	/*************************************************************************
	 * 								MEMBER PART
	 *************************************************************************/

	/**
	 * This function return a domains list who belongs to the user.
	 * @return array
	 */
	function index() {

		/**
		 * Check if DNS module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('DNS');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->Domain->recursive = 0;

		/**
		 * Select all domains who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set('domains', $this->paginate());

		/**
		 * Display domains quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Domain', 'domain'));

	}

	/**
	 * This function create the new domain.
	 * @return array
	 */
	function add() {

		/**
		 * Check if DNS module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('DNS');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if domain quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Domain', 'domain');

		/**
		 * Initialization of "Virtualdomain" model.
		 * This one is necessary for the virtuals mailboxes. 
		 * @var string
		 */
		$virtualdomain = ClassRegistry::init('Virtualdomain');

		if (!empty($this->data)) {

			$this->Domain->create();

			/**
			 * Save new domain.
			 */
			if ($this->Domain->save($this->data)) {

				/**
				 * Save new domain in "virtualdomains" table.
				 * Here the domain name is insert in the table.
				 */
				$virtualdomain->saveField('domain', $this->data['Domain']['name']);

				/**
				 * Save new domain in "virtualdomains" table.
				 * Here the user name is insert in the table.
				 */
				$virtualdomain->saveField('description', $this->Auth->user('name'));

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Domain']['name'], 'DOMAIN', $this->Auth->user('name'), $this->Auth->user('email'), NULL, NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'The domain has been saved.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new domain is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the domain is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

	}

	/**
	 * This function edit a domain.
	 * The domain is seleted by ID.
	 * @param var $id
	 * @return array
	 */
	function edit($id = null) {
		
		/**
		 * Check if DNS module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('DNS');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if the offer allow to execute this action.
		 */
		$this->Check->offers('Offer', $this->Auth->user('offer_id'));

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The domain ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('domain', 'Invalid domain.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the domain belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Domain', $id, $this->Auth->user('id'));

		/**
		 * Select the domain name.
		 */
		$oldDomainNameCondition = array('conditions' => array('Domain.id' => $id), 'recursive' => -1);

		/**
		 * Put the domain name  in "old".
		 * $old will be available in the view.
		 */
		$this->set('old', $this->Domain->find('first', $oldDomainNameCondition));

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set('domains', $this->paginate());
		
		if (!empty($this->data)) {

			/**
			 * Save the domain after edit.
			 */
			if ($this->Domain->save($this->data)) {

				/**
				 * Insert the edit action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Domain']['name'], 'DOMAIN', $this->Auth->user('name'), NULL, NULL, $this->data['Domain']['oldDomain'], 3);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'The domain has been edited.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);
				
				
				/**
				 * If the domain is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the domain is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Domain->read(null, $id);
		}

	}

	/**
	 * This function delete a domain by ID.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {

		/**
		 * Check if DNS module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('DNS');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if the offer allow to execute this action.
		 */
		$this->Check->offers('Offer', $this->Auth->user('offer_id'));

		/**
		 * Initialization of "Virtualdomain" model.
		 * @var string
		 */
		$virtualdomain = ClassRegistry::init('Virtualdomain');

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The domain ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('domain', 'Invalid domain ID.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the domain name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Domain');

		/**
		 * Check if the domain belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Domain', $id, $this->Auth->user('id'));
	
		/**
		 * Delete the domain.
		 * Redirect the user to index page.
		 */
		if ($this->Domain->delete($id)) {

			/**
			 * Delete the domain present in the "virtualdomains" table.
			 */
			$virtualdomain->deleteAll(array('domain' => $data['Domain']['name']));

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Domain']['name'], 'DOMAIN', $this->Auth->user('name'), NULL, NULL, NULL, 2);

			/**
			 * Insert the create action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'The domain has been deleted.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);
			
			$this->Session->setFlash(__d('domain', 'The domain has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all domains inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Domain->recursive = 0;

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set('domains', $this->paginate());

	}

	/**
	 * This function allows an administrator to create a domain for a user.
	 * @return array
	 */
	function admin_add() {

		/**
		 * Initialization of "Virtualdomain" model.
		 * This one is necessary for the virtuals mailboxes. 
		 * @var string
		 */
		$virtualdomain = ClassRegistry::init('Virtualdomain');
		
		if (!empty($this->data)) {

			/**
			 * Select the user name of the domain owner.
			 * @var array
			 */
			$conditionUser = array('conditions' => array('User.id' => $this->params['data']['Domain']['user_id']));
			$queryUser =  $this->Domain->User->find('first', $conditionUser);
			
			/**
			 * Save the new domain.
			 */
			$this->Domain->create();
			if ($this->Domain->save($this->data)) {

				/**
				 * Save new domain in "virtualdomains" table.
				 * Here the domain name is insert in the table.
				 */
				$virtualdomain->saveField('domain', $this->data['Domain']['name']);

				/**
				 * Save new domain in "virtualdomains" table.
				 * Here the user name is insert in the table.
				 */
				$virtualdomain->saveField('description', $queryUser['User']['name']);

				/**
				 * Insert the create action in the "robot" table.
				 */
				$this->Robot->insert($this->data['Domain']['name'], 'DOMAIN', $queryUser['User']['name'], $queryUser['User']['email'], NULL, NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'Domain added by (' . $this->Auth->user('name') . ') for (' . $queryUser['User']['name'] . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new domain is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the domain is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Domain->User->find('list');

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allows an administrator to edit a domain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The domain ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('domain', 'Invalid domain.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Select the user name of the domain owner.
			 * @var array
			 */
			$conditionUser = array('conditions' => array('User.id' => $this->params['data']['Domain']['user_id']));
			$queryUser =  $this->Domain->User->find('first', $conditionUser);
			
			/**
			 * Save the domain after edit.
			 */
			if ($this->Domain->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Domain']['name'], 'DOMAIN', $queryUser['User']['name'], $queryUser['User']['email'], NULL, NULL, NULL, 3);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'Domain edited by (' . $this->Auth->user('name') . ') for (' . $queryUser['User']['name'] . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the domain is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the domain is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The domain has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Domain->read(null, $id);
		}

		/**
		 * Select all users
		 * @var array
		 */
		$users = $this->Domain->User->find('list');

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set(compact('users'));
	}

	/**
	 * This function allows an administrator to delete a domain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The domain ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('domain', 'Invalid domain.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the domain name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Domain');

		/**
		 * Initialization of "Virtualdomain" model.
		 * This one is necessary for the virtuals mailboxes. 
		 * @var string
		 */
		$virtualdomain = ClassRegistry::init('Virtualdomain');

		/**
		 * Delete the domain.
		 * Redirect the administrator to index page.
		 */
		if ($this->Domain->delete($id)) {

			/**
			 * Delete the domain present in the "virtualdomains" table.
			 */
			$virtualdomain->deleteAll(array('Virtualdomain.domain' => $data['Domain']['name']));

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Domain']['name'], 'DOMAIN', $data['User']['name'], NULL, NULL, NULL, 2);

			/**
			 * Insert the create action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'Domain deleted by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('domain', 'The domain has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}
	}

	/**
	 * This function allows an administrator to disable a domain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$domain = $this->Domain->read(null, $id);

		/**
		 * Select the domain name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Domain');
		
		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($domain)) {

			$domain['Domain']['status'] = 1;

			/**
			 * Change the domain status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Domain->save($domain)) {

				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Domain']['name'], 'DOMAIN', $data['User']['name'], NULL, NULL, NULL, 4);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'Domain disabled by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('domain', 'The domain has been disabled.', true));
				$this->redirect(array('action' => 'index'));

			}
		}

	}

	/**
	 * This function allows an administrator to enable a domain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$domain = $this->Domain->read(null, $id);

		/**
		 * Select the domain name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Domain');
		
		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($domain)) {

			$domain['Domain']['status'] = 0;

			/**
			 * Change the domain status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Domain->save($domain)) {

				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Domain']['name'], 'DOMAIN', $data['User']['name'], NULL, NULL, NULL, 5);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Domain']['name'] . ' ]</strong> ' . __d('domain', 'Domain enabled by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('domain', 'The domain has been enabled.', true));
				$this->redirect(array('action' => 'index'));

			}
		}

	}

}

?>