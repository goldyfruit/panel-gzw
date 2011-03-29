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

class AliasesController extends MailAppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Aliases';

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
	var $components = array('Quota', 'Module', 'Maintenance', 'Secureid', 'Check', 'Robot', 'Logs');

	/*************************************************************************
	 * 								MEMBER PART
	 *************************************************************************/

	/**
	 * This function return an aliases list who belongs to the user.
	 * @return array
	 */
	function index() {

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
		$queryDomainId = $this->Alias->Domain->find('all', $conditionDomainId);

		/**
		 * Select all aliases who belongs to the user.
		 * Selected by user_id and domain_id.
		 * @var array
		 */
		@$paginate = array('conditions' => array('Domain.user_id' => $queryDomainId['0']['Domain']['user_id']));
		$this->paginate = $paginate;

		/**
		 * Put all aliases in "aliases".
		 * $aliases will be available in the view.
		 */
		$this->set('aliases', $this->paginate());

		/**
		 * Display alias quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Alias', 'alias'));

	}

	/**
	 * This function create the new alias.
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
		 * Check if maintenant is on.
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
		 * Check if alias quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Alias', 'alias');

		if (!empty($this->data)) {

			/**
			 * Find domain name by ID.
			 * @var array
			 */
			$conditionDomainId = array('conditions' => array('Domain.id' => $this->data['Alias']['domain_id']));
			$queryDomainId = $this->Alias->Domain->find('first', $conditionDomainId);

			/**
			 * Split the email address string in an array. 
			 * @var array
			 */
			$analyze = explode('@', $this->data['Alias']['name']);

			/**
			 * Check if the domain name in the email address is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && $analyze['1'] != $queryDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('mail', 'The mail alias domain is wrong.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			$this->Alias->create();

			/**
			 * Save the new alias.
			 */
			if ($this->Alias->save($this->data)) {

				/**
				 * Save user ID.
				 */
				$this->Alias->saveField('user_id', $this->Auth->user('id'));

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'The mail alias has been saved.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If The mail alias is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If The mail alias is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select domain(s) who belongs to the user.
		 * @var array
		 */
		$conditions = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$domains = $this->Alias->Domain->find('list', $conditions);

		/**
		 * Display domain(s).
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function edit an alias.
	 * The domain is seleted by ID.
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
		$conditionDomainId = array('conditions' => array('Domain.id' => $this->data['Alias']['domain_id']));
		$queryDomainId = $this->Alias->Domain->find('first', $conditionDomainId);

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The mail alias ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('mail', 'Invalid mail alias', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if The mail alias belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Alias', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Split the email address string in an array. 
			 * @var array
			 */
			$analyze = explode('@', $this->data['Alias']['name']);

			/**
			 * Check if the domain name in the email address is the same than the domain name selected in the domains list.
			 */
			if (isset($analyze['1']) && $analyze['1'] != $queryDomainId['Domain']['name']) {
				$this->Session->setFlash(__d('mail', 'The mail alias domain is wrong.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			/**
			 * Save The mail alias after edit.
			 */
			if ($this->Alias->save($this->data)) {

				/**
				 * Save user ID.
				 */
				$this->Alias->saveField('user_id', $this->Auth->user('id'));

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'The mail alias has been edited.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If The mail alias is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If The mail alias is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {

			$this->data = $this->Alias->read(null, $id);
			
			/**
			 * Select the domain name of the email address and display.
			 * @var array
			 */
			$conditionDomainId = array('conditions' => array('Domain.id' => $this->data['Alias']['domain_id']));
			$queryDomainId = $this->Alias->Domain->find('list', $conditionDomainId);

			/**
			 * Put the domain in "domain".
			 * $domain will be available in the view.
			 */
			$this->set('domain', $queryDomainId);

		}

	}

	/**
	 * This function delete an alias by ID.
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
		 * $id = The mail alias ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('mail', 'Invalid mail alias.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if The mail alias belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Alias', $id, $this->Auth->user('id'));

		/**
		 * Select the alias name with the ID.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Alias');

		/**
		 * Delete The mail alias.
		 * Redirect the user to index page.
		 */
		if ($this->Alias->delete($id)) {

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'The mail alias has been deleted.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('mail', 'The mail alias has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function disable an alias by ID.
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

		$alias = $this->Alias->read(null, $id);

		/**
		 * Check if The mail alias belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Alias', $id, $this->Auth->user('id'));

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($alias)) {

			$alias['Alias']['status'] = 1;

			/**
			 * Change The mail alias status.
			 * Redirect the user to inex page.
			 */
			if ($this->Alias->save($alias)) {

				/**
				 * Select the alias name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Alias');

				/**
				 * Insert the disabled action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'The mail alias has been disabled.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);
				
				$this->Session->setFlash(__d('mail', 'The mail alias has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

	/**
	 * This function enable an alias by ID.
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

		$alias = $this->Alias->read(null, $id);

		/**
		 * Check if The mail alias belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Alias', $id, $this->Auth->user('id'));

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($alias)) {

			$alias['Alias']['status'] = 0;

			/**
			 * Change The mail alias status.
			 * Redirect the user to inex page.
			 */
			if ($this->Alias->save($alias)) {

				/**
				 * Select the alias name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Alias');

				/**
				 * Insert the enabled action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'The mail alias has been enabled.', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('mail', 'The mail alias has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all aliases inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Alias->recursive = 0;

		/**
		 * Put all aliases in "aliases".
		 * $aliases will be available in the view.
		 */
		$this->set('aliases', $this->paginate());

	}

	/**
	 * This function allow an administrator to create an alias for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			/**
			 * Select user ID.
			 * @var array
			 */
			$domainId = $this->Alias->Domain->find('all', array('conditions' => array('id' => $this->data['Alias']['domain_id'])));
			$userId = $domainId['0']['Domain']['user_id'];

			/**
			 * Save the new alias.
			 */
			$this->Alias->create();
			if ($this->Alias->save($this->data)) {

				/**
				 * Save the user ID.
				 */
				$this->Alias->saveField('user_id', $userId);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'Mail alias added by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new alias is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If The mail alias is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all domains.
		 * @var array
		 */
		$domains = $this->Alias->Domain->find('list');

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function allow an administrator to edit an alias by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The mail alias ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('mail', 'Invalid mail alias.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save The mail alias after edit.
			 */
			if ($this->Alias->save($this->data)) {

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'Mail alias edited by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new alias is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If The mail alias is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('mail', 'The mail alias has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Alias->read(null, $id);
		}

		/**
		 * Select all domains.
		 * @var array
		 */
		$domains = $this->Alias->Domain->find('list');

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));

	}

	/**
	 * This function allow an administrator to delete an alias by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The mail alias ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('mail', 'Invalid mail alias.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the alias name with the ID.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Alias');

		/**
		 * Delete The mail alias.
		 * Redirect the administrator to index page.
		 */
		if ($this->Alias->delete($id)) {

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'Mail alias deleted by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('mail', 'The mail alias has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function allow an administrator to disable an alias by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$alias = $this->Alias->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($alias)) {

			$alias['Alias']['status'] = 1;

			/**
			 * Change The mail alias status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Alias->save($alias)) {

				/**
				 * Select the alias name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Alias');

				/**
				 * Insert the disabled action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'Mail alias disabled by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('mail', 'The mail alias has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

	/**
	 * This function allow an administrator to enable an alias by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$alias = $this->Alias->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($alias)) {

			$alias['Alias']['status'] = 0;

			/**
			 * Change the alais status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Alias->save($alias)) {

				/**
				 * Select the alias name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Alias');

				/**
				 * Insert the enable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Alias']['name'] . ' ]</strong> ' . __d('mail', 'Mail alias enabled by (' . $this->Auth->user('name') . ').', true) , 'MAIL', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('mail', 'The mail alias has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

}

?>