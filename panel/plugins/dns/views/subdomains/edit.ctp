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

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/dns/img/options//subdomain/add_subdomain_full.png', array('alt' => 'Subdomain')); ?></div>
		<div class="name"><?php __d('domain', 'Subdomain management.'); ?>
			<div class="infos">
				<?php __d('domain', 'The subdomains are very useful to split a site into several distinct sections. <br />
							A domain name is needed to perform this manipulation.'
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
				 * Create the "Subdomain" form.
				 */
				echo $form->create('Subdomain');

				/**
				 * This field is very important for an edit.
				 * He said which subdomain is edited.
				 */
				echo $form->input('Subdomain.id');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Subdomain.user_id', array('value' => $session->read('Auth.User.id')));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Domain(s) name available(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Subdomain.domain_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('domain', 'Subdomain name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Subdomain.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('domain', 'Edit the subdomain', true));?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('domain', 'The spread of the name servers may take up to 72 hours of access providers in case of problems, please contact an administrator.'); ?>
			</div>

		</div>
	</div>
</div>

