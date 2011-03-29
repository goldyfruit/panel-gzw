<?php echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqlusers/add_sql_user_full.png', array('alt' => 'FTP')); ?></div>
		<div class="name">Gestion des utilisateurs SQL.
			<div class="infos">
				Ceci est une liste de toutes les boîtes aux lettres présentes sur le service.<br/>
				Les boîtes aux lettres entourées de rouge sont des redirections email qui ont été désactivées par vos soins.
			</div>
		</div>
		<div class="main_display">
			<?php echo $form->create('Sqluser');?>
			<table>
				<tr>
					<td class="form_part1">Utilisateur(s) disponible(s)</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.user_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Nom du nouvel utilisateur SQL</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Mot de passe du nouvel utilisateur</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.password', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Confirmer le mot de passe</td>
					<td class="form_part2"><?php echo $form->input('confirmPassword', array('label' => false, 'size' => '31', 'type' => 'password')); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Type(s) de moteur(s) SQL</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.type', array('options' => array(
																								'mysql' => 'MySQL',
																								'postgres' => 'PostgreSQL'), 'label' => false)); ?></td>
				</tr>
			</table>
			<?php echo $form->end('Créer l\'utilisateur SQL'); ?>
		</div>
	</div>
</div>
