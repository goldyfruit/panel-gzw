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
echo $this->element('domains');

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/dns/img/options/domain/add_domain_full.png', array('alt' => 'Domain')); ?></div>
		<div class="name"><?php __d('domain', 'Domain management.'); ?>
			<div class="infos">
				<?php __d('domain', 'This is a list of all the domains found on the service.<br />
							Once a deleted domain DNS propagation can take several hours to see several days of service providers.'
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
					 * Display add link.
					 */
					echo $html->link(__d('domain', 'Add a new domain', true), array('controller' => 'domains', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<br /><br />
				
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('domain', 'user_id', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Registrar', true)); ?></th>
						<th class="actions"><?php __d('domain', 'Actions'); ?></th>
					</tr>
					
					<?php foreach ($domains as $domain): ?>
					
					<tr class="<?php echo $status->htmlClass($domain['Domain']['status']); ?>">
						<td>
							<?php echo $html->link($domain['User']['name'], array('controller'=> 'users', 'action'=>'view', $domain['User']['id'])); ?>
						</td>
						<td>
							<?php echo $domain['Domain']['name']; ?>
						</td>
						<td>
							<?php echo $domain['Domain']['created']; ?>
						</td>
						<td>
							<?php echo $domain['Domain']['registrar']; ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/view.png', array('alt' => __d('domain', 'View', true), 'url' => array('action' => 'view', $domain['Domain']['id']))); ?>
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('domain', 'Edit', true), 'url' => array('action' => 'edit', $domain['Domain']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('domain', 'Delete', true))),
											array('action' => 'delete', $domain['Domain']['id']), array('escape' => false), __d('domain', 'Do you really want delete this domain ?', true)
										);
							?>
							<?php echo $status->change('domains', $domain['Domain']['status'], $domain['Domain']['id']); ?>
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

			<div class="legendTitle"><?php echo __d('domain', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/view.png', array('alt' => 'View')) . '&#160;' . __d('domain', 'View the domain name.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('domain', 'Edit the domain name.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('domain', 'Delete the domain name.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => 'Enabled')) . __d('domain','Enable the domain name.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => 'Disabled')) . __d('domain','Disable the domain name.', true); ?></li>
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('domain', 'When a domain is deactivated, it appears red in the member part.'); ?>
			</div>

		</div>
	</div>
</div>