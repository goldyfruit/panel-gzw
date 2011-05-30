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
 * Display the doctype.
 */
echo $html->docType('xhtml-strict');
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		/**
		 * Display the charset.
		 */
		echo $html->charset();
		
		/**
		 * Select the CCS sheet.
		 */
		echo $html->css('register.css');
		
		/**
		 * Display a favicon.
		 */
		echo $html->meta('icon', $html->url('/img/favicon.ico'));
	?>
	<title><?php __d('core', 'GoldZone Web - Register'); ?></title>
</head>
<body>
        <?php echo $content_for_layout; ?>
</body>
</html>