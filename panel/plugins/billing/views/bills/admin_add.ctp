<div class="bills form">
<?php echo $this->Form->create('Bill');?>
	<fieldset>
 		<legend><?php __('Admin Add Bill'); ?></legend>
	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('product');
		echo $this->Form->input('description');
		echo $this->Form->input('price');
		echo $this->Form->input('taxe');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Bills', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>