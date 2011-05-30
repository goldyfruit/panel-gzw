
<div class="registers form">
<?php echo $this->Form->create('Register', array('action' => 'add', 'id' => 'saveForm'));?>
	<fieldset>
 		<legend><?php __('Add Register'); ?></legend>
	<?php
		echo $this->Form->input('lastname');
		echo $this->Form->input('firstname');
		echo $this->Form->input('website');
		echo $this->Form->input('mail');
		echo $this->Form->input('offer_id');
		echo $this->Form->input('phone');
		echo $this->Form->input('address');
		echo $this->Form->input('zipcode');
		echo $this->Form->input('city');
		echo $this->Form->input('country');
		echo $this->Form->input('registered');
		echo $this->Form->input('newsletter');
		echo $this->Form->input('idTransaction');
		echo $this->Form->input('hipayAccount');
		echo $this->Form->input('validated');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Registers', true), array('action' => 'index'));?></li>
	</ul>
</div>