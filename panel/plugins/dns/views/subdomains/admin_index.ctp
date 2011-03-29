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
		<div class="image"><?php echo $html->image('/dns/img/options/subdomain/add_subdomain_full.png', array('alt' => 'Subdomain')); ?></div>
		<div class="name"><?php __d('domain', 'Subdomain management.'); ?>
			<div class="infos">
				<?php __d('domain', 'This is a list of all the subdomains found on the service.<br />
							Once a deleted subdomain DNS propagation can take several hours to see several days of service providers.'
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
					echo $html->link(__d('domain', 'Add a new subdomain', true), array('controller' => 'subdomains', 'action' => 'add'), array('class' => 'addButton'));
				?>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('domain', 'User_id', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Domain', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Status', true)); ?></th>
						<th class="actions"><?php __d('domain', 'Actions'); ?></th>
					</tr>

					<?php foreach ($subdomains as $subdomain): ?>

					<tr class="<?php echo $status->htmlClass($subdomain['Subdomain']['status']); ?>">
						<td>
							<?php echo $subdomain['User']['name']; ?>
						</td>
						<td>
							<?php echo $html->link($subdomain['Domain']['name'], array('controller' => 'users', 'action' => 'view', $subdomain['Domain']['id'])); ?>
						</td>
						<td>
							<?php echo $html->link($subdomain['Subdomain']['name'], 'http://' . $subdomain['Subdomain']['name']); ?>
						</td>
						<td>
							<?php echo $subdomain['Subdomain']['created']; ?>
						</td>
						<td>
							<?php echo $status->display($subdomain['Subdomain']['status']); ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('domain', 'Edit', true), 'url' => array('action' => 'edit', $subdomain['Subdomain']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('domain', 'Delete', true))),
											array('action' => 'delete', $subdomain['Subdomain']['id']), array('escape' => false), __d('domain', 'Do you really want delete this subdomain ?', true)
										);
							?>
							<?php echo $status->change('subdomains', $subdomain['Subdomain']['status'], $subdomain['Subdomain']['id']); ?>
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
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('domain', 'Edit the subdomain.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('domain', 'Delete the subdomain.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => 'Enabled')) . __d('domain','Enable the subdomain.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => 'Disabled')) . __d('domain','Disable the subdomain.', true); ?></li>
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('domain', 'When a subdomain is deactivated, it appears red in the member part.'); ?>
			</div>

		</div>
	</div>
</div>