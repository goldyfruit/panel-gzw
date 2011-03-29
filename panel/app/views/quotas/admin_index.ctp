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
 * Display the options.
 */
echo $this->element('options');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/quotas_full.png', array('alt' => 'Quotas')); ?></div>
		<div class="name"><?php __d('core', 'Quotas management'); ?>
			<div class="infos">
				<?php __d('core', 'After the offer creation, you will need to manage the quotas like choose how many disk space you want to allow, etc...<br />
						If the offer is deleted, the quotas will about this offer will be deleted too.');
				?>
			</div>
		</div>
		<div class="main_display">
			<div class="admin">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('core', 'offer_id', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'FTP user', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'SQL user', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'SQL database', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Mailbox', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Alias', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Domain', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Subdomain', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Cronjob', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Disk space', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Bandwidth', true)); ?></th>
						<th class="actions"><?php __d('core', 'Actions');?></th>
					</tr>

					<?php foreach ($quotas as $quota): ?>

					<tr>
						<td>
							<?php echo ucfirst($quota['Offer']['name']); ?>
						</td>
						<td>
							<?php echo $quota['Quota']['ftpuser']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['sqluser']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['sqldata']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['mailbox']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['alias']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['domain']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['subdomain']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['cron']; ?>
						</td>
						<td>
							<?php echo $quota['Quota']['diskspace']; ?> Mo
						</td>
						<td>
							<?php echo ucfirst($quota['Quota']['bandwidth']); ?>
						</td>
						<td class="actions">
							<?php
								echo $html->image(
										'/img/options/admin/edit.png',
										array('alt' => __d('core', 'Edit', true),
										'url' => array('action' => 'edit',
										$quota['Quota']['id']))
									);
								
							
								echo $html->link(
												$html->image(
													'/img/options/admin/delete.png',
													array('alt' => __d('core', 'Delete', true))
												),
											 array('action' => 'delete', $quota['Quota']['id']),
											 array('escape' => false),
										__d('core', 'Do you really want delete this quota ?', true)
									);
							?>
						</td>
					</tr>

				<?php endforeach; ?>

				</table>
			</div>

			<div class="paging">
				<?php echo $paginator->prev('<< ' . __d('core', 'Previous', true), array(), null, array('class' => 'disabled')); ?>
			 | 	<?php echo $paginator->numbers();?>
				<?php echo $paginator->next(__d('core', 'Next', true) . ' >>', array(), null, array('class' =>' disabled')); ?>
			</div>

			<div class="legendTitle"><?php __d('core', 'Description of options :'); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'edit', true))) . '&#160;' . __d('core', 'Edit the offer quotas.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'delete', true))) . '&#160;' . __d('core', 'Delete the offer quotas.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>