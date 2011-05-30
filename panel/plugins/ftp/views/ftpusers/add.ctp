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
 * Display the FTP options.
 */
echo $this->element('ftp');

/**
 * Select the panel path in "options" table.
 */
$path = $options['0']['Option']['path'];

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/ftp/img/options/ftpusers/add_ftp_user_full.png', array('alt' => 'FTP')); ?></div>
		<div class="name"><?php __d('ftp', 'FTP management.'); ?>
			<div class="infos">
				<?php __d('ftp', 'To transfer your site to the server an FTP user to be created. <br />
							If you have multiple users it is possible to assign a directory specific to each.'
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
				 * Create the "FTP" form.
				 */
				echo $form->create('Ftpuser');
				
				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Ftpuser.user_id', array('value' => $session->read('Auth.User.id')));

				/**
				 * Create a hidden form field, this one contain the global path.
				 */
				echo $form->hidden('path', array('value' => $path));
				
				/**
				 * Create a hidden form field, this one contain the name of the user.
				 * Use by the model for duplicate check.
				 */
				echo $form->hidden('gzwId', array('value' => $session->read('Auth.User.name')));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.name', array('label' => false, 'size' => '31', 'after' => '<span class="highlight" style="font-family: monospace;">@' . $session->read('Auth.User.name') . '</span>')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user password'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.password', array('label' => false, 'size' => '31', 'after' => '<span class="highlight">&nbsp;' . __d('ftp', '8 chars minimum', true) . '</span>')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Confirm FTP user password'); ?></td>
					<td class="form_part2"><?php echo $form->input('confirmPassword', array('label' => false, 'size' => '31', 'type' => 'password')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user homedir'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.homedir', array('label' => false, 'value' => '/websites', 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Enable the FTP user'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Ftpuser.status', array(__d('ftp', 'Yes', true), __d('ftp', 'No', true)), array('default' => 'No', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>
			<?php echo $form->end(__d('ftp', 'Create the FTP user', true)); ?>
			
			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('ftp', 'Do not enter special characters, they will not be accepted. Remember to visit the information page.')?>
			</div>
			
		</div>
	</div>
</div>
