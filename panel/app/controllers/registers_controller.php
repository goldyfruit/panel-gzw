<?php
class RegistersController extends AppController {

	var $name = 'Registers';

	function index() {
		$this->Register->recursive = 0;
		$this->set('registers', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid register', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('register', $this->Register->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Register->create();
			if ($this->Register->save($this->data)) {
				$this->Session->setFlash(__('The register has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The register could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid register', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Register->save($this->data)) {
				$this->Session->setFlash(__('The register has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The register could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Register->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for register', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Register->delete($id)) {
			$this->Session->setFlash(__('Register deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Register was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	function admin_index() {
		$this->Register->recursive = 0;
		$this->set('registers', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid register', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('register', $this->Register->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Register->create();
			if ($this->Register->save($this->data)) {
				$this->Session->setFlash(__('The register has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The register could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid register', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Register->save($this->data)) {
				$this->Session->setFlash(__('The register has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The register could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Register->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for register', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Register->delete($id)) {
			$this->Session->setFlash(__('Register deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Register was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>