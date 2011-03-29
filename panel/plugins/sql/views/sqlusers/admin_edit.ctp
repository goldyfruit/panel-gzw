<?php echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqlusers/add_sql_user_full.png', array('alt' => 'FTP')); ?></div>
		<div class="name">Gestion des utilisateurs SQL.
			<div class="infos">
				Ceci est une liste de tous les utilisateurs SQL présents sur le service.<br/>
				Les boîtes aux lettres entourées de rouge sont des redirections email qui ont été désactivées par vos soins.
			</div>
		</div>
		<div class="main_display">
			<?php
				echo $form->create('Sqluser');
				echo $form->input('Sqluser.id');
			?>
			<table>
				<tr>
					<td class="form_part1">Utilisateur(s) disponible(s)</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.user_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Nom de l'utilisateur SQL</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.name', array('label' => false, 'size' => '31', 'value' => @$nameEdit['0'])); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Type(s) de moteur(s) SQL</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.type', array('options' => array(
																								'mysql' => 'MySQL',
																								'postgres' => 'PostgreSQL'), 'label' => false)); ?></td>
				</tr>
			</table>
			<?php echo $form->end('Editer l\'utilisateur SQL'); ?>
		</div>
	</div>
</div>
