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
 * Display the crontab options.
 */
echo $this->element('sql');
	
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqldatas/add_sql_database_full.png', array('alt' => 'AddSQLUser')); ?></div>
		<div class="name"><?php __d('sql', 'SQL databases management.'); ?>
			<div class="infos">
				<?php __d('sql', 'A database can store informations other than in a web page. <br />
								Forums, galeries, blogs, wiki, etc... use this kind of method, the database should be named 3 characters minimum.'
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
					 * Display the add sql database link.
					 */
					echo $html->link('Add a SQL database', array('controller' => 'sqldatas', 'action' => 'add'), array('class' => 'addButton'));
				?>
				<span class="quotas">
					<?php __d('sql', 'SQL databases quotas'); ?> : <span class="highlight"><?php echo $quotas;?></span>
				</span>
				<span class="help">
					<?php echo $html->image('/img/main/help.png', array('url' => array('plugin' => NULL, 'controller' => 'infos', 'action' => 'summary'))); ?>
				</span>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort('sqluser_id'); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Type', true)); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('sql', 'Edited', true)); ?></th>
						<th class="actions"><?php __d('sql', 'Actions'); ?></th>
					</tr>

					<?php foreach ($sqldatas as $sqldata): ?>
					<tr>
						<td>
							<?php echo $sqldata['Sqluser']['name']; ?>
						</td>
						<td>
							<?php echo $sqldata['Sqldata']['name']; ?>
						</td>
						<td>
							<?php echo $sqldata['Sqldata']['type']; ?>
						</td>
						<td>
							<?php echo $sqldata['Sqldata']['created']; ?>
						</td>
						<td>
							<?php echo $sqldata['Sqldata']['modified']; ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('sql', 'Edit', true), 'url' => array('action' => 'edit', $sqldata['Sqldata']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('sqm', 'Delete', true))),
											 array('action' => 'delete', $sqldata['Sqldata']['id']), array('escape' => false), __d('sql', 'Do you really want delete this SQL database ?', true)
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
				<?php echo $paginator->next(__d('core', 'Next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
			</div>

			<div class="legendTitle"><?php echo __d('sql', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __('Edit', true))) . '&#160;' . __d('sql', 'Edit the SQL database.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __('Delete', true))) . '&#160;' . __d('sql', 'Delete the SQL database.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>