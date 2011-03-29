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
		<div class="image"><?php echo $html->image('options/user/password_full.png', array('alt' => 'Password')); ?></div>
		<div class="name"><?php __d('core', 'user_password_management'); ?>
			<div class="infos">
				<?php __d('core', 'user_password_informations'); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				$session->flash();

				/**
				 * Create the "User" form with the "password" action.
				 */
				echo $form->create('User', array('action' => 'password'));

				/**
				 * This field is very important for an edit.
				 * He said which user is edited.
				 */
				echo $form->input('User.id');
			?>

			<p class="warning"><?php __d('core', 'user_password_warning'); ?></p>
			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'new_user_password'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.password', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'confirm_user_password'); ?></td>
					<td class="form_part2"><?php echo $form->input('confirmPassword', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'edit_user_password', true)); ?>

		</div>
	</div>
</div>