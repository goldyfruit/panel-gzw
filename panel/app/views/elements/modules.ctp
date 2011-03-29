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

/*
 * This script is called in the default layout.
 * 
 * The function of this one is to list the modules
 * and activate or desactivate the modules
 * 
 * Can see the difference between an administrator
 * and a normal user, if it's an administrator the
 * link will be different
 */

/**
 * Request the index methode in the module controller
 * @var string
 */
$modules = $this->requestAction('modules/index');

/**
 * If the resquest is set then we display the name of each modules enabled
 */
if ($modules) {
	
	foreach ($modules as $module) {
		/**
		 * Create three variables who contains the module query
		 * @var string
		 * @var string
		 * @var string
		 */
		$name = $module['Module']['translateName'];
		$link = $module['Module']['link'];
		$element = $module['Module']['element'];
	
		/*
		 * Check if the module is set and if display in main menu is set.
		 */
		if ($module['Module']['status'] == 0 && $module['Module']['display'] == 1) {
		
			/**
			 * If the user is an administrator then the "/admin/" word
			 * is added to the link
			 */
			if ($session->read('Auth.User.profile_id') == 1) {
				echo '<li>' . $html->link($name, '/admin/' . $link) . '</li>';
			} else {
				echo '<li>' . $html->link($name, $link) . '</li>';
			}
		}
		
	}
}

?>