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
echo $this->element('infos');

/**
 * This address is necessary to check the service state.
 * @var string
 */
$address = '127.0.0.1';
$sqlAddress = 'stan.gzw.local';
$ftpAddress = 'kyle.gzw.local';
$dnsAddress = 'ns1.goldzoneweb.info';

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/info/ports_full.png', array('alt' => 'Ports')); ?></div>
		<div class="name"><?php echo __d('core', 'Ports and services status.'); ?> 
			<div class="infos">
				<?php __d('core', 'Some softwares require some informations about the ports used by the server.<br />
										The main is for FTP clients, mail clients.'
							);
				?> 
			</div>
		</div>
		<div class="main_display">

		<?php foreach ($options as $option): ?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'FTP server status'); ?></td>
					<?php
						if(@fsockopen($ftpAddress, $option['Option']['port_ftp'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_ftp'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_ftp'] . '</td>';
						}
					?>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Web server status'); ?></td>
					<?php
						if(fsockopen($address, $option['Option']['port_web'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_web'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_web'] . '</td>';
						}
					?>
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
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'MySQL server status'); ?></td>
					<?php
						if(@fsockopen($sqlAddress, $option['Option']['port_mysql'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_mysql'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_mysql'] . '</td>';
						}
					?>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'POP server status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_pop'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_pop'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_pop'] . '</td>';
						}
					?>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'IMAP server status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_imap'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_imap']. '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_imap']. '</td>';
						}
					?>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'SMTP server status'); ?></td>
					<?php
						if(@fsockopen($address, $option['Option']['port_smtp'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_smtp'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_smtp'] . '</td>';
						}
					?>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'DNS server status'); ?></td>
					<?php
						if(@fsockopen($dnsAddress, $option['Option']['port_dns'])) {
							echo '<td class="portEnabled">' . $option['Option']['port_dns'] . '</td>';
						} else {
							echo '<td class="portDisabled">' . $option['Option']['port_dns'] . '</td>';
						}
					?>
				</tr>

			<?php endforeach; ?>

			</table>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('core', 'If any of the services is red it means that a malfunction is in progress, so please contact an administrator to find out why.'); ?>
			</div>

		</div>
	</div>
</div>