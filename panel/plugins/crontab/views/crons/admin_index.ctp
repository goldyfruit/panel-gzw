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
echo $this->element('crons');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/crontab/img/options/cron/add_cron_full.png', array('alt' => 'Cron')); ?></div>
		<div class="name"><?php __d('crontab', 'Cron management.'); ?>
			<div class="infos">
				<?php __d('crontab', 'This is a list of all scheduled tasks on the service.<br />
							Scheduled tasks are surrounded by red scheduled tasks that have been disabled by your care.'
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
					echo $html->link(__d('crontab', 'Add a new cronjob', true), array('controller' => 'crons', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('crontab', 'User', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Path', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Description', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Created', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Type', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Notify', true)); ?></th>
						<th><?php echo $paginator->sort(__d('crontab', 'Status', true)); ?></th>
						<th class="actions"><?php __d('crontab', 'Actions'); ?></th>
					</tr>

					<?php foreach ($crons as $cron): ?>

					<tr class="<?php echo $status->htmlClass($cron['Cron']['status']); ?>">
						<td>
							<?php echo $cron['User']['name']; ?>
						</td>
						<td>
							<?php echo $cron['Cron']['name']; ?>
						</td>
						<td>
							<?php echo $cron['Cron']['path']; ?>
						</td>
						<td>
							<?php echo $cron['Cron']['description']; ?>
						</td>
						<td>
							<?php echo $cron['Cron']['created']; ?>
						</td>
						<td>
							<?php echo $cron['Cron']['type']; ?>
						</td>
						<td>
							<?php echo $status->display($cron['Cron']['notify']); ?>
						</td>
						<td>
							<?php echo $status->display($cron['Cron']['status']); ?>
						</td>
						<td class="actions">
								<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('crontab', 'Edit', true), 'url' => array('action' => 'edit', $cron['Cron']['id']))); ?>
								<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('crontab', 'Delete', true))),
											array('action' => 'delete', $cron['Cron']['id']), array('escape' => false), __d('crontab', 'Do you really want delete this cronjob ?', true));
								?>
								<?php echo $status->change('crons', $cron['Cron']['status'], $cron['Cron']['id']); ?>
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

			<div class="legendTitle"><?php __d('crontab', 'Options description'); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => 'Edit')) . '&#160;' . __d('crontab', 'Edit the cronjob.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('crontab','Delete the cronjob', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => 'Enabled')) . '&#160;' . __d('crontab','Enable the cronjob.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => 'Disabled')) . '&#160;' . __d('crontab','Disable the cronjob.', true); ?></li>
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('crontab', 'The email notification is recommended for tasks that are rarely executed so that you can be notified of the proper execution thereof.'); ?>
			</div>

		</div>
	</div>
</div>