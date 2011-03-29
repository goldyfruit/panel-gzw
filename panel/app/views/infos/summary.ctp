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
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/info/summary_full.png', array('alt' => 'Summary')); ?></div>
		<div class="name"><?php __d('core', 'Summary'); ?>
			<div class="infos">
				<?php __d('core', 'Here you can find a summary about all addresses than you need to know, the FTP, SMPT, IMAP and MYSQL port are availables too.<br />
									These informations can be useful if you want to use a FTP client, Mail client, etc...'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<?php foreach ($options as $option): ?>

			<table>
					<tr>
						<td class="form_part1"><?php __d('core', 'FTP server address'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['ftp_address'] . ' : ' . $option['Option']['port_ftp']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'SQL server address'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['sql_address'] . ' : ' . $option['Option']['port_mysql']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'SMTP server address'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['mx1'] . ' : ' . $option['Option']['port_smtp']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'IMAP server address'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['mx1'] . ' : ' . $option['Option']['port_imap']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'Web server IP address'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['ip_web']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'Primary name server'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['ns1'] . ' : ' . $option['Option']['port_dns']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'Secondary name server'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['ns2'] . ' : ' . $option['Option']['port_dns']; ?></span></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'Webmail link'); ?></td>
						<td class="form_part2"><?php echo $html->link($option['Option']['link_email'], $option['Option']['link_email'], array('target' => '_blank')); ?></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'WebFTP link'); ?></td>
						<td class="form_part2"><?php echo $html->link($option['Option']['link_ftp'], $option['Option']['link_ftp'], array('target' => '_blank')); ?></td>
					</tr>
					<tr>
						<td class="form_part1"><?php __d('core', 'PhpMyAdmin link'); ?></td>
						<td class="form_part2"><?php echo $html->link($option['Option']['link_sql'], $option['Option']['link_sql'], array('target' => '_blank')); ?></td>
					</tr>
			</table>

			<?php endforeach; ?>

		<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('core', 'If you want to know if there is a problem with some services, you can go to the "Ports" page.'); ?>
		</div>

		</div>
	</div>
</div>