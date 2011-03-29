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

/**
 * Display the infos options.
 */
echo $this->element('options');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/ports_full.png', array('alt' => 'Ports')); ?></div>
		<div class="name"><?php __d('core', 'Ports management.'); ?>
			<div class="infos">
				<?php __d('core', 'ports_informations'); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				$session->flash();

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
					<td class="form_part1"><?php __d('core', 'ftp_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_ftp', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'web_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_web', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'ssl_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_ssl', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'mysql_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_mysql', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'pop_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_pop', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'imap_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_imap', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'smtp_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_smtp', array('label' => false, 'size' => '5')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'dns_state'); ?></td>
					<td class="form_part2"><?php echo $form->input('port_dns', array('label' => false, 'size' => '5')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Edit the ports list', true)); ?>

		</div>
	</div>
</div>