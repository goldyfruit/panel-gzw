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

class LogsController extends AppController {

	var $name = 'Logs';
	var $helpers = array('Html', 'Form');
	var $components = array('Logs');

	function index() {

		$this->Log->recursive = 0;

		/**
		 * Select all domains who belongs to the user.
		 * Selected by user_id.
		 * @var array
		 */
		$paginate = array(
			'conditions' => array('Log.user_id' => $this->Auth->user('id')),
			'order' => array('Log.id' => 'DESC')
		);
		$this->paginate = $paginate;

		/**
		 * Put all domains in "domains".
		 * $domains will be available in the view.
		 */
		$this->set('logs', $this->paginate());
	}

	function deleteAll($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('core', 'Invalid ID for log', true));
			$this->redirect(array('action' => 'index'));
		}

		$this->Logs->deleteAllLogs($id, $_SERVER["REMOTE_ADDR"]);
		$this->Session->setFlash(__d('core', 'All logs have been deleted.', true));
		$this->redirect(array('action' => 'index'));

	}

	function admin_index() {
		$this->Log->recursive = 0;
		$this->set('logs', $this->paginate());
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__d('core', 'Invalid id for log', true));
			$this->redirect(array('action' => 'index'));
		}
		if ($this->Log->del($id)) {
			$this->Session->setFlash(__d('core', 'Log have been deleted successfully.', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__d('core', 'The Log could not be deleted. Please, try again.', true));
		$this->redirect(array('action' => 'index'));
	}

}

?>