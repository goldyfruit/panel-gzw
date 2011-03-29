<div class="redirections form">
<?php echo $this->Form->create('Redirection');?>
	<fieldset>
 		<legend><?php __('Admin Edit Redirection'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('domain_id');
		echo $this->Form->input('name');
		echo $this->Form->input('destination');
		echo $this->Form->input('status');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Redirection.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Redirection.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Redirections', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Domains', true), array('controller' => 'domains', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Domain', true), array('controller' => 'domains', 'action' => 'add')); ?> </li>
	</ul>
</div>