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
		<div class="image"><?php echo $html->image('/mail/img/options/alias/add_alias_full.png', array('alt' => 'Alias')); ?></div>
		<div class="name"><?php __d('mail', 'Mail aliases management.'); ?>
			<div class="infos">
				<?php __d('mail', 'This is a list of all aliases availables on the platform. <br />
								You can do everything you want with these aliases (add, edit, delete, etc...).'); ?>
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
					 echo $html->link(__d('mail', 'Add a new mail alias', true), array('controller' => 'aliases', 'action' => 'add'), array('class' => 'addButton'));
				?>
				<br /><br />
				
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('mail', 'domain_id', true)); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Mail alias', true)); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Mail destination', true)); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('mail', 'Status', true)); ?></th>
						<th class="actions"><?php __d('mail', 'Actions'); ?></th>
					</tr>
					
					<?php foreach ($aliases as $alias):	?>
					
					<tr class="<?php echo $status->htmlClass($alias['Alias']['status']); ?>">
						<td>
							<?php echo $html->link($alias['Domain']['name'], array('controller'=> 'domains', 'action' => 'view', $alias['Domain']['id'])); ?>
						</td>
						<td>
							<?php echo $text->autoLinkEmails($alias['Alias']['name']); ?>
						</td>
						<td>
							<?php echo $text->autoLinkEmails($alias['Alias']['destination']); ?>
						</td>
						<td>
							<?php echo $alias['Alias']['created']; ?>
						</td>
						<td>
							<?php echo $status->display($alias['Alias']['status']); ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('mail', 'Edit', true), 'url' => array('action' => 'edit', $alias['Alias']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('mail', 'Delete', true))),
											array('action' => 'delete', $alias['Alias']['id']), array('escape' => false), __d('mail', 'Do you really want delete this mail alias ?', true)
										);
							?>
							<?php echo $status->change('aliases', $alias['Alias']['status'], $alias['Alias']['id']); ?>
						</td>
					</tr>

					<?php endforeach; ?>

				</table>
			</div>

			<div class="paging">
				<?php echo $paginator->prev('<< ' . __d('core', 'Previous', true), array(), null, array('class' => 'disabled')); ?>
			 | 	<?php echo $paginator->numbers(); ?>
				<?php echo $paginator->next(__d('core','Next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
			</div>

			<div class="legendTitle"><?php echo __d('mail', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __('Edit', true))) . '&#160;' . __d('mail', 'Edit the mail alias.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __('Delete', true))) . '&#160;' . __d('mail', 'Delete the mail alias.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => __('Enabled', true))) . '&#160;' . __d('mail', 'Enable the mail alias.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => __('Disabled', true))) . '&#160;' . __d('mail', 'Disable the mail alias.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>