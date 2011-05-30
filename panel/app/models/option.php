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

class Option extends AppModel {

	/**
	 * Model Name
	 * @access public
	 * @var string
	 */
	var $name = 'Option';

	/**
	 * Display the MySQL version.
	 * @return array
	 */
	function sqlVersion() {

		/**
		 * Select MySQL version if this controller is called from a view (by example).
		 * @return array
		 */
		$version = $this->query('SELECT version() AS v;');

		return $version;

	}

	/**
	 * Display an options list.
	 * @return array
	 */
	function index() {

		/**
		 * Put all options in "options".
		 * $options will be available in the view.
		 */
		$options = $this->find('all');

		return $options;

	}


}

?>