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
 * Display the infos options.
 */
echo $this->element('options');

/**
 * This address is necessary to check the service state.
 * @var string
 */
$address = '127.0.0.1';
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/ports_full.png', array('alt' => 'Ports')); ?></div>
		<div class="name"><?php __d('core', 'Ports management.'); ?>
			<div class="infos">
				<?php __d('core', 'ports_informations'); ?>
			</div>
		</div>

		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				$session->flash();

				foreach ($options as $option):
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'FTP status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_ftp'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_ftp'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_ftp'] . '</td>';
						}
					?>
					<td class="form_part2"><?php __d('core', 'FTP status'); ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'Web status'); ?></td>
					<?php
						if(fsockopen($address, $option['Option']['port_web'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_web'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_web'] . '</td>';
						}
					?>
					<td class="form_part2"><?php __d('core', 'Web status'); ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'SSL status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_ssl'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_ssl'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_ssl'] . '</td>';
						}
					?>
					<td class="form_part2"><?php __d('core', 'SSL status'); ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'MySQL status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_mysql'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_mysql'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_mysql'] . '</td>';
						}
					?>
					<td class="form_part2"><?php __d('core', 'MySQL status'); ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'POP status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_pop'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_pop'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_pop'] . '</td>';
						}
					?>
					<td class="form_part2"><?php __d('core', 'POP status'); ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'IMAP status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_imap'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_imap']. '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_imap']. '</td>';
						}
					?>
					<td class="form_part2"><?php __d('core', 'IMAP status'); ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'SMTP status (primary)'); ?></td>
					<?php
						if(@fsockopen($option['Option']['ipmx1'], $option['Option']['port_smtp'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_smtp'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_smtp'] . '</td>';
						}
					?>
					<td class="form_part2"><?php echo $option['Option']['ipmx1']; ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'SMTP status (secondary)'); ?></td>
					<?php
						if(@fsockopen($option['Option']['ipmx2'], $option['Option']['port_smtp'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_smtp'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_smtp'] . '</td>';
						}
					?>
					<td class="form_part2"><?php echo $option['Option']['ipmx2']; ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'DNS status (primary)'); ?></td>
					<?php
						if(@fsockopen($option['Option']['ipns1'], $option['Option']['port_dns'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_dns'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_dns'] . '</td>';
						}
					?>
					<td class="form_part2"><?php echo $option['Option']['ipns1']; ?></td>
				</tr>
				
				<tr>
					<td class="form_part1"><?php __d('core', 'DNS status (secondary)'); ?></td>
					<?php
						if(@fsockopen($option['Option']['ipns2'], $option['Option']['port_dns'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_dns'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_dns'] . '</td>';
						}
					?>
					<td class="form_part2"><?php echo $option['Option']['ipns2']; ?></td>
				</tr>

			<?php endforeach; ?>

			</table>

			<br />
			<p><?php echo $html->link(__d('core', 'Edit the ports list', true), array('controller' => 'options', 'action' => 'ports_edit', '1'), array('class' => 'editOptions')); ?></p>

		</div>
	</div>
</div>
