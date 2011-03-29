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
 * Display the profile options.
 */
echo $this->element('profiles');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/profile/add_profile_full.png', array('alt' => 'Profile')); ?></div>
		<div class="name"><?php __d('core', 'Profiles management.'); ?>
			<div class="infos">
				<?php __d('core', 'profiles_informations'); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Profile" form.
				 */
				echo $form->create('Profile');

				/**
				 * This field is very important for an edit.
				 * He said which profile is edited.
				 */
				echo $form->input('Profile.id');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Profile name'); ?></td>
					<td class="form_part2"><?php echo $form->input('name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Edit the profile', true)); ?>

		</div>
	</div>
</div>