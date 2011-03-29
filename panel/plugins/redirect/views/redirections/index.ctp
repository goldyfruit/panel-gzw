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
 * Display the domain options.
 */
echo $this->element('domains', array('plugin' => 'dns'));
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/redirect/img/options/redirection/add_redirection_full.png', array('alt' => 'Redirect')); ?></div>
		<div class="name"><?php __d('redirect', 'Redirection management.'); ?>
			<div class="infos">
				<?php __d('redirect', 'To manage your domain from this panel you must change the addresses of name servers to your registrar by those of our current name servers.<br />
							The name servers are listed on the add domain page.');
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
					 * Display add link.
					 */
					echo $html->link(__d('redirect', 'Add a new redirection', true), array('controller' => 'redirections', 'action' => 'add'), array('class' => 'addButton'));
				?>

				<span class="quotas">
					<?php __d('redirect', 'Redirections quotas :'); ?> <span class="highlight"><?php echo $quotas; ?></span>
				</span>

				<br /><br />
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('redirect', 'Domain', true), 'domain_id');?></th>
						<th><?php echo $paginator->sort(__d('redirect', 'Name', true), 'name');?></th>
						<th><?php echo $paginator->sort(__d('redirect', 'Created', true), 'created');?></th>
						<th class="actions"><?php __d('redirect', 'Actions');?></th>
					</tr>

					<?php foreach ($redirections as $redirection): ?>
				
					<tr class="<?php echo $status->htmlClass($redirection['Redirection']['status']); ?>">
						<td><?php echo $redirection['Domain']['name']; ?>&nbsp;</td>
						<td><?php echo $redirection['Redirection']['name']; ?>&nbsp;</td>
						<td><?php echo $redirection['Redirection']['created']; ?>&nbsp;</td>
		
						<td class="actions">
							<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $redirection['Redirection']['id'])); ?>
							<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $redirection['Redirection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $redirection['Redirection']['id'])); ?>
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

			<div class="legendTitle"><?php echo __d('redirect', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('redirect', 'Edit the redirection.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('redirect', 'Delete the redirection.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/green.png', array('alt' => 'Enabled')) . '&#160;' . __d('redirect', 'The redirection is enable.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/red.png', array('alt' => 'Disabled')) . '&#160;' . __d('redirect', 'The redirection is disable.', true); ?></li>
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('redirect', 'The spread of the name servers may take up to 72 hours of access providers in case of problems, please contact an administrator.'); ?>
			</div>

		</div>
	</div>
</div>