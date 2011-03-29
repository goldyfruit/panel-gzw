<?php echo $this->element('mails'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/mail/img/options/alias/add_alias_full.png', array('alt' => 'Mailbox')); ?></div>
		<div class="name">Gestion des redirections email.
			<div class="infos">
				Ceci est une liste de toutes les redirections email présentes sur le service.<br/>
				Les redirections email entourées de rouge sont des redirections email qui ont été désactivées par vos soins.
			</div>
		</div>
		<div class="main_display">
			<?php
				echo $form->create('Alias');
				echo $form->input('id');
			?>
			<table>
				<tr>
					<td class="form_part1">Domaine(s) disponible(s)</td>
					<td class="form_part2"><?php echo $form->input('domain_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Nom de la redirection</td>
					<td class="form_part2"><?php echo $form->input('name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1">Adresse email de destination</td>
					<td class="form_part2"><?php echo $form->input('destination', array('label' => false, 'size' => '31')); ?></td>
				</tr>
			</table>		
			<?php echo $form->end('Editer la redirection');?>
		</div>
	</div>
</div>