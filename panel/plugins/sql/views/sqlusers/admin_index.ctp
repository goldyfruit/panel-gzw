<?php echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqlusers/add_sql_user_full.png', array('alt' => 'AddSQLUser')); ?></div>
		<div class="name">Gestion des utilisateurs SQL.
			<div class="infos">
				Ceci est une liste de tous les utilisateurs SQL présents sur le service.<br/>
				Les boîtes aux lettres entourées de rouge sont des redirections email qui ont été désactivées par vos soins.
			</div>
		</div>
		<div class="main_display">
			<div class="admin">
				<?php 
					echo $session->flash();
					echo $html->link('Ajouter un utilisateur SQL', array('controller' => 'sqlusers', 'action'=> 'add'), array('class' => 'addButton'));
				?>
				<br /><br />
				
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort('user_id');?></th>
						<th><?php echo $paginator->sort('name');?></th>
						<th><?php echo $paginator->sort('type');?></th>
						<th><?php echo $paginator->sort('created');?></th>
						<th class="actions"><?php __('Actions');?></th>
					</tr>
					<?php foreach ($sqlusers as $sqluser): ?>
					<tr>
						<td>
							<?php echo $sqluser['User']['name']; ?>
						</td>
						<td>
							<?php echo $sqluser['Sqluser']['name']; ?>
						</td>
						<td>
							<?php echo $sqluser['Sqluser']['type']; ?>
						</td>
						<td>
							<?php echo $sqluser['Sqluser']['created']; ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('sql', 'Edit', true), 'url' => array('action' => 'edit', $sqluser['Sqluser']['id']))); ?>
							<?php echo $html->link($html->image('/img/options/admin/delete.png', array('alt' => __d('sql', 'Delete', true))),
											array('action' => 'delete', $sqluser['Sqluser']['id']), array('escape' => false), __d('sql', 'Do you really want delete this SQL user ?', true)); ?>
							<?php echo $html->image('/img/options/admin/password.png', array('alt' => __d('sql', 'Password', true), 'url' => array('action' => 'password', $sqluser['Sqluser']['id']))); ?>
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
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __('Edit', true))); ?> Editer l'utilisateur SQL.</li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __('Delete', true))); ?> Supprimer l'utilisateur SQL.</li>
					<li><?php echo $html->image('/img/options/admin/password.png', array('alt' => __('Password', true))); ?> Modifier le mot de passe de l'utilisateur SQL.</li>
				</ul>
			</div>
			
		</div>
	</div>
</div>