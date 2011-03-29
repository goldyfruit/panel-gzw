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

class InfosController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Infos';

	/**
	 * The "infos" controller use the "option" model.
	 * @var array
	 */
	var $uses = array('Option');

	/**
	 * Just allow to use a "path" method.
	 * @return true
	 */
	function path() {
	}

	/**
	 * Select all panel options (we just want panel ports).
	 * @return array
	 */
	function ports() {
		/**
		 * Put all informations in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->Option->find('all'));
	}

	/**
	 * Just allow to use a "phpinfo" method.
	 * @return true
	 */
	function phpinfo() {
	}

	/**
	 * Just allow to use a "history" method.
	 * @return true
	 */
	function history() {
	}

	/**
	 * Just allow to use a "summary" method.
	 * @return true
	 */
	function summary() {
		/**
		 * Put all informations in "options".
		 * $options will be available in the view.
		 */
		$this->set('options', $this->Option->find('all'));
	}

}

?>