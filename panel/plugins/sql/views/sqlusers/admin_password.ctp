<?php echo $this->element('sql'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqlusers/password_full.png', array('alt' => 'Password')); ?></div>
		<div class="name">Modification du mot de passe SQL.
			<div class="infos">
				Cette modification affecte seulement le mot de passe d'accès SQL de l'utilisateur.<br />
				Un bon mot de passe est un mot de passe contenant des lettres, des chiffres, des majuscules, etc...
			</div>
		</div>
		<div class="main_display">
			<?php
				$session->flash();
				echo $form->create('Sqluser', array('action' => 'password'));
				echo $form->input('Sqluser.id');
			?>
			<p class="warning">Le mot de passe sera chiffré à l'aide du grain de sel <i>(salt)</i> de CakePHP.</p>
			<table>
				<tr>
					<td class="form_part1">Nouveau mot de passe</td>
					<td class="form_part2"><?php echo $form->input('Sqluser.password', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Confirmer nouveau mot de passe</td>
					<td class="form_part2"><?php echo $form->input('confirmPassword', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31')); ?></td>
				</tr>
			</table>		
			<?php echo $form->end('Editer le mot de passe de l\'utilisateur SQL');?>
		</div>
	</div>
</div>
