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
class BillsController extends BillingAppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Bills';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Text', 'Status', 'Javascript');

	/**
	 * Components that are used in this controller
	 * @access public
	 * @var array
	 */
	var $components = array('Module', 'Maintenance', 'Secureid', 'Logs');

	/*************************************************************************
	 * 								MEMBER PART
	 *************************************************************************/

	/**
	 * This function return a bills list who belongs to the user.
	 * @return array
	 */
	function index() {

		/**
		 * Check if BILLING module is enabled.
		 * Call "Module" component to check.
		 * 'CRON' is the module name (check in database).
		 */
		$this->Module->check('BILLING');

		/**
		 * Check if maintenance is on.
		 * Call the "Maintenance" component to check.
		 */
		$this->Maintenance->check();

		$this->Cron->recursive = 0;

		/**
		 * Select all bills who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array('conditions' => array('Bill.user_id' => $this->Auth->user('id')));
		$this->paginate = $paginate;

		/**
		 * Put all bills in "bills".
		 * $bills will be available in the view.
		 */
		$this->set('bills', $this->paginate());
	}

	function view($id = null) {

		$this->layout = FALSE;

		if (!$id) {
			$this->Session->setFlash(__('Invalid bill', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bill', $this->Bill->read(null, $id));
	}


	function admin_index() {
		$this->Bill->recursive = 0;
		$this->set('bills', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid bill', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('bill', $this->Bill->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Bill->create();
			if ($this->Bill->save($this->data)) {
				$this->Session->setFlash(__('The bill has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The bill could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Bill->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for bill', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Bill->delete($id)) {
			$this->Session->setFlash(__('Bill deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Bill was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>