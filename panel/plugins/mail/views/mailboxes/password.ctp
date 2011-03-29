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
		<div class="image"><?php echo $html->image('/mail/img/options/mailbox/password_full.png', array('alt' => 'Password')); ?></div>
		<div class="name"><?php __d('mail', 'Change mailbox password.'); ?>
			<div class="infos">
				<?php __d('mail', 'This change will affect only the password of your mailbox.<br />
								A good password is a password with numbers, uppercase, special characters, etc. ...'
				); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Use the "password" action from the "mailboxes" controller.
				 */
				echo $form->create('Mailbox', array('action' => 'password'));

				/**
				 * Create a hidden form field, this one contain the mailbox ID.
				 */
				echo $form->input('Mailbox.id');
			?>

			<p class="warning"><?php __d('mail', 'Never give your password to an another person.'); ?></p>

			<table>
				<tr>
					<td class="form_part1"><?php __d('mail', 'New mailbox password'); ?></td>
					<td class="form_part2"><?php echo $form->input('Mailbox.password', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31', 'after' => '<span class="highlight">&nbsp;' . __d('mail', '8 chars minimum', true) . '</span>')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Confirm mailbox password'); ?></td>
					<td class="form_part2"><?php echo $form->input('confirmPassword', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31')); ?></td>
				</tr>
			</table>
			<?php echo $form->end(__d('mail', 'Change the mailbox password', true));?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('mail', 'Make sure caps lock is not enabled. ;)'); ?>
			</div>

		</div>
	</div>
</div>