<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2009  Gaëtan Trellu - goldyfruit@free.fr

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

class Robot extends AppModel {

	/**
	 * Model Name
	 * @access public
	 * @var string
	 */
	var $name = 'Robot';

	/**
	 * Specify the name of the table that it will be used by this model.
	 * Here we choose to call our table "robot" and not "robots" so 
	 * we must to force the name.
	 * It's not a good practice !
	 * @var string
	 */
	var $useTable = 'robot';
}
?>