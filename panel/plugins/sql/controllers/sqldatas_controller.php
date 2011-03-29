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

class SqldatasController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Sqldatas';

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
	 * This function return a sql databases list who belongs to the user.
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

		$this->Sqldata->recursive = 0;

		/**
		 * Select all sql databases who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Sqldata.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all sql databases in "sqldatas".
		 * $sqldatas will be available in the view.
		 */
		$this->set('sqldatas', $this->paginate());

		/**
		 * Display sql database quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Sqldata', 'sqldata'));

	}

	/**
	 * This function create the new sql database.
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
		 * Check if at least one sql user is created.
		 * If not the user is redirected with an error message.
		 * Call the "Check" component.
		 */
		$this->Check->sqlusers('Sqlusers');

		/**
		 * Check if sql databases quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Sqldata', 'sqldata');

		if (!empty($this->data)) {

			/**
			 * Save the new sql database.
			 */
			$this->Sqldata->create();
			if ($this->Sqldata->save($this->data)) {

				/**
				 * Set the lower case for database name.
				 */
				 $databaseName = strtolower($this->data['Sqldata']['name']) . '_' . $this->Auth->user('name');

				/**
				 * Save the sql database name.
				 */
				$this->Sqldata->saveField('name', $databaseName);

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($databaseName, 'SQLDATA', $this->data['Sqldata']['sqluser_id'], NULL, NULL, NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $databaseName . ' ]</strong> ' . __d('sql', 'The SQL database has been saved.', true), 'SQLDATA', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the sql database is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql database is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select sql user(s) who belongs to the user.
		 * @var array
		 */
		$conditionSqlUser = array('conditions' => array('Sqluser.user_id' => $this->Auth->user('id')));
		$sqlusers = $this->Sqldata->Sqluser->find('list', $conditionSqlUser);

		/**
		 * Display sql user(s).
		 * $sqlusers will be available in the view.
		 */
		$this->set(compact('sqlusers'));

	}

	/**
	 * This function edit a sql database.
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
		 * $id = The sql database ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL database.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the sql database belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Sqldata', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Save the sql database after edit.
			 */
			if ($this->Sqldata->save($this->data)) {

				/**
				 * Set the lower case for database name.
				 */
				 $databaseName = strtolower($this->data['Sqldata']['name']) . '_' . $this->Auth->user('name');

				/**
				 * Save the sql database name after edit.
				 */
				$this->Sqldata->saveField('name', $databaseName);

				/**
				 * Insert the edit action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($databaseName, 'SQLDATA', $this->data['Sqldata']['sqluser_id'], NULL, NULL, NULL, 3);

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $databaseName . ' ]</strong> ' . __d('sql', 'The SQL database has been edited.', true), 'SQLDATA', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the sql database is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has been edited.', true));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the sql database is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has not been edited.', true), 'default', array('class' => 'error'));
				
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {

			$this->data = $this->Sqldata->read(null, $id);

			/**
			 * Display just the first part of the sql database name.
			 * Example : forum_gzw-000002 -> forum = First part | gzw-000002 = Second part
			 * @var string
			 */
			$nameEdit = $this->data;
			$nameEdit = explode('_', $nameEdit['Sqldata']['name']);

			/**
			 * Put the sql database name in "nameEdit".
			 * $nameEdit will be available in the view.
			 */
			$this->set(compact('nameEdit'));

		}

		/**
		 * Select sql user(s) who belongs to the user.
		 * @var array
		 */
		$conditionSqlUser = array('conditions' => array('Sqluser.user_id' => $this->Auth->user('id')));
		$sqlusers = $this->Sqldata->Sqluser->find('list', $conditionSqlUser);

		/**
		 * Display sql user(s).
		 * $sqlusers will be available in the view.
		 */
		$this->set(compact('sqlusers'));

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
		 * $id = The sql database ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL database.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the sql database name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Sqldata');

		/**
		 * Check if the sql database belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Sqldata', $id, $this->Auth->user('id'));

		/**
		 * Delete the sql database.
		 * Redirect the user to index page.
		 */
		if ($this->Sqldata->delete($id)) {

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Sqldata']['name'], 'SQLDATA', $data['Sqldata']['sqluser_id'], NULL, NULL, NULL, 2);
			
			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Sqldata']['name'] . ' ]</strong> ' . __d('sql', 'The SQL database has been deleted.', true), 'SQLDATA', $_SERVER["REMOTE_ADDR"]);
			
			$this->Session->setFlash(__d('sql', 'The SQL database has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all sql databases inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Sqldata->recursive = 0;

		/**
		 * Put all sql databases in "sqldatas".
		 * $sqldatas will be available in the view.
		 */
		$this->set('sqldatas', $this->paginate());

	}

	/**
	 * This function allow an administrator to create a sql database for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			/**
			 * Save the new sql database.
			 */
			$this->Sqldata->create();
			if ($this->Sqldata->save($this->data)) {

				/**
				 * Select all informations about the user.
				 * @var array
				 */
				$conditionUserId = array('conditions' => array('User.id' => $this->data['Sqldata']['user_id']));
				$queryUserId = $this->Sqldata->User->find('first', $conditionUserId);

				/**
				 * Set the lower case for database name.
				 */
				 $databaseName = strtolower($this->data['Sqldata']['name']) . '_' . $queryUserId['User']['name'];

				/**
				 * Save the sql database name.
				 */
				$this->Sqldata->saveField('name', $databaseName);
				
				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($databaseName, 'SQLDATA', $queryUserId['User']['name'], NULL, NULL, NULL, 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $databaseName . ' ]</strong> ' . __d('sql', 'SQL database added by (' . $this->Auth->user('name') . ').', true), 'SQLDATA', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new sql database is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql database is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all sql users.
		 * @var array
		 */
		$sqlusers = $this->Sqldata->Sqluser->find('list');

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Sqldata->User->find('list');

		/**
		 * Put all users in "users" and sql users in 'sqlusers".
		 * $users and $sqlusers will be available in the view.
		 */
		$this->set(compact('sqlusers', 'users'));

	}

	/**
	 * This function allow an administrator to edit a sql database by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The sql database ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL database.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Select all informations about the user.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('User.id' => $this->data['Sqldata']['user_id']));
			$queryUserId = $this->Sqldata->User->find('first', $conditionUserId);

			/**
			 * Set the lower case for database name.
			 */
			 $databaseName = strtolower($this->data['Sqldata']['name']) . '_' . $queryUserId['User']['name'];

			/**
			 * Save the sql database after edit.
			 */
			if ($this->Sqldata->save($this->data)) {

				/**
				 * Save the sql database name after edit.
				 */
				$this->Sqldata->saveField('name', $databaseName);

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($databaseName, 'SQLDATA', $queryUserId['User']['name'], NULL, NULL, NULL, 3);
				
				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $databaseName . ' ]</strong> ' . __d('sql', 'SQL database edited by (' . $this->Auth->user('name') . ').', true), 'SQLDATA', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new sql database is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has been edited.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the sql database is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('sql', 'The SQL database has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {

			$this->data = $this->Sqldata->read(null, $id);

			/**
			 * Display just the first part of the sql database name.
			 * Example : forum_gzw-000002 -> forum = First part | gzw-000002 = Second part
			 * @var string
			 */
			$nameEdit = $this->data;
			$nameEdit = explode('_', $nameEdit['Sqldata']['name']);

			/**
			 * Put the sql database name in "nameEdit".
			 * $nameEdit will be available in the view.
			 */
			$this->set(compact('nameEdit'));

		}

		/**
		 * Select all sql users.
		 * @var array
		 */
		$sqlusers = $this->Sqldata->Sqluser->find('list');

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Sqldata->User->find('list');

		/**
		 * Put all users in "users" and sql users in 'sqlusers".
		 * $users will be available in the view.
		 */
		$this->set(compact('sqlusers', 'users'));

	}

	/**
	 * This function allow an administrator to delete a sql database by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The sql database ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('sql', 'Invalid SQL database.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the sql database name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Sqldata');
		
		/**
		 * Delete the sql database.
		 * Redirect the administrator to index page.
		 */
		if ($this->Sqldata->delete($id)) {
			
			/**
			 * Split the sql database name.
			 * Example : data_gzw-000002 -> data = First part | gzw-000002 = Second part
			 * @var array
			 */
			$nameEdit = explode('_', $data['Sqldata']['name']);

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Sqldata']['name'], 'SQLDATA', $nameEdit['1'], NULL, NULL, NULL, 2);

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Sqldata']['name'] . ' ]</strong> ' . __d('sql', 'SQL database deleted by (' . $this->Auth->user('name') . ').', true), 'SQLDATA', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('sql', 'The SQL database has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

}

?>