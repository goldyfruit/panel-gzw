<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2009  Gaëtan Trellu - goldyfruit@free.fr

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
 * Display the user options.
 */
echo $this->element('users');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/user/profile_full.png', array('alt' => 'Profile')); ?></div>
		<div class="name"><?php __d('core', 'users_management'); ?>
			<div class="infos">
				<?php __d('core', 'users_informations'); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				$session->flash();

				/**
				 * Create the "User" form.
				 */
				echo $form->create('User');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'kind_of_user'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.profile_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_lastname'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.lastname', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_firstname'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.firstname', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_email_address'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.email', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_name'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_status'); ?></td>
					<td class="form_part2"><?php echo $form->radio('User.status', array(__d('core', 'enable', true), __d('core', 'disable', true)), array('default' => 'enable', 'legend' => false, 'separator' => '&#160;&#160;')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_offer'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.offer_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_address'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.address', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_zipcode'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.zipcode', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_city'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.city', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_country'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.country', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_phone_number'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.telephone', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'user_language'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.language', array('options' => array('FR' => 'French', 'EN' => 'English'), 'label' => false)); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'add_user', true)); ?>

		</div>
	</div>
</div>