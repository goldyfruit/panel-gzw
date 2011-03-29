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

class SqlusersController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Sqlusers';

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
	 * This function return a sql users list who belongs to the user.
	 * @return array
	 */
	function index() {
		
		/**
		 * Check if SQL module is enabled.
		 * Call "Module" component to check.
		 * 'SQL' is the module name (check in database).
		 */
		$this->Module->check('SQL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->Sqluser->recursive = 0;

		/**
		 * Select all sql users who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Sqluser.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all sql users in "sqldatas".
		 * $sqldatas will be available in the view.
		 */
		$this->set('sqlusers', $this->paginate());

		/**
		 * Display sql database quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Sqluser', 'sqluser'));

	}

	/**
	 * This function create the new sql user.
	 * @return array
	 */
	function add() {

		/**
		 * Check if SQL module is enabled.
		 * Call "Module" component to check.
		 * 'SQL' is the module name (check in database).
		 */
		$this->Module->check('SQL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if sql databases quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Sqluser', 'sqluser');

		if (!empty($this->data)) {

			/**
			 * Save the new sql user.
			 */
			$this->Sqluser->create();
			if ($this->Sqluser->save($this->data)) {

				/**
				 * Set the lower case for user name.
				 */
				 $userName = strtolower($this->data['Sqluser']['name']) . '@' . $this->Auth->user('name');

				/**
				 * Save the sql user name.
				 */
				$this->Sqluser->saveField('name', $userName);

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($userName, 'SQLUSER', $this->Auth->user('name'), NULL, NULL, $this->data['Sqluser']['password'], 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $userName . ' ]</strong> ' . __d('sql', 'The SQL user has been saved.', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);
				
				/**
				 * If the sql user is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql user is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

	}

	/**
	 * This function edit a sql user.
	 * The domain is seleted by ID.
	 * @param var $id
	 * @return array
	 */
	function edit($id = null) {
		
		/**
		 * Check if SQL module is enabled.
		 * Call "Module" component to check.
		 * 'SQL' is the module name (check in database).
		 */
		$this->Module->check('SQL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The sql user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the sql user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Sqluser', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Save the sql database after edit.
			 */
			if ($this->Sqluser->save($this->data)) {

				/**
				 * Set the lower case for user name.
				 */
				 $userName = strtolower($this->data['Sqluser']['name']) . '@' . $this->Auth->user('name');

				/**
				 * Save the sql user name after edit.
				 */
				$this->Sqluser->saveField('name', $userName);

				/**
				 * Insert the edit action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($userName, 'SQLUSER', $this->Auth->user('name'), NULL, NULL, NULL, 3);

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $userName . ' ]</strong> ' . __d('sql', 'The SQL user has been edited.', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the sql user is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql database is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			
			$this->data = $this->Sqluser->read(null, $id);

			/**
			 * Display just the first part of the ftp user name.
			 * Example : data@gzw-000002 -> data = First part | gzw-000002 = Second part
			 * @var array
			 */
			$nameEdit = $this->data;
			$nameEdit = explode('@', $nameEdit['Sqluser']['name']);

			/**
			 * Put the sql user name in "nameEdit".
			 * $nameEdit will be available in the view.
			 */
			$this->set(compact('nameEdit'));

		}

	}

	/**
	 * This function delete a sql database by ID.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {
		
		/**
		 * Check if SQL module is enabled.
		 * Call "Module" component to check.
		 * 'SQL' is the module name (check in database).
		 */
		$this->Module->check('SQL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The sql user ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action'=>'index'));
		}

		/**
		 * Select the sql user name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Sqluser');

		/**
		 * Check if the sql user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Sqluser', $id, $this->Auth->user('id'));

		/**
		 * Delete the sql user.
		 * Redirect the user to index page.
		 */
		if ($this->Sqluser->delete($id)) {

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Sqluser']['name'], 'SQLUSER', $this->Auth->user('name'), NULL, NULL, NULL, 2);

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Sqluser']['name'] . ' ]</strong> ' . __d('sql', 'The SQL user has been deleted.', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('sql', 'The SQL user has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}

	}

	/**
	 * This function change the sql user password by ID.
	 * @param var $id
	 * @return array
	 */
	function password($id = null) {

		/**
		 * Check if SQL module is enabled.
		 * Call "Module" component to check.
		 * 'SQL' is the module name (check in database).
		 */
		$this->Module->check('SQL');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The sql user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password'));
		}

		/**
		 * Check if the sql user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Sqluser', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Save the sql user password.
			 */
			if ($this->Sqluser->save($this->data)) {

				/**
				 * Select the sql user name with the ID.
				 * It's necessary for the insert in the "robot" table.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Sqluser');

				/**
				 * Insert the change password action in the "robot" table.
				 * The Perl robot will check in this table.
				 */

				$this->Robot->insert($data['Sqluser']['name'], 'SQLUSER', $this->Auth->user('name'), NULL, NULL, $this->data['Sqluser']['password'], 6);
			
				/**
				 * Insert the change action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Sqluser']['name'] . ' ]</strong> ' . __d('sql', 'The SQL user password has been changed.', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the sql user password is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user password has been changed.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql user is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user password has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Sqluser->read(null, $id);
		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all sql users inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Sqluser->recursive = 0;

		/**
		 * Put all sql users in "sqlusers".
		 * $sqlusers will be available in the view.
		 */
		$this->set('sqlusers', $this->paginate());

	}

	/**
	 * This function allows an administrator to create a sql user for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			/**
			 * Save the new sql user.
			 */
			$this->Sqluser->create();
			if ($this->Sqluser->save($this->data)) {

				/**
				 * Select all informations about the user.
				 * @var array
				 */
				$conditionUserId = array('conditions' => array('User.id' => $this->data['Sqluser']['user_id']));
				$queryUserId = $this->Sqluser->User->find('first', $conditionUserId);

				/**
				 * Set the lower case for user name.
				 */
				 $userName = strtolower($this->data['Sqluser']['name']) . '@' . $queryUserId['User']['name'];

				/**
				 * Save the sql user name.
				 */
				$this->Sqluser->saveField('name', $userName);

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($userName, 'SQLUSER', $queryUserId['User']['name'], NULL, NULL, $this->data['Sqluser']['password'], 1);

				/**
				 * Insert the add action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $userName . ' ]</strong> ' . __d('sql', 'SQL user added by (' . $this->Auth->user('name') . ').', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new sql user is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql user is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has not been saved.', true), 'default', array('class' => 'error'));
				
			}
		}

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Sqluser->User->find('list');

		/**
		 * Put all sql users in 'sqlusers".
		 * $sqlusers will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allows an administrator to edit a sql user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The sql user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Select all informations about the user.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('User.id' => $this->data['Sqluser']['user_id']));
			$queryUserId = $this->Sqluser->User->find('first', $conditionUserId);

			/**
			 * Set the lower case for user name.
			 */
			 $userName = strtolower($this->data['Sqluser']['name']) . '@' . $queryUserId['User']['name'];

			/**
			 * Save the sql user after edit.
			 */
			if ($this->Sqluser->save($this->data)) {

				/**
				 * Save the sql user name after edit.
				 */
				$this->Sqluser->saveField('name', $userName);
				
				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($userName, 'SQLUSER', $queryUserId['User']['name'], NULL, NULL, NULL, 3);

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $userName . ' ]</strong> ' . __d('sql', 'SQL user edited by (' . $this->Auth->user('name') . ').', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new sql user is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql user is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user has not been edited.', true), 'default', array('class' => 'error'));
			}

		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {

			$this->data = $this->Sqluser->read(null, $id);

			/**
			 * Display just the first part of the sql database name.
			 * Example : forum@gzw-000002 -> forum = First part | gzw-000002 = Second part
			 * @var string
			 */
			$nameEdit = $this->data;
			$nameEdit = explode('@', $nameEdit['Sqluser']['name']);

			/**
			 * Put the sql database name in "nameEdit".
			 * $nameEdit will be available in the view.
			 */
			$this->set(compact('nameEdit'));
		}

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Sqluser->User->find('list');

		/**
		 * Put all sql users in 'sqlusers".
		 * $sqlusers will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allows an administrator to delete a sql user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The sql user ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the sql user name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Sqluser');

		/**
		 * Delete the sql user.
		 * Redirect the administrator to index page.
		 */
		if ($this->Sqluser->delete($id)) {

			/**
			 * Split the sql user name.
			 * Example : data@gzw-000002 -> data = First part | gzw-000002 = Second part
			 * @var array
			 */
			$nameEdit = explode('@', $data['Sqluser']['name']);

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Sqluser']['name'], 'SQLUSER', $nameEdit['1'], NULL, NULL, NULL, 2);

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Sqluser']['name'] . ' ]</strong> ' . __d('sql', 'SQL user deleted by (' . $this->Auth->user('name') . ').', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('sql', 'The SQL user has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}

	}

	/**
	 * This function allows an administrator to change the sql user password by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_password($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The ql user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password'));
		}

		if (!empty($this->data)) {

			/**
			 * Select the sql user name with the ID.
			 * It's necessary for the insert in the "robot" table.
			 * @var string
			 */
			$data = $this->Robot->search($id, 'Sqluser');

			/**
			 * Split the sql user name.
			 * Example : data@gzw-000002 -> data = First part | gzw-000002 = Second part
			 * @var array
			 */
			$nameEdit = explode('@', $data['Sqluser']['name']);

			/**
			 * Save the sql user password after edit.
			 */
			if ($this->Sqluser->save($this->data)) {

				/**
				 * Insert the change password action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Sqluser']['name'], 'SQLUSER', $nameEdit['1'], NULL, NULL, $this->data['Sqluser']['password'], 6);

				/**
				 * Insert the change action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Sqluser']['name'] . ' ]</strong> ' . __d('sql', 'SQL user password changed by (' . $this->Auth->user('name') . ').', true), 'SQLUSER', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the sql user password is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user password has been changed.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql user password is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL user password has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Sqluser->read(null, $id);
		}

	}
	
}

?>