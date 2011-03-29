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

class FtpusersController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Ftpusers';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Status');

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
	 * This function return a ftp users list who belongs to the user.
	 * @return array
	 */
	function index() {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();
		
		$this->Ftpuser->recursive = 0;

		/**
		 * Select all ftp users who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Ftpuser.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all ftp users in "ftpusers".
		 * $ftpusers will be available in the view.
		 */
		$this->set('ftpusers', $this->paginate());

		/**
		 * Display ftp users quota.
		 * Call the "Quota" component to check.
		 * $quotas will be available in the view.
		 */
		$this->set('quotas', $this->Quota->display('Ftpuser', 'ftpuser'));

	}

	/**
	 * This function display the status of a ftp user.
	 * @return array
	 */
	function status() {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->Ftpuser->recursive = 0;

		/**
		 * Select all informations about the ftp users who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Ftpuser.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all informations about ftp users in "ftpusers".
		 * $ftpusers will be available in the view.
		 */
		$this->set('ftpusers', $this->paginate());

	}

	/**
	 * This function create the new ftp usr.
	 * @return array
	 */
	function add() {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if ftp user quota is not over.
		 * If yes, the user see an error message.
		 * Call the "Quota" component to check.
		 */
		$this->Quota->check('Ftpuser', 'ftpuser');

		/**
		 * Initialization of "Ftpgroup" model.
		 * This one is necessary for the virtuals ftp users. 
		 * @var string
		 */
		$ftpgroup = ClassRegistry::init('Ftpgroup');
		
		/**
		 * Initialization of "Ftplimit" model.
		 * This one is necessary for the virtuals ftp users. 
		 * @var string
		 */
		//$ftplimit = ClassRegistry::init('Ftplimit');

		/**
		 * Initialization of "Ftpgroup" model.
		 * This one is necessary for create the quota disk. 
		 * @var string
		 */
		$quota = ClassRegistry::init('Quota');

		if (!empty($this->data)) {

			/**
			 * Check if the home directory of the new ftp user is right.
			 * If the home directory is wrong, the user is redirected on add page.
			 */
			if (!is_dir($this->data['Ftpuser']['path'] . $this->Auth->user('name') . $this->data['Ftpuser']['homedir'])) {
				$this->Session->setFlash(__d('ftp', 'The directory specified does not exist.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'add'));
			}

			$this->Ftpuser->create();

			/**
			 * Crypt the ftp password with the ProFTPd crypt.
			 * MD5 + SSL
			 * @var string
			 */
			$password = $this->data['Ftpuser']['password'];
			$md5Password = "{md5}" . base64_encode(pack("H*", md5($password)));

			/**
			 * Select all quotas about the offer.
			 * @var unknown_type
			 */
			$conditionQuotaDisk = array('conditions' => array('Quota.offer_id' => $this->Auth->user('offer_id')));
			$quotaDisk = $quota->find('all', $conditionQuotaDisk);

			/**
			 * Convert the disk quota in bytes.
			 * @var unknown_type
			 */
			//$conversion = $quotaDisk['0']['Quota']['space'] * 1000000;

			/**
			 * Get UID and GID user.
			 * @var 
			 */
			$conditionUid = array('conditions' => array('User.id' => $this->Auth->user('id')));
			$uidGid = $this->Ftpuser->User->find('all', $conditionUid);

			/**
			 * Save new ftp user.
			 */
			if ($this->Ftpuser->save($this->data)) {

				/**
				 * Save the ftp user name.
				 * Example : $this->data['Ftpuser']['name'].'@'.$this->Auth->user('name') = data@gzw-000002
				 */
				$this->Ftpuser->saveField('name', strtolower($this->data['Ftpuser']['name']) . '@' . $this->Auth->user('name'));

				/**
				 * Save the ftp user homedir.
				 */
				$this->Ftpuser->saveField('homedir', $this->data['Ftpuser']['path'] . $this->Auth->user('name') . $this->data['Ftpuser']['homedir']);
				
				/**
				 * Save the ftp user UID.
				 */
				$uid = $uidGid['0']['User']['uid'];
				$this->Ftpuser->saveField('uid', $uid);
				
				/**
				 * Save the ftp user GID.
				 */
				$gid = $uidGid['0']['User']['gid'];
				$this->Ftpuser->saveField('gid', $gid);
				
				/**
				 * Save the ftp user password.
				 */
				$this->Ftpuser->saveField('password', $md5Password);

				/**
				 * Add the ftp user in the ftp group.
				 * The ftp group is necessary for quota.
				 * Example : gzw-000002 is the group and we add the ftp user data@gzw-000002 in this group.
				 */
				$ftpgroup->saveField('name', $this->Auth->user('name'));
				$ftpgroup->saveField('gid', $gid);
				$ftpgroup->saveField('member', strtolower($this->data['Ftpuser']['name']) . '@' . $this->Auth->user('name'));
				
				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Ftpuser']['name'] . '@' . $this->Auth->user('name') . ' ]</strong> ' . __d('ftp', 'The FTP user has been saved.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);
				
				/**
				 * Create the quota limit for the user (not the ftp user).
				 */
				//$ftplimit->saveField('name', $this->Auth->user('name'));
				//$ftplimit->saveField('bytes_in_avail', $conversion);

				/**
				 * If the new ftp user is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the ftp user is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

	}

	/**
	 * This function edit a ftp user.
	 * The ftp user is seleted by ID.
	 * @param var $id
	 * @return array
	 */
	function edit($id = null) {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The ftp user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('ftp', 'Invalid FTP user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the ftp user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Ftpuser', $id, $this->Auth->user('id'));
		
		if (!empty($this->data)) {

			/**
			 * Save the ftp user after edit.
			 */
			if ($this->Ftpuser->save($this->data)) {

				/**
				 * Save the ftp user name after edit.
				 * Example : $this->data['Ftpuser']['name'] . '@' . $this->Auth->user('name') = data@gzw-000002
				 */
				$this->Ftpuser->saveField('name', strtolower($this->data['Ftpuser']['name']) . '@' . $this->Auth->user('name'));

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Ftpuser']['name'] . '@' . $this->Auth->user('name') . ' ]</strong> ' . __d('ftp', 'The FTP user has been edited.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);
				
				/**
				 * If the ftp user is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the ftp user is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {

			$this->data = $this->Ftpuser->read(null, $id);

			/**
			 * Display just the first part of the ftp user name.
			 * Example : data@gzw-000002 -> data = First part | gzw-000002 = Second part
			 * @var array
			 */
			$nameEdit = $this->data;
			$nameEdit = explode('@', $nameEdit['Ftpuser']['name']);

			/**
			 * Put the ftp user name in "nameEdit".
			 * $nameEdit will be available in the view.
			 */
			$this->set(compact('nameEdit'));

		}

	}

	/**
	 * This function delete a ftp user by ID.
	 * @param var $id
	 * @return array
	 */
	function delete($id = null) {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The ftp user ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('ftp', 'Invalid FTP user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the ftp user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Ftpuser', $id, $this->Auth->user('id'));

		/**
		 * Initialization of "Ftpgroup" model.
		 * This one is necessary for the virtuals ftp users. 
		 * @var string
		 */
		$ftpgroup = ClassRegistry::init('Ftpgroup');

		/**
		 * Select the ftp user name with the ID.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Ftpuser');

		/**
		 * Delete the ftp user.
		 * Redirect the user to index page.
		 */
		if ($this->Ftpuser->delete($id)) {
		
			/**
			 * Delete the ftp user present in the "ftpgroups" table.
			 */
			$ftpgroup->deleteAll(array('Ftpgroup.member' => $data['Ftpuser']['name']));

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'The FTP user has been deleted.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);
				
			
			$this->Session->setFlash(__d('ftp', 'The FTP user has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function edit the ftp user password by ID.
	 * @param var $id
	 * @return array
	 */
	function password($id = null) {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The ftp user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('ftp', 'Invalid FTP user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'password', $id));
		}

		/**
		 * Check if the ftp user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Ftpuser', $id, $this->Auth->user('id'));
		
		if (!empty($this->data)) {
		
			/**
			 * Crypt the ftp password with the ProFTPd crypt.
			 * MD5 + SSL
			 * @var string
			 */
			$password = $this->data['Ftpuser']['password'];
			$md5Password = "{md5}" . base64_encode(pack("H*", md5($password)));

			/**
			 * Save the ftp user password after edit.
			 */
			if ($this->Ftpuser->save($this->data)) {

				/**
				 * Save the ftp user password.
				 */
				$this->Ftpuser->saveField('password', $md5Password);

				/**
				 * Select the ftp user name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Ftpuser');

				/**
				 * Insert the change password action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'The FTP user password has been changed.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);
				
				/**
				 * If the ftp user password is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user password has been changed.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the ftp user password is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user password has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Ftpuser->read(null, $id);
		}

	}

	/**
	 * This function edit the ftp user homedir by ID.
	 * @param var $id
	 * @return array
	 */
	function homedir($id = null) {
		
		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The ftp user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('ftp', 'Invalid FTP user.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Check if the ftp user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Ftpuser', $id, $this->Auth->user('id'));

		if (!empty($this->data)) {

			/**
			 * Check if the home directory of the ftp user is available.
			 * If the home directory is wrong, the user is redirected on homedir page.
			 */
			$fullPath = $this->data['Ftpuser']['path'] . $this->Auth->user('name') . $this->data['Ftpuser']['homedir'];

			if (!is_dir($fullPath)) {
				$this->Session->setFlash(__d('ftp', 'The directory specified does not exist.', true), 'default', array('class' => 'error'));
				$this->redirect(array('action' => 'homedir', $id));
			}

			/**
			 * Save the ftp user homedir after edit.
			 */
			if ($this->Ftpuser->save($this->data)) {

				/**
				 * Save homedir.
				 */
				$this->Ftpuser->saveField('homedir', $fullPath);

				/**
				 * Select the ftp user name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Ftpuser');

				/**
				 * Insert the change homedir action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'The FTP user homedir has been changed.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the ftp user homedir is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user homedir has been changed.', true));
				$this->redirect(array('action' => 'index'));
	
			} else {
				/**
				 * If the ftp user homedir is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user homedir has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Ftpuser->read(null, $id);
		}

	}

	/**
	 * This function allow an administrator to disable a cronjob by ID.
	 * @param var $id
	 * @return array
	 */
	function disable($id = null) {

		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		/**
		 * Check if the ftp user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Ftpuser', $id, $this->Auth->user('id'));

		$ftpuser = $this->Ftpuser->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($ftpuser)) {

			$ftpuser['Ftpuser']['status'] = 1;

			/**
			 * Change the ftp user status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Ftpuser->save($ftpuser)) {
			
				/**
				 * Select the ftp user name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Ftpuser');
			
				/**
				 * Insert the disabled action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'The FTP user has been disabled.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);
				
				$this->Session->setFlash(__d('ftp', 'The FTP user has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

	/**
	 * This function allow an administrator to enable a ftp user by ID.
	 * @param var $id
	 * @return array
	 */
	function enable($id = null) {
		
		/**
		 * Check if ftp module is enabled.
		 * Call "Module" component to check.
		 * 'FTP' is the module name (check in database).
		 */
		$this->Module->check('FTP');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$ftpuser = $this->Ftpuser->read(null, $id);

		/**
		 * Check if the ftp user belongs to the user.
		 * Call "Secureid" component to check.
		 */
		$this->Secureid->check('Ftpuser', $id, $this->Auth->user('id'));

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($ftpuser)) {

			$ftpuser['Ftpuser']['status'] = 0;

			/**
			 * Change the ftp user status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Ftpuser->save($ftpuser)) {

				/**
				 * Select the ftp user name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Ftpuser');

				/**
				 * Insert the enabled action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'The FTP user has been enabled.', true), 'FTP', $_SERVER["REMOTE_ADDR"]);
				
				$this->Session->setFlash(__d('ftp', 'The FTP user has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

	/*************************************************************************
	 * 								ADMIN PART
	 *************************************************************************/

	/**
	 * This function list all ftp users inserts in the table.
	 * @return array
	 */
	function admin_index() {

		$this->Ftpuser->recursive = 0;

		/**
		 * Put all ftp users in "ftpusers".
		 * $ftpusers will be available in the view.
		 */
		$this->set('ftpusers', $this->paginate());

	}

	/**
	 * This function display the status of a ftp user.
	 * @return array
	 */
	function admin_status() {

		$this->Ftpuser->recursive = 0;

		/**
		 * Put all informations about ftp users in "ftpusers".
		 * $ftpusers will be available in the view.
		 */
		$this->set('ftpusers', $this->paginate());

	}

	/**
	 * This function allow an administrator to create a domain for a user.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			/**
			 * Crypt the ftp password with the ProFTPd crypt.
			 * MD5 + SSL
			 * @var string
			 */
			$password = $this->data['Ftpuser']['password'];
			$md5Password = "{md5}" . base64_encode(pack("H*", md5($password)));

			/**
			 * Save new ftp user.
			 */
			$this->Ftpuser->create();
			if ($this->Ftpuser->save($this->data)) {

				/**
				 * Save the ftp user password.
				 */
				$this->Ftpuser->saveField('password', $md5Password);

				/**
				 * Insert the create action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'FTP user added by (' . $this->Auth->user('name') . ').', true) , 'FTP', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the new ftp user is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the ftp user is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Select all users.
		 * @var array
		 */
		$users = $this->Ftpuser->User->find('list');

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allow an administrator to edit a ftp user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The ftp user ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('ftp', 'Invalid FTP user', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Crypt the ftp password with the ProFTPd crypt.
			 * MD5 + SSL
			 * @var string
			 */
			$password = $this->data['Ftpuser']['password'];
			$md5Password = "{md5}" . base64_encode(pack("H*", md5($password)));

			/**
			 * Save the ftp user after edit.
			 */
			if ($this->Ftpuser->save($this->data)) {

				/**
				 * Save the ftp user password.
				 */
				$this->Ftpuser->saveField('password', $md5Password);

				/**
				 * Insert the edit action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $this->data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'FTP user edited by (' . $this->Auth->user('name') . ').', true) , 'FTP', $_SERVER["REMOTE_ADDR"]);

				/**
				 * If the ftp user is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the ftp user is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('ftp', 'The FTP user has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Ftpuser->read(null, $id);
		}

		/**
		 * Select all users
		 * @var array
		 */
		$users = $this->Ftpuser->User->find('list');

		/**
		 * Put all users in "users".
		 * $users will be available in the view.
		 */
		$this->set(compact('users'));

	}

	/**
	 * This function allow an administrator to delete a ftp user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The ftp user ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('ftp', 'Invalid FTP user', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Select the ftp user name with the ID.
		 * @var string
		 */
		$data = $this->Robot->search($id, 'Ftpuser');

		/**
		 * Delete the ftp user.
		 * Redirect the administrator to index page.
		 */
		if ($this->Ftpuser->delete($id)) {

			/**
			 * Insert the delete action in the "logs" table.
			 */
			$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'FTP user deleted by (' . $this->Auth->user('name') . ').', true) , 'FTP', $_SERVER["REMOTE_ADDR"]);

			$this->Session->setFlash(__d('ftp', 'The FTP user has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function allow an administrator to disable a ftp user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$ftpuser = $this->Ftpuser->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($ftpuser)) {
	
			$ftpuser['Ftpuser']['status'] = 1;

			/**
			 * Change the ftp user status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Ftpuser->save($ftpuser)) {

				/**
				 * Select the ftp user name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Ftpuser');

				/**
				 * Insert the disabled action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'FTP user disabled by (' . $this->Auth->user('name') . ').', true) , 'FTP', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('ftp', 'The FTP user has been disabled.', true));
				$this->redirect(array('action' => 'admin_index'));
			}
		}

	}

	/**
	 * This function allow an administrator to enable a ftp user by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$ftpuser = $this->Ftpuser->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($ftpuser)) {
	
			$ftpuser['Ftpuser']['status'] = 0;

			/**
			 * Change the ftp user status.
			 * Redirect the administrator to index page.
			 */
			if ($this->Ftpuser->save($ftpuser)) {

				/**
				 * Select the ftp user name with the ID.
				 * @var string
				 */
				$data = $this->Robot->search($id, 'Ftpuser');

				/**
				 * Insert the enable action in the "logs" table.
				 */
				$this->Logs->insert($this->Auth->user('id'), '<strong>[ ' . $data['Ftpuser']['name'] . ' ]</strong> ' . __d('ftp', 'FTP user enabled by (' . $this->Auth->user('name') . ').', true) , 'FTP', $_SERVER["REMOTE_ADDR"]);

				$this->Session->setFlash(__d('ftp', 'The FTP user has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

}

?>