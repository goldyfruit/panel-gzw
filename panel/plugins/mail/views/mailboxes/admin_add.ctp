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
 * Display the mail options.
 */
echo $this->element('mails');
 
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/mail/img/options/mailbox/add_mailbox_full.png', array('alt' => 'Mailbox')); ?></div>
		<div class="name"><?php __d('mail', 'Mailboxes management.'); ?>
			<div class="infos">
				<?php __d('mail', 'This is a list of all mailboxes availables on the platform. <br />
								You can do everything you want with these mailboxes (add, edit, delete, etc...).'); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Mailbox" form.
				 */
				echo $form->create('Mailbox');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Domain(s) available(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('domain_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Mailbox name'); ?></td>
					<td class="form_part2"><?php echo $form->input('name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Mailbox password'); ?></td>
					<td class="form_part2"><?php echo $form->input('Mailbox.password', array('label' => false, 'size' => '31', 'type' => 'password')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Confirm mailbox password'); ?></td>
					<td class="form_part2"><?php echo $form->input('Mailbox.confirmPassword', array('label' => false, 'size' => '31', 'type' => 'password')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Enable the mailbox'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Mailbox.status', array('Oui', 'Non'), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>
			<?php echo $form->end(__d('mail', 'Create the mailbox', true)); ?>
		</div>
	</div>
</div>