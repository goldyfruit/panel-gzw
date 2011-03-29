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

				/**
				 * Create the option form.
				 */
				echo $form->create('Option');

				/**
				 * This field is very important for an edit.
				 * He said which configuration is edited.
				 */
				echo $form->input('Option.id');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Maintenance mode status'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Option.maintenance', array('&nbsp' . __d('core', 'Disable', true), '&nbsp' . __d('core', 'Enable', true)), array('default' => 'Disable', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Message of the maintenance page'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.maintenance_description', array('label' => false)); ?></td>
				</tr>
			</table>

			<br />

			<?php echo $form->end(__d('core', 'Edit the maintenance mode options', true)); ?>

		</div>
	</div>
</div>