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

class OptionsController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Options';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Text', 'Status');

	/**
	 * Display an options list.
	 * @return array
	 */
	function index() {

		/**
		 * Put all options in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->Option->find('all'));

		/**
		 * Select all options if this controller is called from a view (by example).
		 * @return array
		 */
		if(isset($this->params['requested'])) {
			$options = $this->Option->find('all');
			return $options;
		}

	}

	/**
	 * Display the MySQL version.
	 * @return array
	 */
	function sqlVersion() {

		/**
		 * Select MySQL version if this controller is called from a view (by example).
		 * @return array
		 */
		if(isset($this->params['requested'])) {
			$version = $this->Option->query('SELECT version() AS v;');
			return $version;
		}

	}

	/**
	 * This function display an options list.
	 * @return array
	 */
	function admin_index() {

		$this->Option->recursive = 0;

		/**
		 * Put all options in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->paginate());

	}

	/**
	 * This function display an options list for links() method.
	 * @return array
	 */
	function admin_links() {

		$this->Module->recursive = 0;

		/**
		 * Put all options in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->paginate());
	}

	/**
	 * This function display an options list for ports() method.
	 * @return array
	 */
	function admin_ports() {

		$this->Module->recursive = 0;

		/**
		 * Put all options in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->paginate());
	}

	/**
	 * This function display an options list for maintenance() method.
	 * @return array
	 */
	function admin_maintenance() {

		$this->Module->recursive = 0;

		/**
		 * Put all options in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->paginate());
	}

	/**
	 * This function allow an administrator to edit the panel options.
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The options ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid options.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the options after edit.
			 */
			if ($this->Option->save($this->data)) {

				/**
				 * If the options is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The options have been edited successfully.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the options is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The options have not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Option->read(null, $id);
		}

	}

	/**
	 * This function allow an administrator to edit the panel ports.
	 * @return array
	 */
	function admin_ports_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The options ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid options.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'ports'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the ports after edit.
			 */
			if ($this->Option->save($this->data)) {

				/**
				 * If the ports is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The ports have been edited.', true));
				$this->redirect(array('action' => 'ports'));

			} else {
				/**
				 * If the ports is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The ports have not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Option->read(null, $id);
		}

	}

	/**
	 * This function allow an administrator to edit the panel links.
	 * @return array
	 */
	function admin_links_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The options ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid options.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'links'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the links after edit.
			 */
			if ($this->Option->save($this->data)) {

				/**
				 * If the links is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The links have been edited.', true));
				$this->redirect(array('action' => 'links'));

			} else {
				/**
				 * If the links is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The links have not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Option->read(null, $id);
		}

	}

	/**
	 * This function allow an administrator to edit the panel maintenance.
	 * @return array
	 */
	function admin_maintenance_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The options ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid options.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'maintenance'));
		}

		/**
		 * Save the maintenance after edit.
		 */
		if (!empty($this->data)) {

			if ($this->Option->save($this->data)) {
				/**
				 * If the maintenance is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The maintenance mode has been changed.', true));
				$this->redirect(array('action' => 'maintenance'));
				
			} else {
				/**
				 * If the maintenance is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The maintenance mode has not been changed.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Option->read(null, $id);
		}

	}

}

?>