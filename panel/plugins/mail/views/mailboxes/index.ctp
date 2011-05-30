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
		<div class="image"><?php echo $html->image('/mail/img/options/mailbox/add_mailbox_full.png', array('alt' => 'Mailboxes')); ?></div>
		<div class="name"><?php __d('mail', 'Mailboxes management'); ?>
			<div class="infos">
				<?php __d('mail', 'A courier service is available on this platform. This service has an antivirus and antispam.<br />
									Your mailboxes will be accessible from either a webmail or from clients such as Thunderbird or Outlook.'
						);
				?>
			</div>
		</div>
		<div class="main_display">
			<div class="admin">

				<?php
					/**
					 * Display messages.
					 */
					echo $session->flash();

					/**
					 * Create the new mailbox link.
					 */
					echo $html->link(__d('mail',' Add a mailbox', true), array('controller' => 'mailboxes', 'action' => 'add'), array('class' => 'addButton'));
				?>
				<span class="quotas">
					<?php __d('mail', 'Mailboxes quotas'); ?> : <span class="highlight"><?php echo $quotas; ?></span>
				</span>
				<span class="help">
					<?php echo $html->image('/img/main/help.png', array('url' => array('plugin' => NULL, 'controller' => 'infos', 'action' => 'summary'))); ?>
				</span>
				
				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('mail', 'domain_id', true), 'domain_id'); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Name', true), 'name'); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Created', true), 'created'); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Status', true), 'status'); ?></th>
						<th class="actions"><?php __d('mail', 'Actions'); ?></th>
					</tr>

					<?php foreach ($mailboxes as $mailbox): ?>

					<tr class="<?php echo $status->htmlClass($mailbox['Mailbox']['status']); ?>">
						<td>
							<?php echo$mailbox['Domain']['name']; ?>
						</td>
						<td>
							<?php echo $text->autoLinkEmails($mailbox['Mailbox']['name']); ?>
						</td>
						<td>
							<?php echo $mailbox['Mailbox']['created']; ?>
						</td>
						<td>
							<?php echo $status->display($mailbox['Mailbox']['status']); ?>
						</td>
						<td class="actions">
							<?php
								echo $html->image(
										'/img/options/admin/edit.png',
										array('alt' => __d('mail', 'Edit', true),
										'url' => array('action' => 'edit',
										$mailbox['Mailbox']['id']))
									);

								echo $html->link(
												$html->image(
													'/img/options/admin/delete.png',
													array('alt' => __d('mail', 'Delete', true))
												),
											 array('action' => 'delete', $mailbox['Mailbox']['id']),
											 array('escape' => false),
										__d('mail', 'Do you really want delete this mailbox ?', true)
									);

								echo $html->image(
									'/img/options/admin/password.png',
									array('alt' => __d('mail', 'Mailbox', true),
									'url' => array('action' => 'password', $mailbox['Mailbox']['id'])));

								echo $status->change('mailboxes', $mailbox['Mailbox']['status'], $mailbox['Mailbox']['id']);
							?>
						</td>
					</tr>

					<?php endforeach; ?>

				</table>

			</div>

			<div class="paging">
				<?php echo $paginator->prev('<< ' . __d('core', 'Previous', true), array(), null, array('class' => 'disabled')); ?>
			 | 	<?php echo $paginator->numbers(); ?>
				<?php echo $paginator->next(__d('core', 'Next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
			</div>

			<div class="legendTitle"><?php echo __d('mail', 'Description of options :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('mail', 'Edit the mailbox.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('mail','Delete the mailbox.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/password.png', array('alt' => 'Password')) . '&#160;' . __d('mail','Change the mailbox.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => 'Enabled')) . '&#160;' . __d('mail','Enable the mailbox.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => 'Disabled')) . '&#160;' . __d('mail','Disable the mailbox.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>