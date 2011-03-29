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
 * Display the user options.
 */
echo $this->element('users');

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/crontab/img/options/cron/add_cron_full.png', array('alt' => 'Billing')); ?></div>
		<div class="name"><?php __d('billing', 'Billing management.'); ?>
			<div class="infos">
				<?php __d('billing', 'This is a list of all bills on the service.<br />
								Bills highlighted in red, are bills that have a problem.'
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
					echo $html->link(__d('billing', 'Add a new bill', true), array('controller' => 'bills', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $this->Paginator->sort('id');?></th>
						<th><?php echo $this->Paginator->sort('user_id');?></th>
						<th><?php echo $this->Paginator->sort('product');?></th>
						<th><?php echo $this->Paginator->sort('description');?></th>
						<th><?php echo $this->Paginator->sort('created');?></th>
						<th><?php echo $this->Paginator->sort('price');?></th>
						<th><?php echo $this->Paginator->sort('taxe');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>

					<?php foreach ($bills as $bill): ?>

					<tr>
						<td>
							<?php echo $bill['Bill']['id']; ?>
						</td>
						<td>
							<?php echo$bill['User']['name']; ?>
						</td>
						<td>
							<?php echo $bill['Bill']['product']; ?>
						</td>
						<td>
							<?php echo $bill['Bill']['description']; ?>
						</td>
						<td>
							<?php echo $bill['Bill']['created']; ?>
						</td>
						<td>
							<?php echo $bill['Bill']['price']; ?>&nbsp;&euro;
						</td>
						<td>
							<?php echo $bill['Bill']['taxe']; ?>&nbsp;&euro;
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/view.png', array('alt' => __d('billing', 'View', true), 'url' => array('action' => 'view', $bill['Bill']['id']))); ?>
							<?php echo $html->link(
											$html->image('/img/options/admin/delete.png', array('alt' => __d('billing', 'Delete', true))),
											array('action' => 'delete', $bill['Bill']['id']), array('escape' => false), __d('billing', 'Do you really want delete this bill ?', true));
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

			<div class="legendTitle"><?php __d('billing', 'Options description'); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/view.png', array('alt' => 'View')) . '&#160;' . __d('billing', 'View the bill.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => 'Delete')) . '&#160;' . __d('billing','Delete the bill.', true); ?></li>
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('billing', 'The email notification is recommended for tasks that are rarely executed so that you can be notified of the proper execution thereof.'); ?>
			</div>

		</div>
	</div>
</div>