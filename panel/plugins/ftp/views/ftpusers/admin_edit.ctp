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
 * Display the ftp options.
 */
echo $this->element('ftp');

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/ftp/img/options/ftpusers/add_ftp_user_full.png', array('alt' => 'FTP')); ?></div>
		<div class="name"><?php __d('domain', 'Domain management.'); ?>
			<div class="infos">
				<?php __d('domain', 'This is a list of all the domains found on the service.<br />
							Once a deleted domain DNS propagation can take several hours to see several days of service providers.'
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
				 * This field is very important for an edit.
				 * He said which ftp user is edited.
				 */
				echo $form->input('Ftpuser.id');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Users list'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.user_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user password'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.password', array('label' => false, 'type' => 'password', 'value' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Confirm FTP user password'); ?></td>
					<td class="form_part2"><?php echo $form->input('confirmPassword', array('label' => false, 'type' => 'password', 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Member UID'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.uid', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Member GID'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.gid', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user homedir'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.homedir', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user shell'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.shell', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'Enable the FTP user'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Ftpuser.status', array(__d('ftp', 'Yes', true), __d('ftp', 'No', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('ftp', 'Edit the FTP user', true)); ?>

		</div>
	</div>
</div>
