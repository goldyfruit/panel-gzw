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
 * Display the offers options.
 */
echo $this->element('offers');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/offer/add_offer_full.png', array('alt' => 'Offer')); ?></div>
		<div class="name"><?php __d('core', 'Offers management.'); ?>
			<div class="infos">
				<?php __d('core', 'offers_informations'); ?>
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
					 * Display the add offer link.
					 */
					echo $html->link(__d('core', 'Add a new offer', true), array('controller' => 'offers', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('core', 'ID', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Name', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Status', true)); ?></th>
						<th><?php __d('core', 'Actions'); ?></th>
					</tr>
	
					<?php foreach ($offers as $offer): ?>
	
					<tr class="<?php echo $status->htmlClass($offer['Offer']['status']); ?>">
						<td>
							<?php echo $offer['Offer']['id']; ?>
						</td>
						<td>
							<?php echo $offer['Offer']['name']; ?>
						</td>
						<td>
							<?php echo $status->display($offer['Offer']['status']); ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/quotas.png', array('alt' => __d('core', 'quotas', true), 'url' => array('controller' => 'quotas', 'action' => 'edit', $offer['Offer']['id']))); ?>
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'Edit', true), 'url' => array('action' => 'edit', $offer['Offer']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'Delete', true))),
											array('action' => 'delete', $offer['Offer']['id']), array('escape' => false), __d('core', 'Do you really want delete this offer ?', true));
							?>
							<?php echo $status->change('offers', $offer['Offer']['status'], $offer['Offer']['id']); ?>
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

			<div class="legendTitle"><?php __d('core', 'Options description'); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/quotas.png', array('alt' => __d('core', 'quotas', true))) . '&#160;' . __d('core', 'Edit the offer quotas.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'edit', true))) . '&#160;' . __d('core', 'Edit the offer.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'delete', true))) . '&#160;' . __d('core', 'Delete the offer', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => __d('core', 'enabled', true))) . '&#160;' . __d('core', 'Enable the offer', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => __d('core', 'disabled', true))) . '&#160;' . __d('core', 'Disable the offer', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>