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

class OffersController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Offers';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form','Status');

	/**
	 * This function display an offers list .
	 * @return array
	 */
	function admin_index() {

		$this->Offer->recursive = 0;

		/**
		 * Put all offers in "offers".
		 * $offers will be available in the view.
		 */
		$this->set('offers', $this->paginate());

	}

	/**
	 * This function allow an administrator to add an offer.
	 * @return array
	 */
	function admin_add() {

		if (!empty($this->data)) {

			$this->Offer->create();

			/**
			 * Save new offer.
			 */
			if ($this->Offer->save($this->data)) {

				/**
				 * If the new offer is saved, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The offer has been saved successfully.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the offer is not saved, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The offer has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

	}

	/**
	 * This function allow an administrator to edit an offer.
	 * @param var $id
	 * @return array
	 */
	function admin_edit($id = null) {

		/**
		 * If $id is not set and $this->data is empty, an error message is displayed.
		 * $this->data = Datas from the form
		 * $id = The offer ID
		 */
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__d('core', 'The offer is invalid.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		if (!empty($this->data)) {

			/**
			 * Save the offer after edit.
			 */
			if ($this->Offer->save($this->data)) {

				/**
				 * If the offer is edited, a success message is displayed.
				 * Redirect to the index page.
				 */
				$this->Session->setFlash(__d('core', 'The offer has been edited successfully.', true));
				$this->redirect(array('action' => 'index'));

			} else {
				/**
				 * If the offer is not edited, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The offer has not been saved.', true), 'default', array('class' => 'error'));
			}
		}

		/**
		 * Display datas.
		 */
		if (empty($this->data)) {
			$this->data = $this->Offer->read(null, $id);
		}

	}

	/**
	 * This function delete an offer by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_delete($id = null) {

		/**
		 * If $id is not set an error message is displayed.
		 * $id = The offer ID
		 */
		if (!$id) {
			$this->Session->setFlash(__d('core', 'The offer is invalid.', true), 'default', array('class' => 'error'));
			$this->redirect(array('action' => 'index'));
		}

		/**
		 * Delete the offer.
		 * Redirect the user to index page.
		 */
		if ($this->Offer->delete($id)) {
			$this->Session->setFlash(__d('core', 'The offer has been deleted successfully.', true));
			$this->redirect(array('action' => 'index'));
		}

	}

	/**
	 * This function disable a offer by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_disable($id = null) {

		$offer = $this->Offer->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($offer)) {

			$offer['Offer']['status'] = 1;

			/**
			 * Change the module status.
			 * Redirect the user to index page.
			 */
			if ($this->Offer->save($offer)) {
				$this->Session->setFlash(__d('core', 'The offer has been disabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

	/**
	 * This function enable a offer by ID.
	 * @param var $id
	 * @return array
	 */
	function admin_enable($id = null) {

		$offer = $this->Offer->read(null, $id);

		/**
		 * Read the "Status" component for more informations.
		 * Dir : controllers/components/status.php
		 */
		if (!empty($offer)) {

			$offer['Offer']['status'] = 0;

			/**
			 * Change the module status.
			 * Redirect the user to index page.
			 */
			if ($this->Offer->save($offer)) {
				$this->Session->setFlash(__d('core', 'The offer has been enabled.', true));
				$this->redirect(array('action' => 'index'));
			}
		}

	}

}

?>