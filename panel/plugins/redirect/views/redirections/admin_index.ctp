<div class="redirections index">
	<h2><?php __('Redirections');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('domain_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('destination');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('status');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($redirections as $redirection):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $redirection['Redirection']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($redirection['User']['name'], array('controller' => 'users', 'action' => 'view', $redirection['User']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($redirection['Domain']['name'], array('controller' => 'domains', 'action' => 'view', $redirection['Domain']['id'])); ?>
		</td>
		<td><?php echo $redirection['Redirection']['name']; ?>&nbsp;</td>
		<td><?php echo $redirection['Redirection']['destination']; ?>&nbsp;</td>
		<td><?php echo $redirection['Redirection']['created']; ?>&nbsp;</td>
		<td><?php echo $redirection['Redirection']['status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $redirection['Redirection']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $redirection['Redirection']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $redirection['Redirection']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $redirection['Redirection']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Redirection', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Domains', true), array('controller' => 'domains', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Domain', true), array('controller' => 'domains', 'action' => 'add')); ?> </li>
	</ul>
</div>