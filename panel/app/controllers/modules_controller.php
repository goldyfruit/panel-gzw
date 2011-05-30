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

class ModulesController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Modules';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Status');

	/**
	 * Display a modules list if the display is not set.
	 * @return array
	 */
	function element() {

		/**
		 * Select all modules where display is not set if this controller is called from a view (by example).
		 * @return array
		 */
		if(isset($this->params['requested'])) {
			$conditionModule = array('conditions' => array('Module.display' => '0'));
			$displayModules = $this->Module->find('all', $conditionModule);
			return $displayModules;
		}

	}

	/**
	 * Select all modules.
	 * @return array
	 */
	function admin_index() {

		$this->Module->recursive = 0;

		/**
		 * Put all modules in "modules".
		 * $modules will be available in the view.
		 */
		$this->set('modules', $this->paginate());

	}

	/**
	 * This function allow an administrator to add a module.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			$this->Module->create();

			/**
			 * Save new module.
			 */
			if ($this->Module->save($this->data)) {

				/**
				 * If the new module is save, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The module options have been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the module is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The module options have not been saved.', true), 'default', array('class' => 'error'));
			}
		}

	}

	/**
	 * This function allow an administrator to edit a module.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The module ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid module.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the module after edit.
			 */
			if ($this->Module->save($this->data)) {

				/**
				 * If the module is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The module options have been edited.', true));
				$this->redirect(array('action' => 'index'));
				
			} else {
				/**
				 * If the module is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The module options have not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Module->read(null, $id);
		}

	}

	/**
	 * This function delete a module by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The module ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('core', 'Invalid module.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Delete the module.
		 * Redirect the user to index page.
		 */
		if ($this->Module->delete($id)) {
			$this->Session->setFlash(__d('core', 'The module has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function disable a module by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$module = $this->Module->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($module)) {

			$module['Module']['status'] = 1;

			/**
			 * Change the module status.
			 * Redirect the user to index page.
			 */
			if ($this->Module->save($module)) {
				$this->Session->setFlash(__d('core', 'The module has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

	/**
	 * This function enable a module by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$module = $this->Module->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($module)) {

			$module['Module']['status'] = 0;

			/**
			 * Change the module status.
			 * Redirect the user to index page.
			 */
			if ($this->Module->save($module)) {
				$this->Session->setFlash(__d('core', 'The module has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

}

?>