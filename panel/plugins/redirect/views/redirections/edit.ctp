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
echo $this->element('domains', array('plugin' => 'dns'));

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/redirect/img/options/redirection/add_redirection_full.png', array('alt' => 'Redirect')); ?></div>
		<div class="name"><?php __d('redirect', 'Redirection management.'); ?>
			<div class="infos">
				<?php __d('redirect', 'To manage your domain from this panel you must change the addresses of name servers to your registrar by those of our current name servers.<br />
							The name servers are listed on the add domain page.');
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
				 * Create the "Redirection" form.
				 */
				echo $form->create('Redirection');

				/**
				 * This field is very important for an edit.
				 * He said which subdomain is edited.
				 */
				echo $form->input('Redirection.id');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Redirection.user_id', array('value' => $session->read('Auth.User.id')));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('redirect', 'Domain(s) name available(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Redirection.domain_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('redirect', 'Redirection name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Redirection.name', array('label' => false, 'size' => '31', 'after' => '<span class="highlight">&nbsp;' . __d('redirect', 'Without "http://"', true) . '</span>')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('redirect', 'Edit the redirection', true));?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('redirect', 'The spread of the name servers may take up to 72 hours of access providers in case of problems, please contact an administrator.'); ?>
			</div>

		</div>
	</div>
</div>

