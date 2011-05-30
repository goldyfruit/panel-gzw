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

			<p class="warning"><?php __d('core', 'Don\'t forgot to put the slash "/" at the end of each path.'); ?></p>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Panel version'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.version', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Check the panel version'); ?></td>
					<td class="form_part2"><?php echo $form->radio('check_version', array(__d('core', 'yes', true), __d('core', 'no', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Define the platform name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Define the panel web address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.address', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Absolute path to the data'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Default panel language'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.language', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary DNS name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ns1', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary DNS name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ns2', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Third DNS name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ns3', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary DNS IP address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ipns1', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary DNS IP address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ipns2', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Third DNS IP address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ipns3', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary SMTP server'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mx1', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary SMTP server'); ?>2</td>
					<td class="form_part2"><?php echo $form->input('Option.mx2', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Primary SMTP IP address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ipmx1', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Secondary SMTP IP address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ipmx2', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Path to "named.conf"'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.named_path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Path to DNS zones'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.zone_path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'virtualhost_path'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.vhost_path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'apache_logs_path'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.logs_path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Administrator email address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mail_admin', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Robot email address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mail_robot', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Abuse email address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mail_abuse', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Business email address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mail_business', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Support email address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mail_support', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Postmaster zone address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.mail_postmaster', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Web server IP address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ip_web', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'FTP server address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.ftp_address', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'PHP-CGI path'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.phpcgi_path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'SQL server address'); ?></td>
					<td class="form_part2"><?php echo $form->input('Option.sql_address', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Allow duplicate email addresses'); ?></td>
					<td class="form_part2"><?php echo $form->radio('duplicate_email', array(__d('core', 'Yes', true), __d('core', 'No', true)), array('default' => 'No', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>

			</table>

			<?php echo $form->end(__d('core', 'Edit panel options', true));?>

		</div>
	</div>
</div>