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

				foreach ($options as $option):
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the SQL manager'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_sql'], $option['Option']['link_sql']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the WebFTP'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_ftp'], $option['Option']['link_ftp']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the Webmail'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_email'], $option['Option']['link_email']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the documentation pages'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_doc'], $option['Option']['link_doc']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the forum'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_forum'], $option['Option']['link_forum']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to IRC chan'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_irc'], $option['Option']['link_irc']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to phpinfo() page'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_phpinfo'], $option['Option']['link_phpinfo']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Link to the mailing-list'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['link_mailing'], $option['Option']['link_mailing']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Display the weblink toolbar'); ?></td>
					<td class="form_part2"><?php echo $status->display($option['Option']['display_weblink']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Enable the reset account link'); ?></td>
					<td class="form_part2"><?php echo $status->display($option['Option']['display_reset_account']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Enable the delete account link'); ?></td>
					<td class="form_part2"><?php echo $status->display($option['Option']['display_delete_account']); ?></td>
				</tr>

			<?php endforeach; ?>

			</table>

			<br />
			<p><?php echo $html->link(__d('core', 'Edit the links options', true), array('controller' => 'options', 'action' => 'links_edit', '1'), array('class' => 'editOptions')); ?></p>

		</div>
	</div>
</div>