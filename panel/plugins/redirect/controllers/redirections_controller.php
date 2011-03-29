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

class RedirectionsController extends RedirectAppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Redirections';

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

	/**
	 * This function return a redirection list who belongs to the user.
	 * @return array
	 */
	function index() {

		/**
		 * Check if REDIRECT module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('REDIRECT');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->Redirect->recursive = 0;

		/**
		 * Select all redirections who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Redirection.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all redirections in "redirections".
		 * $redirections will be available in the view.
		 */
		$this->set('redirections', $this->paginate());

		/**
		 * Display redirections quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Redirection', 'redirection'));

	}

	function add() {

		/**
		 * Check if REDIRECT module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('REDIRECT');

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
		$this->Quota->check('Redirection', 'redirection');

		if (!empty($this->data)) {
			$this->Redirection->create();
			if ($this->Redirection->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Redirection']['name'], 'REDIRECT', $this->Auth->user('name'), NULL, $this->data['Redirection']['domain_id'], NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Redirection']['name'] . ' ]</strong> ' . __d('redirect', 'The redirection has been saved.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);
				
				
				$this->Session->setFlash(__('The redirection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The redirection could not be saved. Please, try again.', true));
			}
		}

		/**
		 * Select all domains who belongs to the user.
		 * Select by user ID.
		 * @var array
		 */
		$conditions = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$domains = $this->Redirection->Domain->find('list', $conditions);
		$this->set(compact('domains'));
	}

	function edit($id = null) {

		/**
		 * Check if REDIRECT module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('REDIRECT');

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
			$this->Session->setFlash(__('Invalid redirection', true));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the redirection belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Redirection', $id, $this->Auth->user('id'));
		
		if (!empty($this->data)) {
			if ($this->Redirection->save($this->data)) {
			
				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($this->data['Redirection']['name'], 'REDIRECT', $this->Auth->user('name'), NULL, $this->data['Redirection']['domain_id'], NULL, 3);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Redirection']['name'] . ' ]</strong> ' . __d('redirect', 'The redirection has been edited.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

			
				$this->Session->setFlash(__('The redirection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The redirection could not be saved. Please, try again.', true));
			}
		}

		if (empty($this->data)) {
			$this->data = $this->Redirection->read(null, $id);
		}

		/**
		 * Select all redirections who belongs to the user.
		 * Select by user ID.
		 * @var array
		 */
		$conditions = array('conditions' => array('Domain.user_id' => $this->Auth->user('id')));
		$domains = $this->Redirection->Domain->find('list', $conditions);

		/**
		 * Put all domains in "$domains".
		 * $domains will be available in the view.
		 */
		$this->set(compact('domains'));
	}

	/**
	 * This function delete a redirection by ID.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {

		/**
		 * Check if REDIRECT module is enabled.
		 * Call "Module" component to check.
		 * 'DNS' is the module name (check in database).
		 */
		$this->Module->check('REDIRECT');

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
			$this->Session->setFlash(__('Invalid id for redirection', true));
			$this->redirect(array('action'=>'index'));
		}

		/**
		 * Select the redirection name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Redirection');

		/**
		 * Check if the redirection belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Redirection', $id, $this->Auth->user('id'));
		
		if ($this->Redirection->delete($id)) {

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Redirection']['name'], 'REDIRECT', $this->Auth->user('name'), $this->Auth->user('email'), $data['Redirection']['domain_id'], NULL, 2);

			/**
			 * Insert the create action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Redirection']['name'] . ' ]</strong> ' . __d('redirect', 'The redirection has been deleted.', true) , 'DNS', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__('Redirection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Redirection was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

	function admin_index() {
		$this->Redirection->recursive = 0;
		$this->set('redirections', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid redirection', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('redirection', $this->Redirection->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Redirection->create();
			if ($this->Redirection->save($this->data)) {
				$this->Session->setFlash(__('The redirection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The redirection could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Redirection->User->find('list');
		$domains = $this->Redirection->Domain->find('list');
		$this->set(compact('users', 'domains'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid redirection', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Redirection->save($this->data)) {
				$this->Session->setFlash(__('The redirection has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The redirection could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Redirection->read(null, $id);
		}
		$users = $this->Redirection->User->find('list');
		$domains = $this->Redirection->Domain->find('list');
		$this->set(compact('users', 'domains'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for redirection', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Redirection->delete($id)) {
			$this->Session->setFlash(__('Redirection deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Redirection was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>