<?php echo $this->element('mails'); ?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/mail/img/options/alias/add_alias_full.png', array('alt' => 'Alias')); ?></div>
		<div class="name"><?php __d('mail', 'Aliases management'); ?>
			<div class="infos">
				<?php __d('mail', 'A mail alias can redirect a mail to another maibox. <br />
								This kind of practice is useful if you want to receive all your mails in the same mailbox.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<p class="warning"><?php __d('mail', 'The email address must be written in full, for example: jordan.spark@domain.tld'); ?></p>
	
			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Alias" form.
				 */
				echo $form->create('Alias');

				/**
				 * Create a hidden form field, this one contain the alias ID.
				 */
				echo $form->input('Alias.id');
			?>
			
			<table>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Available domain(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Alias.domain_id', array('options' => $domain, 'label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Mail alias name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Alias.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Mail address destination'); ?></td>
					<td class="form_part2"><?php echo $form->input('Alias.destination', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('mail', 'Enable the new mail alias'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Alias.status', array(__d('mail', 'Yes', true), __d('mail', 'No', true)), array('default' => 'No', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>	
				
			<?php echo $form->end(__d('mail', 'Edit the mail alias', true)); ?>
			
			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('mail', 'All special characters will be replaced by their equivalents for the "Mail alias name" (é by e, à by a, space by -, etc...).'); ?>
			</div>
			
		</div>
	</div>
</div>