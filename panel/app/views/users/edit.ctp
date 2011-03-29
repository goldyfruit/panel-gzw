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
 * Display the user options.
 */
echo $this->element('users');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/user/profile_full.png', array('alt' => 'Profile')); ?></div>
		<div class="name"><?php __d('core', 'Profile management.'); ?>
			<div class="infos">
				<?php __d('core', 'The following informations must be valid, they allow us to contact you by mail or other in case of major problems with your account.<br />
									They will under no circumstances be used for advertising purposes.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				echo $session->flash();

				/**
				 * Create the "User" form with the "edit" action.
				 */
				echo $form->create('User');

				/**
				 * This field is very important for an edit.
				 * He said which user is edited.
				 */
				echo $form->input('User.id');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Lastname'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.lastname', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Firstname'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.firstname', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Mail address'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.email', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Postale address'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.address', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Zipcode'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.zipcode', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'City'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.city', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Country'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.country', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Phone number'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.telephone', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Language'); ?></td>
					<td class="form_part2"><?php echo $form->input('User.language', array(
																						'options' => array(
																										'eng' => 'English', 
																										'fre' => 'French'),
																										'label' => false)); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Edit my profile', true)); ?>

		</div>
	</div>
</div>