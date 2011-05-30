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
 * Display the options.
 */
echo $this->element('options');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/config/options_full.png', array('alt' => 'Options')); ?></div>
		<div class="name"><?php __d('core', 'Main panel options'); ?>
			<div class="infos">
				<?php __d('core', 'Here you can manage the main options about the panel configuration.<br />
								You will be able to change many things like email addresses, dns, mail, etc...');
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
					<td class="form_part1"><?php __d('core', 'Panel version'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['version']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Check the panel version'); ?></td>
					<td class="form_part2"><?php echo $status->display($option['Option']['check_version']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Define the platform name'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['name']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Define the panel web address'); ?></td>
					<td class="form_part2"><?php echo $html->link($option['Option']['address'], $option['Option']['address']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Absolute path to the data'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['path']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Default panel language'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['language']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary DNS name'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ns1']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary DNS name'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ns2']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Third DNS name'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ns3']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary DNS IP address'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ipns1']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary DNS IP address'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ipns2']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Third DNS IP address'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ipns3']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary SMTP server'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['mx1']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary SMTP server'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['mx2']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary SMTP IP address'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ipmx1']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary SMTP IP address'); ?></td>
					<td class="form_part2"><?php echo $option['Option']['ipmx2']; ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Path to "named.conf"'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['named_path']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Path to DNS zones'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['zone_path']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'virtualhost_path'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['vhost_path']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'apache_logs_path'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['logs_path']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Administrator email address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['mail_admin']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Robot email address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['mail_robot']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Abuse email address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['mail_abuse']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Business email address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['mail_business']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Support email address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['mail_support']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Postmaster zone address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['mail_postmaster']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Web server IP address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['ip_web']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'FTP server address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['ftp_address']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'PHP-CGI path'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['phpcgi_path']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'SQL server address'); ?></td>
					<td class="form_part2"><?php echo $text->autoLinkEmails($option['Option']['sql_address']); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Allow duplicate email addresses'); ?></td>
					<td class="form_part2"><?php echo $status->display($option['Option']['duplicate_email']); ?></td>
				</tr>

			<?php endforeach; ?>

			</table>

			<br />
			<p><?php echo $html->link(__d('core', 'Edit the panel option', true), array('controller' => 'options', 'action' => 'edit', '1'), array('class' => 'editOptions')); ?></p>

		</div>
	</div>
</div>