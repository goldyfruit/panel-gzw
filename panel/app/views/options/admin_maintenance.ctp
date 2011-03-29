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
 * Display the infos options.
 */
echo $this->element('options');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/maintenance_full.png', array('alt' => 'Maintenance')); ?></div>
		<div class="name"><?php __d('core', 'Maintenance management.'); ?>
			<div class="infos">
				<?php __d('core', 'The maintenance mode will allow the connection for each member but they will can\'t use the modules.<br />
								The maintenance page will be display on the main page when the maintenance will be on.');
				?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				echo $session->flash();

				foreach ($options as $option):
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Maintenance mode status'); ?></td>
					<td class="form_part2"><?php echo $status->display($option['Option']['maintenance']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Message of the maintenance page'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['maintenance_description']; ?></td>
				</tr>

			<?php endforeach; ?>

			</table>

			<br />
			<p><?php echo $html->link(__d('core', 'Edit the maintenance mode options', true), array('controller' => 'options', 'action' => 'maintenance_edit', '1'), array('class' => 'editOptions')); ?></p>

		</div>
	</div>
</div>