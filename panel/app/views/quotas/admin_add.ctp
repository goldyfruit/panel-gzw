<div class="quotas form">
<?php echo $form->create('Quota');?>
	<fieldset>
 		<legend><?php __('Add Quota');?></legend>
	<?php
		echo $form->input('offer_id');
		echo $form->input('ftpuser');
		echo $form->input('sqluser');
		echo $form->input('sqldata');
		echo $form->input('mailbox');
		echo $form->input('alias');
		echo $form->input('domain');
		echo $form->input('subdomain');
		echo $form->input('cron');
		echo $form->input('diskspace');
		echo $form->input('bandwidth');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Quotas', true), array('action' => 'index'));?></li>
		<li><?php echo $html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>
