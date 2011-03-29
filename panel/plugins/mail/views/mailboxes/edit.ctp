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
		<div class="image"><?php echo $html->image('/mail/img/options/mailbox/add_mailbox_full.png', array('alt' => 'Alias')); ?></div>
		<div class="name"><?php __d('mail', 'Mailboxes management.'); ?>
			<div class="infos">
				<?php __d('mail', 'A courier service is available on this platform. This service has an antivirus and antispam.<br />
									Your mailboxes will be accessible from either a webmail or from clients such as Thunderbird or Outlook.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<p class="warning"><?php __d('mail', 'The mailbox must be written entirely : bob.sponge@domain.tld'); ?></p>

			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Mailbox" form.
				 */
				echo $form->create('Mailbox');

				/**
				 * Create a hidden form field, this one contain the mailbox ID.
				 */
				echo $form->input('Mailbox.id');			
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Available domain(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Mailbox.domain_id', array('options' => $domain, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Mailbox name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Mailbox.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('mail', 'Edit the mailbox', true)); ?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('mail', 'Do not enter special characters, they will not be accepted. Remember to visit the information page.'); ?>
			</div>

		</div>
	</div>
</div>