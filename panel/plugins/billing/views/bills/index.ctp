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

echo $javascript->link('/billing/js/bill.js');

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/billing/img/options/bill/view_bills_full.jpg', array('alt' => 'Billing')); ?></div>
		<div class="name"><?php __d('billing', 'Billing.'); ?>
			<div class="infos">
				<?php __d('billing', 'The bills are generate every time that you paid something.<br />
								Cases of billing : new payment, renewal, etc...'
						);
				?>
			</div>
		</div>
		<div class="main_display">
			<div class="admin">

				<table cellpadding="0" cellspacing="0">
				<tr>
						<th><?php echo $this->Paginator->sort(__d('billing', 'Bill ID', true)); ?></th>
						<th><?php echo $this->Paginator->sort(__d('billing', 'Product', true)); ?></th>
						<th><?php echo $this->Paginator->sort(__d('billing', 'Description', true)); ?></th>
						<th><?php echo $this->Paginator->sort(__d('billing', 'Created', true)); ?></th>
						<th><?php echo $this->Paginator->sort(__d('billing', 'Price', true)); ?></th>
						<th class="actions"><?php __d('billing', 'Actions'); ?></th>
				</tr>

				<?php foreach ($bills as $bill): ?>

				<tr>
					<td>
						<?php echo $bill['Bill']['id']; ?>
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
						<?php echo $bill['Bill']['taxe']; ?>&nbsp;&euro;
					</td>
					<td class="actions">
						<?php echo $html->link(__('View', true), '#', array('onclick'=> 'open_win('.$bill['Bill']['id'].')')); ?>
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
				</ul>
			</div>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('billing', 'Don\'t print the bill, think green. :)'); ?>
			</div>

		</div>
	</div>
</div>