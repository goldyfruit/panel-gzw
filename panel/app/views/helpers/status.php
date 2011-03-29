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

/**
 * Define some variables that can be change later.
 * @var string
 */
define('IMG_ENABLED', 'form/success.png');
define('IMG_DISABLED', 'form/error.png');
define('NAME_LINK_ENABLED', 'options/admin/enabled.png');
define('NAME_LINK_DISABLED', 'options/admin/disabled.png');
define('IMG_ADMIN', 'options/admin/admin.png');
define('IMG_MEMBER', 'options/admin/member.png');

class StatusHelper extends AppHelper {

	/**
	 * Helpers that are used in this helper
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html');

	/**
	 * This function change the state to "enabled" or "disabled". 
	 * @param var $controller
	 * @param var $currentValue
	 * @param var $id
	 * @return string
	 */
	function change($controller, $currentValue, $id) {

		/**
		 * Choose the link url.
		 */
		if ($currentValue == 1) {
			$url = array('controller' => $controller, 'action' => 'enable', $id);
			$out = $this->Html->image(NAME_LINK_ENABLED, array('alt' => __d('core', 'Enabled', true), 'url' => $url));
		} else {
			$url = array('controller' => $controller, 'action' => 'disable', $id);
			$out = $this->Html->image(NAME_LINK_DISABLED, array('alt' => __d('core', 'Disabled', true), 'url' => $url));
		}

		/**
		 * Display the link in the views.
		 */
		return $this->output($out);

	}

	/**
	 * This function display a different picture if the status is "enabled" or "disabled".
	 * @param $currentValue
	 * @return string
	 */ 
	function display($currentValue) {

		/**
		 * Choose the picture.
		 */
		if ($currentValue == 1) {
			$out = $this->Html->image(IMG_DISABLED, array('alt' => __d('core', 'Disabled', true)));
		} else {
			$out = $this->Html->image(IMG_ENABLED, array('alt' => __d('core', 'Enabled', true)));
		}

		/**
		 * Display the picture in the views.
		 */
		return $this->output($out);

	}

	/**
	 * This function define which CSS to use if the status is "enable" or "disable". 
	 * @param $currentValue
	 * @return string
	 */ 
	function htmlClass($currentValue) {

		/**
		 * Choose the CSS class.
		 */
		($currentValue == 1) ? $out = 'disable' : $out = 'enable';

		/**
		 * Display the CSS class in the views.
		 */
		return $this->output($out);

	}
	
	/**
	 * This function define the rank of an user, "admin" or "member".
	 * @param $currentValue
	 * @return string
	 */ 
	function rank($currentValue) {

		/**
		 * Choose the picture.
		 */
		if ($currentValue == 1) {
			$out = $this->Html->image(IMG_ADMIN, array('alt' => __d('core', 'Admin', true)));
		} else {
			$out = $this->Html->image(IMG_MEMBER, array('alt' => __d('core', 'Member', true)));
		}

		/**
		 * Display the picture in the views.
		 */
		return $this->output($out);

	}
	
}

?>