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

class SubdomainsController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Subdomains';

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
	var $components = array('Quota', 'Module', 'Maintenance', 'Secureid', 'Robot', 'Logs');

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

		/**
		 * Select all domains who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$domainId = $this->Subdomain->Domain->find('all', array('conditions' => array('Domain.user_id' => $this->Auth->user('id'))));

		/**
		 * Select all subdomains who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Subdomain.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		$this->Subdomain->recursive = 0;

		/**
		 * Put all subdomains in "subdomains".
		 * $subdomains will be available in the view.
		 */
		$this->set('subdomains', $this->paginate());

		/**
		 * Display subdomains quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Subdomain', 'subdomain'));
	}

	/**
	 * This function create the new subdomain.
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
		 * Check if subdomain quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Subdomain', 'subdomain');

		if (!empty($this->data)) {

			/**
			 * Select the user ID of the domain owner.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('Domain.id' => $this->params['data']['Subdomain']['domain_id']));
			$queryUserDomainId =  $this->Subdomain->Domain->find('first', $conditionUserId);
			
			/**
			 * Split the subdomain string in an array. 
			 * @var array
			 */
			$analyze = explode('.', $this->data['Subdomain']['name']);

			/**
			 * Check if the domain name in the subdomain is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && isset($analyze['2']) && $analyze['1'] . '.' . $analyze['2'] != $queryUserDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('domain', 'Wrong domain name used in the subdomain name string.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			$this->Subdomain->create();

			/**
			 * Save new subdomain.
			 */
			if ($this->Subdomain->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Subdomain']['name'], 'SUBDOMAIN', $this->Auth->user('name'), $this->Auth->user('email'), $this->data['Subdomain']['domain_id'], NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'The subdomain has been saved.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * Save the user ID.
				 */
				$this->Subdomain->saveField('user_id', $this->Auth->user('id'));

				/**
				 * If the new subdomain is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the subdomain is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all domains who belongs to the user.
		 * Select by user ID.
		 * @var array
		 */
		$conditions = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$domains = $this->Subdomain->Domain->find('list', $conditions);

		/**
		 * Put all domains in "$domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function edit a subdomain.
	 * The subdomain is seleted by ID.
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
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The subdomain ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('domain', 'Invalid subdomain ID.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the subdomain belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Subdomain', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Select the user ID of the domain owner.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('Domain.id' => $this->params['data']['Subdomain']['domain_id']));
			$queryUserDomainId =  $this->Subdomain->Domain->find('first', $conditionUserId);
			
			/**
			 * Split the subdomain string in an array. 
			 * @var array
			 */
			$analyze = explode('.', $this->data['Subdomain']['name']);

			/**
			 * Check if the domain name in the subdomain is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && isset($analyze['2']) && $analyze['1'] . '.' . $analyze['2'] != $queryUserDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('domain', 'Wrong domain name used in the subdomain name string.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'edit', $id));
			}
			
			/**
			 * Save the subdomain after edit.
			 */
			if ($this->Subdomain->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Subdomain']['name'], 'SUBDOMAIN', $this->Auth->user('name'), NULL, $this->data['Subdomain']['domain_id'], NULL, 3);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'The subdomain has been edited.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the subdomain is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has been edited.', true), 'default', array('class' => 'success'));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the subdomain is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Subdomain->read(null, $id);
		}

		/**
		 * Select all domains who belongs to the user.
		 * Select by user ID.
		 * @var array
		 */
		$conditions = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$domains = $this->Subdomain->Domain->find('list', $conditions);

		/**
		 * Put all domains in "$domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function delete a subdomain by ID.
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
		 * If $id is not set an error message is displayed.
		 * $id = The subdomain ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('domain', 'Invalid subdomain ID.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the subdomain name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Subdomain');

		/**
		 * Check if the subdomain belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Subdomain', $id, $this->Auth->user('id'));

		/**
		 * Delete the subdomain.
		 * Redirect the user to index page.
		 */
		if ($this->Subdomain->delete($id)) {

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Subdomain']['name'], 'SUBDOMAIN', $this->Auth->user('name'), $this->Auth->user('email'), $data['Subdomain']['domain_id'], NULL, 2);

			/**
			 * Insert the create action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'The subdomain has been deleted.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('domain', 'The subdomain has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}
	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all subdomains inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Subdomain->recursive = 0;

		/**
		 * Put all subdomains in "subdomains".
		 * $subdomains will be available in the view.
		 */
		$this->set('subdomains', $this->paginate());

	}

	/**
	 * This function allows an administrator to create a subdomain for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			/**
			 * Select the user ID of the domain owner.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('Domain.id' => $this->params['data']['Subdomain']['domain_id']));
			$queryUserDomainId =  $this->Subdomain->Domain->find('first', $conditionUserId);

			/**
			 * Select the user name and email of the domain owner.
			 * @var array
			 */
			$conditionUser = array('conditions' => array('User.id' => $queryUserDomainId['Domain']['user_id']));
			$queryUser =  $this->Subdomain->User->find('first', $conditionUser);
			
			/**
			 * Split the subdomain string in an array. 
			 * @var array
			 */
			$analyze = explode('.', $this->data['Subdomain']['name']);

			/**
			 * Check if the domain name in the subdomain is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && isset($analyze['2']) && $analyze['1'] . '.' . $analyze['2'] != $queryUserDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('domain', 'Wrong domain name used in the subdomain name string.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			/**
			 * Save new subdomain.
			 */
			$this->Subdomain->create();
			if ($this->Subdomain->save($this->data)) {

				/**
				 * Save the user ID.
				 */
				$this->Subdomain->saveField('user_id', $queryUserDomainId['Domain']['user_id']);

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Subdomain']['name'], 'SUBDOMAIN', $queryUser['User']['name'], $queryUser['User']['email'], $this->data['Subdomain']['domain_id'], NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'Subdomain added by (' . $this->Auth->user('name') . ') for (' . $queryUser['User']['name'] . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new subdomain is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the subdomain is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all domains.
		 * @var array
		 */
		$domains = $this->Subdomain->Domain->find('list');

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function allows an administrator to edit a subdomain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The subdomain ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('domain', 'Invalid subdomain ID.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Select the user ID of the domain owner.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('Domain.id' => $this->params['data']['Subdomain']['domain_id']));
			$queryDomainId =  $this->Subdomain->Domain->find('first', $conditionUserId);

			/**
			 * Split the subdomain string in an array. 
			 * @var array
			 */
			$analyze = explode('.', $this->data['Subdomain']['name']);

			/**
			 * Check if the domain name in the subdomain is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && isset($analyze['2']) && $analyze['1'] . '.' . $analyze['2'] != $queryDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('domain', 'Wrong domain name used in the subdomain name string.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'edit', $id));
			}

			/**
			 * Save the subdomain after edit.
			 */
			if ($this->Subdomain->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Subdomain']['name'], 'SUBDOMAIN', NULL, NULL, $this->data['Subdomain']['domain_id'], NULL, 3);

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'Subdomain edited by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new subdomain is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the subdomain is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('domain', 'The subdomain has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Subdomain->read(null, $id);
		}

		/**
		 * Select all domains.
		 * @var array
		 */
		$domains = $this->Subdomain->Domain->find('list');

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function allows an administrator to delete a subdomain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The subdomain ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('domain', 'Invalid subdomain ID.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the subdomain name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Subdomain');

		/**
		 * Delete the subdomain.
		 * Redirect the administrator to index page.
		 */
		if ($this->Subdomain->delete($id)) {

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Subdomain']['name'], 'SUBDOMAIN', $data['User']['name'], NULL, $data['Subdomain']['domain_id'], NULL, 2);

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'Subdomain deleted by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('domain', 'The subdomain has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}

	}

	/**
	 * This function allows an administrator to disable a subdomain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$subdomain = $this->Subdomain->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($subdomain)) {

			$subdomain['Subdomain']['status'] = 1;

			/**
			 * Select the subdomain name with the ID.
			 * It's necessary for the insert in the "robot" table.
			 * @var string
			 */
			$data = $this->Robot->search($id, 'Subdomain');

			/**
			 * Change the subdomain status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Subdomain->save($subdomain)) {

				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Subdomain']['name'], 'SUBDOMAIN', $data['User']['name'], NULL, $data['Subdomain']['domain_id'], NULL, 4);

				/**
				 * Insert the disable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'Subdomain disabled by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('domain', 'The subdomain has been disabled.', true));
				$this->redirect(array('action' => 'index'));

			}
		}

	}

	/**
	 * This function allows an administrator to enable a subdomain by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$subdomain = $this->Subdomain->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($subdomain)) {

			$subdomain['Subdomain']['status'] = 0;

			/**
			 * Select the subdomain name with the ID.
			 * It's necessary for the insert in the "robot" table.
			 * @var string
			 */
			$data = $this->Robot->search($id, 'Subdomain');
			
			/**
			 * Change the subdomain status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Subdomain->save($subdomain)) {
				
				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Subdomain']['name'], 'SUBDOMAIN', $data['User']['name'], NULL, $data['Subdomain']['domain_id'], NULL, 5);

				/**
				 * Insert the enable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Subdomain']['name'] . ' ]</strong> ' . __d('domain', 'Subdomain enabled by (' . $this->Auth->user('name') . ').', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);
				
				$this->Session->setFlash(__d('domain', 'The subdomain has been enabled.', true));
				$this->redirect(array('action' => 'index'));

			}
		}

	}

}

?>