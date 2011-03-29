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
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');

/**
 * Select the panel path in "options" table.
 * @var string
 */
$path = $options['0']['Option']['path'];
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/ftp/img/options/ftpusers/homedir_full.png', array('alt' => 'Homedir')); ?></div>
		<div class="name"><?php __d('ftp', 'Change the FTP user homedir.'); ?>
			<div class="infos">
				<?php __d('ftp', 'It is possible to change the homedir for each of your FTP users.<br />
								By doing so users have a different homedir of your own and have no access to your data.'
						);
				?>
			</div>
		</div>
		<div class="main_display">
			
			<p class="warning"><?php __d('ftp', 'To point the user in the root directory let (/) in the "FTP user homedir".'); ?></p>
			
			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();
			
				/**
				 * Create the "FTP homedir" form.
				 */
				echo $form->create('Ftpuser', array('action' => 'homedir'));

				/**
				 * This field is very important for an edit.
				 * He said which ftp is edited.
				 */
				echo $form->input('Ftpuser.id');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Ftpuser.user_id', array('value' => $session->read('Auth.User.id')));

				/**
				 * Create a hidden form field, this one contain the pane path.
				 */
				echo $form->hidden('path', array('value' => $path));
			?>
			
			<table>
				<tr>
					<td class="form_part1"><?php __d('ftp', 'FTP user homedir'); ?></td>
					<td class="form_part2"><?php echo $form->input('Ftpuser.homedir', array('label' => false, 'size' => '31')); ?></td>
				</tr>

			</table>
			
			<?php echo $form->end(__d('ftp', 'Change the homedir', true)); ?>
			
			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				 <?php __d('ftp', 'The destination folder must exist before confirming the change.'); ?>
			</div>
			
		</div>
	</div>
</div>
