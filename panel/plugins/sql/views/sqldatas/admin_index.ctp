<?php echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqldatas/add_sql_database_full.png', array('alt' => 'AddSQLUser')); ?></div>
		<div class="name">Gestion des bases de données SQL.
			<div class="infos">
				Ceci est une liste de toutes les bases de données présentes sur le service.<br/>
				Les bases de données entourées de rouge sont des bases de données qui ont été désactivées par vos soins.
			</div>
		</div>
		<div class="main_display">
			<div class="admin">
				<?php 
					echo $session->flash();
					echo $html->link('Ajouter une base de données SQL', array('controller' => 'sqldatas', 'action'=> 'add'), array('class' => 'addButton'));
				?>
				<br /><br />
				
				<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $paginator->sort('user_id');?></th>
					<th><?php echo $paginator->sort('sqluser_id');?></th>
					<th><?php echo $paginator->sort('name');?></th>
					<th><?php echo $paginator->sort('type');?></th>
					<th><?php echo $paginator->sort('created');?></th>
					<th><?php echo $paginator->sort('modified');?></th>
					<th class="actions"><?php __('Actions');?></th>
				</tr>
				
				<?php foreach ($sqldatas as $sqldata): ?>
				
				<tr>
					<td>
						<?php echo $sqldata['User']['name']; ?>
					</td>
					<td>
						<?php echo $sqldata['Sqluser']['name']; ?>
					</td>
					<td>
						<?php echo $sqldata['Sqldata']['name']; ?>
					</td>
					<td>
						<?php echo $sqldata['Sqldata']['type']; ?>
					</td>
					<td>
						<?php echo $sqldata['Sqldata']['created']; ?>
					</td>
					<td>
						<?php echo $sqldata['Sqldata']['modified']; ?>
					</td>
					<td class="actions">
						<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('sql', 'Edit', true), 'url' => array('action' => 'edit', $sqldata['Sqldata']['id']))); ?>
						<?php echo $html->link($html->image('/img/options/admin/delete.png', array('alt' => __d('sql', 'Delete', true))),
											array('action' => 'delete', $sqldata['Sqldata']['id']), array('escape' => false), __d('sql', 'Do you really want delete this database ?', true)); ?>
						</td>
				</tr>
				<?php endforeach; ?>
				</table>
			</div>
			
			<div class="paging">
				<?php echo $paginator->prev('<< '.__('Précédent', true), array(), null, array('class'=>'disabled'));?>
				 | 	<?php echo $paginator->numbers();?>
				<?php echo $paginator->next(__('Suivant', true).' >>', array(), null, array('class'=>'disabled'));?>
			</div>
			
			<div class="legendTitle">Légende des options :</div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __('Edit', true))); ?> Editer la base de données SQL.</li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __('Delete', true))); ?> Supprimer la base de données SQL.</li>
				</ul>
			</div>
			
		</div>
	</div>
</div>
