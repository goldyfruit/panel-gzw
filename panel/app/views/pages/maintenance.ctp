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
 * Select the maintenance message.
 * @var string
 */
$message = $options['0']['Option']['maintenance_description'];

/**
 * Select the maintenance status.
 * @var string
 */
$status = $options['0']['Option']['maintenance'];

/**
 * Check maintenance mode state, if turn off the user is redirect
 * to the main page when he try to go on this page.
 */
if ($status == 0) {
	header('Location: ' . $html->url('/'));
}
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/maintenance_full.png', array('alt' => 'Maintenance')); ?></div>
		<div class="name"><?php __d('core', 'Maintenance page.'); ?>
			<div class="infos">
				<?php __d('core', 'You see this page because the maintenance mode is enable.<br />
								Currently, you will can\'t use any modules, like : Email, DNS, FTP, etc...');
				?>
			</div>
		</div>
		<div class="main_display">

			<table>
				<tr>
					<td>
						<?php
							/**
							 * Display the maintenance message.
							 */
							echo $message;
						?>
					</td>
				</tr>
			</table>

		<div class="advice">
			<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
			<?php __d('core', 'Maintenance mode doesn\'t affect your websites.'); ?>
		</div>

		</div>
	</div>
</div>