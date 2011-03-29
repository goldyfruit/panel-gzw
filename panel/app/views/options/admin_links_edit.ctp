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
 * Display the infos options.
 */
echo $this->element('options');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/links_full.png', array('alt' => 'Links')); ?></div>
		<div class="name"><?php __d('core', 'Links management.'); ?>
			<div class="infos">
				<?php __d('core', 'The following links will be display in the weblink toolbar, in the profile part, etc...<br />
								If you disable the weblink, the toolbar on the top will disappear.');
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
				 * Create the option form.
				 */
				echo $form->create('Option');

				/**
				 * This field is very important for an edit.
				 * He said which configuration is edited.
				 */
				echo $form->input('Option.id');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the SQL manager'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_sql', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the WebFTP'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_ftp', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the Webmail'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_email', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the documentation pages'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_doc', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the forum'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_forum', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to IRC chan'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_irc', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to phpinfo() page'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_phpinfo', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the mailing-list'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.link_mailing', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Display the weblink toolbar'); ?></td>
					<td class="form_part2"><?php echo $form->radio('display_weblink', array(__d('core', 'yes', true), __d('core', 'no', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Enable the reset account link'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Option.display_reset_account', array(__d('core', 'yes', true), __d('core', 'no', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Enable the delete account link'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Option.display_delete_account', array(__d('core', 'yes', true), __d('core', 'no', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Edit the links options', true));?>

		</div>
	</div>
</div>