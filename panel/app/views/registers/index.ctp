<div class="registers index">
	<h2><?php __('Registers');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('lastname');?></th>
			<th><?php echo $this->Paginator->sort('firstname');?></th>
			<th><?php echo $this->Paginator->sort('website');?></th>
			<th><?php echo $this->Paginator->sort('mail');?></th>
			<th><?php echo $this->Paginator->sort('offers');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('zipcode');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('country');?></th>
			<th><?php echo $this->Paginator->sort('registered');?></th>
			<th><?php echo $this->Paginator->sort('newsletter');?></th>
			<th><?php echo $this->Paginator->sort('idTransaction');?></th>
			<th><?php echo $this->Paginator->sort('hipayAccount');?></th>
			<th><?php echo $this->Paginator->sort('validated');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($registers as $register):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $register['Register']['id']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['lastname']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['firstname']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['website']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['mail']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['offers']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['phone']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['address']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['zipcode']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['city']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['country']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['registered']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['newsletter']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['idTransaction']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['hipayAccount']; ?>&nbsp;</td>
		<td><?php echo $register['Register']['validated']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $register['Register']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $register['Register']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $register['Register']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $register['Register']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Register', true), array('action' => 'add')); ?></li>
	</ul>
</div>