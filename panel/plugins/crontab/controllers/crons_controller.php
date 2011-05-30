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

class CronsController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Crons';

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
	var $components = array('Quota', 'Module', 'Maintenance', 'Secureid', 'Robot', 'Logs');

	/*************************************************************************
	 * 								MEMBER PART
	 *************************************************************************/

	/**
	 * This function return a cronjobs list who belongs to the user.
	 * @return array
	 */
	function index() {

		/**
		 * Check if CRON module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('CRON');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->Cron->recursive = 0;

		/**
		 * Select all cronjobs who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Cron.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;
		
		/**
		 * Put all crons in "crons".
		 * $crons will be available in the view.
		 */
		$this->set('crons', $this->paginate());
		
		/**
		 * Display cronjobs quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Cron', 'cron'));

	}

	/**
	 * This function create the new cronjob.
	 * @return array
	 */
	function add() {

		/**
		 * Check if CRON module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('CRON');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if cron quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Cron', 'cron');
		
		if (!empty($this->data)) {

			/**
			 * Check if the directory of the task script is available.
			 * If not the an error message is displayed.
			 */
			if (!file_exists($this->data['Cron']['panelPath'] . $this->Auth->user('name') . '/cron/' . $this->data['Cron']['path'])) {
				$this->Session->setFlash(__d('crontab', 'The script does not exist in the "cron" directory.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			$this->Cron->create();

			/**
			 * Save new cronjob.
			 */
			if ($this->Cron->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 * Example :
				 *	 	$this->data['Cron']['type'] . ' ' . $this->Auth->user('name') . ' php -c '. $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $this->Auth->user('name') . '/php.ini ' . $this->data['Cron']['panelPath'] . $this->Auth->user('name') . '/cron/' . $this->data['Cron']['path'] . '
				 * Can become :
				 * 		00 00 * * * gzw-000002 php -c /srv/data/php5-fcgi/gzw-000002/php.ini /srv/data/gzw-000002/cron/task1.php
				 */
				$taskData = $this->data['Cron']['type'] . ' php -c '. $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $this->Auth->user('name') . '/php.ini ' . $this->data['Cron']['panelPath'] . $this->Auth->user('name') . '/cron/' . $this->data['Cron']['path'] . ' > /var/log/panel-gzw/crons.log';
				$this->Robot->insert($taskData, 'CRON', $this->Auth->user('name'), $this->Auth->user('email'), NULL, $this->data['Cron']['name'], 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'The cronjob has been added.', true), 'CRON', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new cronjob is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the cronjob is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has not been saved.', true), 'default', array('class' => 'error'));
			}
		}
	}

	/**
	 * This function edit a cronjob.
	 * The cronjob is seleted by ID.
	 * @param var $id
	 * @return array
	 */
	function edit($id = null) {

		/**
		 * Check if CRON module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('CRON');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The cronjob ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('crontab', 'Invalid cronjob.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the cronjob belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Cron', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Check if the directory of the task script is available.
			 * If not the an error message is displayed.
			 */
			if (!file_exists($this->data['Cron']['panelPath'] . $this->Auth->user('name') . '/cron/' . $this->data['Cron']['path'])) {
				$this->Session->setFlash(__d('crontab', 'The script does not exist in the "cron" directory.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'edit', $id));
			}

			/**
			 * Save the cronjob after edit.
			 */
			if ($this->Cron->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 * Example :
				 *	 	$this->data['Cron']['type'] . ' ' . $this->Auth->user('name') . ' php -c '. $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $this->Auth->user('name') . '/php.ini ' . $this->data['Cron']['panelPath'] . $this->Auth->user('name') . '/cron/' . $this->data['Cron']['path'] . '
				 * Can become :
				 * 		00 00 * * * gzw-000002 php -c /srv/data/php5-fcgi/gzw-000002/php.ini /srv/data/gzw-000002/cron/task1.php
				 */
				$taskData = $this->data['Cron']['type'] . ' php -c '. $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $this->Auth->user('name') . '/php.ini ' . $this->data['Cron']['panelPath'] . $this->Auth->user('name') . '/cron/' . $this->data['Cron']['path'] . ' > /var/log/panel-gzw/crons.log';

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'The cronjob has been edited.', true), 'CRON', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the cronjob is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has been edited.', true));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the cronjob is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Cron->read(null, $id);
		}

	}

	/**
	 * This function delete a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {

		/**
		 * Check if CRON module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('CRON');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The cronjob ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('crontab', 'Invalid cronjob.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the cronjob belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Cron', $id, $this->Auth->user('id'));

		/**
		 * Select the cronjob name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Cron');

		/**
		 * Delete the cronjob.
		 * Redirect the user to index page.
		 */
		if ($this->Cron->delete($id)) {
			
			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Cron']['name'], 'CRON', $this->Auth->user('name'), NULL, NULL, NULL, 2);

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'The cronjob has been deleted.', true), 'CRON', $_SERVER["REMOTE_ADDR"]);
			
			$this->Session->setFlash(__d('crontab', 'The cronjob has been deleted.', true));
			$this->redirect(array('action' => 'index'));

		}

	}

	/**
	 * This function disable a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function disable($id = null) {

		/**
		 * Check if CRON module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('CRON');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if the cronjob belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Cron', $id, $this->Auth->user('id'));

		$cron = $this->Cron->read(null, $id);
		
		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($cron)) {

			$cron['Cron']['status'] = 1;
			
			/**
			 * Change the cronjob status.
			 * Redirect the user to index page.
			 */
			if ($this->Cron->save($cron)) {
		
				/**
				 * Select the cronjob name with the ID.
				 * It's necessary for the insert in the "robot" table.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Cron');
				
				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Cron']['name'], 'CRON', $this->Auth->user('name'), NULL, NULL, $data['Cron']['name'], 4);

				/**
				 * Insert the disable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'The cronjob has been disabled.', true), 'CRON', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('crontab', 'The cronjob has been disabled.', true));
				$this->redirect(array('action' => 'index'));

			}

		}

	}

	/**
	 * This function enable a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function enable($id = null) {

		/**
		 * Check if CRON module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('CRON');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if the cronjob belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Cron', $id, $this->Auth->user('id'));

		$cron = $this->Cron->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($cron)) {

			$cron['Cron']['status'] = 0;

			/**
			 * Change the cronjob status.
			 * Redirect the user to index page.
			 */
			if ($this->Cron->save($cron)) {

				/**
				 * Select the cronjob name with the ID.
				 * It's necessary for the insert in the "robot" table.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Cron');

				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Cron']['name'], 'CRON', $this->Auth->user('name'), NULL, NULL, $data['Cron']['name'], 5);

				/**
				 * Insert the enable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'The cronjob has been enabled.', true), 'CRON', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('crontab', 'The cronjob has been enabled.', true));
				$this->redirect(array('action' => 'index'));

			}

		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all cronjob inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Cron->recursive = 0;

		/**
		 * Put all crons in "crons".
		 * $crons will be available in the view.
		 */
		$this->set('crons', $this->paginate());

	}

	/**
	 * This function allows an administrator to create a cronjob for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {
			
			/**
			 * Select user ID.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('User.id' => $this->data['Cron']['user_id']));
			$queryUserId = $this->Cron->User->find('first', $conditionUserId);
			
			/**
			 * Check if the directory of the task script is available.
			 * If not the an error message is displayed.
			 */
			if (!file_exists($this->data['Cron']['panelPath'] . $queryUserId['User']['name'] . '/cron/' . $this->data['Cron']['path'])) {
				$this->Session->setFlash(__d('crontab', 'The script does not exist in the "cron" directory.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			/**
			 * Save new cronjob.
			 */
			$this->Cron->create();
			if ($this->Cron->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 * Example :
				 *	 	$this->data['Cron']['type'] . ' ' . $queryUserId['User']['name'] . ' php -c ' . $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $queryUserId['User']['name'] . '/php.ini ' . $this->data['Cron']['panelPath'] . $queryUserId['User']['name'] . '/cron/' . $this->data['Cron']['path'] . '
				 * Can become :
				 * 		00 00 * * * gzw-000002 php -c /srv/data/php5-fcgi/gzw-000002/php.ini /srv/data/gzw-000002/cron/task1.php
				 */
				$taskData = $this->data['Cron']['type'] . ' php -c ' . $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $queryUserId['User']['name'] . '/php.ini ' . $this->data['Cron']['panelPath'] . $queryUserId['User']['name'] . '/cron/' . $this->data['Cron']['path'] . ' > /var/log/panel-gzw/crons.log';
				$this->Robot->insert($taskData, 'CRON', $queryUserId['User']['name'], $queryUserId['User']['email'], NULL, $this->data['Cron']['name'], 1);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'Cronjob added by (' . $this->Auth->user('name') . ').', true) , 'CRON', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new cronjob is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the cronjob is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Cron->User->find('list');

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allows an administrator to edit a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The cronjob ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('crontab', 'Invalid cronjob', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Select user ID.
			 * @var array
			 */
			$conditionUserId = array('conditions' => array('User.id' => $this->data['Cron']['user_id']));
			$queryUserId = $this->Cron->User->find('first', $conditionUserId);

			/**
			 * Check if the directory of the task script is available.
			 * If not the an error message is displayed.
			 */
			if (!file_exists($this->data['Cron']['panelPath'] . $queryUserId['User']['name'] . '/cron/' . $this->data['Cron']['path'])) {
				$this->Session->setFlash(__d('crontab', 'The script does not exist in the "cron" directory.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'edit', $id));
			}

			/**
			 * Save the cronjob after edit.
			 */
			if ($this->Cron->save($this->data)) {

				/**
				 * Insert the create action in the "robot" table.
				 * The Perl robot will check in this table.
				 * Example :
				 *	 	$this->data['Cron']['type'] . ' ' . $queryUserId['User']['name'] . ' php -c ' . $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $queryUserId['User']['name'] . '/php.ini ' . $this->data['Cron']['panelPath'] . $queryUserId['User']['name'] . '/cron/' . $this->data['Cron']['path'] . '
				 * Can become :
				 * 		00 00 * * * gzw-000002 php -c /srv/data/php5-fcgi/gzw-000002/php.ini /srv/data/gzw-000002/cron/task1.php
				 */
				$taskData = $this->data['Cron']['type'] . ' php -c ' . $this->data['Cron']['panelPath'] . 'php5-fcgi/' . $queryUserId['User']['name'] . '/php.ini ' . $this->data['Cron']['panelPath'] . $queryUserId['User']['name'] . '/cron/' . $this->data['Cron']['path'] . ' > /var/log/panel-gzw/crons.log';
				$this->Robot->insert($taskData, 'CRON', $queryUserId['User']['name'], $queryUserId['User']['email'], NULL, $this->data['Cron']['name'], 3);

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'Cronjob edited by (' . $this->Auth->user('name') . ').', true) , 'CRON', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new cronjob is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has been edited.', true));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the cronjob is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('crontab', 'The cronjob has not been edited.', true), 'default', array('class' => 'error'));
			}
		}
		
		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Cron->read(null, $id);
		}

		/**
		 * Select all users
		 * @var array
		 */
		$users = $this->Cron->User->find('list');

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allows an administrator to delete a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The cronjob ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('crontab', 'Invalid cronjob.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the cronjob name with the ID.
		 * It's necessary for the insert in the "robot" table.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Cron');
		
		/**
		 * Delete the cronjob.
		 * Redirect the administrator to index page.
		 */
		if ($this->Cron->delete($id)) {

			/**
			 * Insert the delete action in the "robot" table.
			 * The Perl robot will check in this table.
			 */
			$this->Robot->insert($data['Cron']['name'], 'CRON', $data['User']['name'], NULL, NULL, $data['Cron']['name'], 2);

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'Cronjob deleted by (' . $this->Auth->user('name') . ').', true) , 'CRON', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('crontab', 'The cronjob has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}
	}

	/**
	 * This function allows an administrator to disable a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$cron = $this->Cron->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($cron)) {

			$cron['Cron']['status'] = 1;
			
			/**
			 * Select the cronjob name with the ID.
			 * It's necessary for the insert in the "robot" table.
			 * @var string
			 */
			$data = $this->Robot->search($id, 'Cron');

			/**
			 * Change the cronjob status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Cron->save($cron)) {
				
				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Cron']['name'], 'Cron', $data['User']['name'], NULL, NULL, $data['Cron']['name'], 4);

				/**
				 * Insert the delete action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'Cronjob disabled by (' . $this->Auth->user('name') . ').', true) , 'CRON', $_SERVER["REMOTE_ADDR"]);


				$this->Session->setFlash(__d('crontab', 'The cronjob has been disabled.', true));
				$this->redirect(array('action' => 'index'));

			}
		}
	}

	/**
	 * This function allows an administrator to enable a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$cron = $this->Cron->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($cron)) {
	
			$cron['Cron']['status'] = 0;

			/**
			 * Select the cronjob name with the ID.
			 * It's necessary for the insert in the "robot" table.
			 * @var string
			 */
			$data = $this->Robot->search($id, 'Cron');
			
			/**
			 * Change the cronjob status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Cron->save($cron)) {
				
				/**
				 * Insert the delete action in the "robot" table.
				 * The Perl robot will check in this table.
				 */
				$this->Robot->insert($data['Cron']['name'], 'Cron', $data['User']['name'], NULL, NULL, $data['Cron']['name'], 5);

				/**
				 * Insert the delete action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Cron']['name'] . ' ]</strong> ' . __d('crontab', 'Cronjob enabled by (' . $this->Auth->user('name') . ').', true) , 'CRON', $_SERVER["REMOTE_ADDR"]);


				$this->Session->setFlash(__d('crontab', 'The cronjob has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}

		}

	}

}

?>