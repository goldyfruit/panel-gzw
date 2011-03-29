<?php echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqldatas/add_sql_database_full.png', array('alt' => 'AddSQLUser')); ?></div>
		<div class="name">Gestion des bases de données SQL.
			<div class="infos">
				Ceci est une liste de toutes les bases de données présentes sur le service.<br/>
				Les bases de données entourées de rouge sont des bases de données qui ont été désactivées.
			</div>
		</div>
		<div class="main_display">
			<?php
				echo $form->create('Sqldata');
				echo $form->create('Sqldata.id');
			?>
			
			<table>
				<tr>
					<td class="form_part1">Utilisateur(s) SQL disponible(s)</td>
					<td class="form_part2"><?php echo $form->input('Sqldata.sqluser_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Utilisateur(s) disponible(s)</td>
					<td class="form_part2"><?php echo $form->input('Sqldata.user_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Nom de la nouvelle base de données</td>
					<td class="form_part2"><?php echo $form->input('Sqldata.name', array('label' => false, 'size' => '31', 'value' => @$nameEdit['0'])); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Type(s) de moteur(s) SQL</td>
					<td class="form_part2"><?php echo $form->input('Sqldata.type', array('options' => array(
																								'mysql' => 'MySQL',
																								'postgres' => 'PostgreSQL'), 'label' => false)); ?></td>
				</tr>
			</table>
			<?php echo $form->end('Editer la base de données SQL'); ?>
		</div>
	</div>
</div>
