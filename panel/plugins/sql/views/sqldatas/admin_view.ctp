<div class="sqldatas view">
<h2><?php  __('Sqldata');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sqldata['Sqldata']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Sqluser'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($sqldata['Sqluser']['name'], array('controller' => 'sqlusers', 'action' => 'view', $sqldata['Sqluser']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($sqldata['User']['name'], array('controller' => 'users', 'action' => 'view', $sqldata['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sqldata['Sqldata']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sqldata['Sqldata']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sqldata['Sqldata']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $sqldata['Sqldata']['type']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit Sqldata', true), array('action' => 'edit', $sqldata['Sqldata']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete Sqldata', true), array('action' => 'delete', $sqldata['Sqldata']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $sqldata['Sqldata']['id'])); ?> </li>
		<li><?php echo $html->link(__('List Sqldatas', true), array('action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Sqldata', true), array('action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Sqlusers', true), array('controller' => 'sqlusers', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New Sqluser', true), array('controller' => 'sqlusers', 'action' => 'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
