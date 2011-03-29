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
		<div class="image"><?php echo $html->image('/dns/img/options//subdomain/add_subdomain_full.png', array('alt' => 'Subdomain')); ?></div>
		<div class="name"><?php __d('domain', 'Subdomain management.'); ?>
			<div class="infos">
				<?php __d('domain', 'The subdomains are very useful to split a site into several distinct sections. <br />
							A domain name is needed to perform this manipulation.'
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
					echo $html->link(__d('domain', 'Add a new subdomain', true), array('controller' => 'subdomains', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<span class="quotas">
					<?php __d('domain', 'Subdomain quotas :'); ?> <span class="highlight"><?php echo $quotas; ?></span>
				</span>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('domain', 'Domain', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('domain', 'Created', true)); ?></th>
						<th class="actions"><?php __d('domain', 'Actions'); ?></th>
					</tr>

					<?php foreach ($subdomains as $subdomain): ?>

					<tr class="<?php echo $status->htmlClass($subdomain['Subdomain']['status']); ?>">
						<td>
							<?php echo $subdomain['Domain']['name']; ?>
						</td>
						<td>
							<?php echo $html->link($subdomain['Subdomain']['name'], 'http://'.$subdomain['Subdomain']['name']); ?>
						</td>
						<td>
							<?php echo $subdomain['Subdomain']['created']; ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __('Edit', true), 'url' => array('action' => 'edit', $subdomain['Subdomain']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('domain', 'Delete', true))),
											 array('action' => 'delete', $subdomain['Subdomain']['id']), array('escape' => false), __d('domain', 'Do you really want delete this subdomain ?', true)
										);
							?>
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
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('domain', 'Edit the subdomain name.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('domain', 'Delete the subdomain name.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/green.png', array('alt' => 'Enabled')) . '&#160;' . __d('domain', 'The subdomain name is enable.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/red.png', array('alt' => 'Disabled')) . '&#160;' . __d('domain', 'The subdomain name is disable.', true); ?></li>
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('domain', 'The spread of the name servers may take up to 72 hours of access providers in case of problems, please contact an administrator.'); ?>
			</div>

		</div>
	</div>
</div>