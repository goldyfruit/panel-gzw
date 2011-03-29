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
				 * This field is very important for an edit.
				 * He said which ftp is edited.
				 */
				echo $form->input('Ftpuser.id');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Ftpuser.user_id', array('value' => $session->read('Auth.User.id')));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.name', array('label' => false, 'size' => '31', 'value' => @$nameEdit['0'], 'after' => '<span class="highlight" style="font-family: monospace;">@' . $session->read('Auth.User.name') . '</span>')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('ftp', 'Edit the FTP user', true)); ?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('ftp', 'All special characters will be replaced by their equivalents for the "FTP user name" (é by e, à by a, space by -, etc...).')?>
			</div>

		</div>
	</div>
</div>