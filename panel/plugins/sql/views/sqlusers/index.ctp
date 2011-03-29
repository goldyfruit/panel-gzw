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
 * Display the sql options.
 */
echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqlusers/add_sql_user_full.png', array('alt' => 'AddSQLUser')); ?></div>
		<div class="name"><?php __d('sql', 'SQL user management.'); ?>
			<div class="infos">
				<?php __d('sql', 'To take advantage of MySQL support a user must be created.<br />
									The following informations will be requested during the installation of a forum, a blog, etc... for example.'
						);
				?>
			</div>
		</div>
		<div class="main_display">
			<div class="admin">

				<?php
					/**
					 * Display the messages.
					 */
					echo $session->flash();

					/**
					 * Display the add sql user link.
					 */
					echo $html->link(__d('sql', 'Add new SQL user', true), array('controller' => 'sqlusers', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<span class="quotas">
					<?php __d('sql', 'SQL users quotas'); ?> : <span class="highlight"><?php echo $quotas; ?></span>
				</span>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('sql', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Database type', true)); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Edited', true)); ?></th>
						<th class="actions"><?php __d('sql', 'Actions'); ?></th>
					</tr>

					<?php foreach ($sqlusers as $sqluser): ?>

					<tr>
						<td>
							<?php echo $sqluser['Sqluser']['name']; ?>
						</td>
						<td>
							<?php echo $sqluser['Sqluser']['type']; ?>
						</td>
						<td>
							<?php echo $sqluser['Sqluser']['created']; ?>
						</td>
						<td>
							<?php echo $sqluser['Sqluser']['modified']; ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('sql', 'Edit', true), 'url' => array('action' => 'edit', $sqluser['Sqluser']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('sqm', 'Delete', true))),
											 array('action' => 'delete', $sqluser['Sqluser']['id']), array('escape' => false), __d('sql', 'Do you really want delete this SQL user ?', true)
										);
							?>
							<?php echo $html->image('/img/options/admin/password.png', array('alt' => __d('sql', 'Password', true), 'url' => array('action' => 'password', $sqluser['Sqluser']['id']))); ?>
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

			<div class="legendTitle"><?php echo __d('sql', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'Edit', true))) . '&#160;' . __d('sql', 'Edit the SQL user.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'Delete', true))) . '&#160;' . __d('sql', 'Delete the SQL user.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/password.png', array('alt' => __d('core', 'assword', true))) . '&#160;' . __d('sql', 'Change the SQL user password.', true); ?></li>
				</ul>
			</div>
			
		</div>
	</div>
</div>