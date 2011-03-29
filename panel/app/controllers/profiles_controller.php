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

class ProfilesController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Profiles';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form');

	/**
	 * This function display a profiles list.
	 * @return array
	 */
	function admin_index() {

		$this->Profile->recursive = 0;

		/**
		 * Put all profiles in "profiles".
		 * $profiles will be available in the view.
		 */
		$this->set('profiles', $this->paginate());

	}

	/**
	 * This function allow an administrator to add a profile.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			$this->Profile->create();

			/**
			 * Save new profile.
			 */
			if ($this->Profile->save($this->data)) {

				/**
				 * If the new profile is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The profile has been saved.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the profile is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'the profile has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

	}

	/**
	 * This function allow an administrator to edit a profile.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The profile ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'Invalid profile.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the profile after edit.
			 */
			if ($this->Profile->save($this->data)) {

				/**
				 * If the profile is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The profile has been edited.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the profile is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core','The profile has not been edited.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Profile->read(null, $id);
		}

	}

	/**
	 * This function delete a profile by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The profile ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('core', 'Invalid profile.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Delete the profile.
		 * Redirect the user to index page.
		 */
		if ($this->Profile->delete($id)) {
			$this->Session->setFlash(__d('core', 'The profile has been deleted.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

}

?>