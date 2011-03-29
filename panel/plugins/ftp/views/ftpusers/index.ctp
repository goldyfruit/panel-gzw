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
 * Display the ftp options.
 */
echo $this->element('ftp');

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/ftp/img/options/ftpusers/add_ftp_user_full.png', array('alt' => 'FTP')); ?></div>
		<div class="name"><?php __d('ftp', 'FTP user management.'); ?>
			<div class="infos">
				<?php __d('ftp', 'To transfer your site to the server an FTP user to be created. <br />
								If you have multiple users it is possible to assign a directory specific to each.'
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
					 * Create the new ftp user link.
					 */
					echo $html->link(__d('ftp', 'Add a FTP user', true), array('plugin' => 'ftp', 'controller' => 'ftpusers', 'action' => 'add'), array('class' => 'addButton'));
				?>

				<span class="quotas">
					<?php __d('ftp', 'FTP users quotas'); ?> : <span class="highlight"><?php echo $quotas; ?></span>
				</span>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('ftp', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('ftp', 'Homedir', true)); ?></th>
						<th><?php echo $paginator->sort(__d('ftp', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('ftp', 'Modified', true)); ?></th>
						<th><?php echo $paginator->sort(__d('ftp', 'Status', true)); ?></th>
						<th class="actions"><?php __d('ftp', 'Actions'); ?></th>
					</tr>

					<?php foreach ($ftpusers as $ftpuser): ?>

					<tr class="<?php echo $status->htmlClass($ftpuser['Ftpuser']['status']); ?>">
						<td>
							<?php echo $ftpuser['Ftpuser']['name']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['homedir']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['created']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['modified']; ?>
						</td>
						<td>
							<?php echo $status->display($ftpuser['Ftpuser']['status']); ?>
						</td>

						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('ftp', 'Edit', true), 'url' => array('action' => 'edit', $ftpuser['Ftpuser']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('ftp', 'Delete', true))),
											 array('action' => 'delete', $ftpuser['Ftpuser']['id']), array('escape' => false), __d('ftp', 'Do you really want delete this FTP user ?', true)
										);
							?>
							<?php echo $html->image('/img/options/admin/password.png', array('alt' => __d('ftp', 'Password', true), 'url' => array('action' => 'password', $ftpuser['Ftpuser']['id']))); ?>
							<?php echo $html->image('/img/options/admin/homedir.png', array('alt' => __d('ftp', 'Homedir', true), 'url' => array('action' => 'homedir', $ftpuser['Ftpuser']['id']))); ?>
							<?php echo $status->change('ftpusers', $ftpuser['Ftpuser']['status'], $ftpuser['Ftpuser']['id']); ?>
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

			<div class="legendTitle"><?php echo __d('ftp', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('ftp', 'Edit the FTP user.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('ftp','Delete the FTP user.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/password.png', array('alt' => 'Password')) . '&#160;' . __d('ftp','Change the FTP user password.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/homedir.png', array('alt' => 'Homedir')) . '&#160;' . __d('ftp','Change the FTP user homedir.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => 'Enabled')) . '&#160;' . __d('ftp','Enable the FTP user.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => 'Disabled')) . '&#160;' . __d('ftp','Disable the FTP user.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>	