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
		<div class="image"><?php echo $html->image('options/config/modules_full.png', array('alt' => 'Modules')); ?></div>
		<div class="name"><?php __d('core', 'Modules management.'); ?>
			<div class="infos">
				<?php __d('core', 'A module is a part of the panel who allow you to manage DNS, Email, or what you want. :)<br />
							You can find some modules on internet or try to develop one by your self.');
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
				 * Create the "Module" form.
				 */
				echo $form->create('Module');

				/**
				 * This field is very important for an edit.
				 * He said which module is edited.
				 */
				echo $form->input('Module.id');
			?>

			<p class="warning"><?php __d('core', 'Be very careful with the changes you make in the modules !'); ?></p>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Module name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.name', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Module name translation'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.translateName', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the module'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.link', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Module version'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.version', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Element where will appear'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.element', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Controller used by the module'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.controller', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Action used by the module'); ?></td>
					<td class="form_part2"><?php echo $form->input('Module.action', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Display in the main menu'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Module.display', array('&nbsp' . __d('core', 'No', true), '&nbsp' . __d('core', 'Yes', true)), array('default' => 'No', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Enable the module'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Module.status', array('&nbsp' . __d('core', 'Yes', true), '&nbsp' . __d('core', 'No', true)), array('default' => 'Yes', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Edit the module settings', true));?>

		</div>
	</div>
</div>