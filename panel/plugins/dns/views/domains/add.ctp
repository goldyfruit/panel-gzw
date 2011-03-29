<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2011  GoldZone Web - gaetan.trellu@goldzoneweb.info

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

/**
 * Display the domain options.
 */
echo $this->element('domains');

/**
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/dns/img/options/domain/add_domain_full.png', array('alt' => 'Domain')); ?></div>
		<div class="name"><?php __d('domain', 'Domain management.'); ?>
			<div class="infos">
				<?php __d('domain', 'To manage your domain from this panel you must change the addresses of name servers to your registrar by those of our current name servers.<br />
							The name servers are listed on the add domain page.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Domain" form.
				 */
				echo $form->create('Domain');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Domain.user_id', array('value' => $session->read('Auth.User.id')));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Domain name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Domain.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Registrar name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Domain.registrar', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Domain name description'); ?></td>
					<td class="form_part2"><?php echo $form->input('Domain.description', array('label' => false, 'rows' => '8', 'cols' => '40')); ?></td>
				</tr>
				<tr>
					<td><br /></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Primary name server'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $options['0']['Option']['ns1'] . '&#160;&#160;&#160;&#160;' . $options['0']['Option']['ipns1']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Secondary name server'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $options['0']['Option']['ns2'] . '&#160;&#160;&#160;&#160;' . $options['0']['Option']['ipns2']; ?></span></td>
				</tr>
			</table>

			<?php echo $form->end(__d('domain', 'Create the domain', true)); ?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('domain', 'The spread of the name servers may take up to 72 hours of access providers in case of problems, please contact an administrator.'); ?>
			</div>

		</div>
	</div>
</div>