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
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');

/**
 * Select the panel version in "options" table.
 * @var string
 */
$version = $options['0']['Option']['version'];

/**
 * Put the user ID in $userId
 * @var string
 */
$userId = $session->read('Auth.User.id');

/**
 * Put the profile ID in $profileId
 * @var string
 */
$profileId = $session->read('Auth.User.profile_id');

/**
 * Display the doctype.
 */
echo $html->docType('xhtml-strict');
$displayModule = 'NO';
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
		echo $html->css('gzw.css');
		
		/**
		 * Display a favicon.
		 */
		echo $html->meta('icon', $html->url('/img/favicon.ico'));
	?>
	<title><?php __d('core', 'GoldZone Web - Panel interface'); ?></title>
</head>

<body>
<div id="header">
	<div class="logo"><?php echo $html->image('/img/logo.png', array('alt' => __d('core', 'Logo', true))); ?></div>
	<div class="title"><?php echo __d('core', 'Web hosting management', true) . ' ' . $options['0']['Option']['name']; ?>
		<div class="infos">
			<?php echo __d('core', 'Logged as <strong>', true) . ' ' . $session->read('Auth.User.firstname'); ?></strong><br/>
			<?php __d('core', 'Last connection at '); ?>
		</div>
	</div>
</div>

<div id="colonne_menu">
	<div id="menu">
	<?php
		/**
		 * Check if an administrator is logged.
		 */
		if ($profileId == 1) {

			echo '<ul>';
				echo '<li>' . $html->link(__d('core', 'Panel', true), '/admin/options/index') . '</li>';
				echo '<li>' . $html->link(__d('core', 'Accounts', true), '/admin/users/index') . '</li>';
				echo '<li>' . $html->link(__d('core', 'Profiles', true), '/admin/profiles/index') . '</li>';
				echo '<li>' . $html->link(__d('core', 'Offers', true), '/admin/offers/index') . '</li>';
				echo $this->element('modules');
			echo '</ul>';

		} else {

			echo '<ul>';
				echo '<li>' . $html->link(__d('core', 'My profile', true), '/users/index') . '</li>';
				echo $this->element('modules');
				echo '<li>' . $html->link(__d('core', 'Informations', true), '/infos/summary') . '</li>';
				echo '<li>' . $html->link(__d('core', 'Support', true), '/supports/index') . '</li>';
			echo '</ul>';

		}
	?>
		<div class="disconnect">
			<?php echo $html->link(__d('core', 'Exit', true), '/users/logout'); ?>
		</div>
	
		<div class="version">GoldZone Web, Wow !!</div>
	</div>

	<div id="infos">
		<?php
		echo $html->image('/img/main/time.png', array('alt' => 'Time')) . '&#160;' . date('H\hi'). '<br />';
		echo $html->image('/img/main/date.png', array('alt' => 'Date')) . '&#160;' . date('d/m/Y');
		?>
	</div>
</div>

<?php

/**
 * Check if the weblink toolbar is enabled.
 */
if ($options['0']['Option']['display_weblink'] == 0) {

	echo'<div id="weblink">';
	echo $html->link(__d('core', 'Webmail', true), $options['0']['Option']['link_email'], array('target' => '_blank'));
	echo $html->link(__d('core', 'WebFTP', true), $options['0']['Option']['link_ftp'], array('target' => '_blank'));
	echo $html->link(__d('core', 'PhpMyAdmin', true), $options['0']['Option']['link_sql'], array('target' => '_blank'));
	echo '</div>';

}

/**
 * Display all the views.
 */
echo $content_for_layout;

?>

<div id="footer">
	<?php echo $html->link('Panel GZW ' . $version . '', 'http://www.panel-gzw.com'); ?><br/>
	<?php echo $html->link(__d('core', 'Under GPL license', true), 'http://www.panel-gzw.com/?page_id=94'); ?><br/>
	<?php echo $html->link('GoldZone Web', 'http://www.goldzoneweb.info'); ?><br/>
	2005 - 2011
</div>

</body>
</html>