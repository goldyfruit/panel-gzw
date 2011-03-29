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
 * Display the user options.
 */
echo $this->element('users');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/user/quotas_full.png', array('alt' => 'Quotas')); ?></div>
		<div class="name"><?php __d('core', 'Display user quotas.'); ?>
			<div class="infos">
				<?php __d('core', 'Quotas can know where you stand with your account (bandwidth, disk space, etc...).<br />	
									A warning email will be issued once the 90% bandwidth achieved.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'SQL users quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasSqluser . '&#160;/&#160;' . $quotasTotal['0']['Quota']['sqluser']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'SQL databases quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasSqldata . '&#160;/&#160;' . $quotasTotal['0']['Quota']['sqldata']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'FTP users quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasFtpuser . '&#160;/&#160;' . $quotasTotal['0']['Quota']['ftpuser']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Mailboxes quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasMailbox . '&#160;/&#160;' . $quotasTotal['0']['Quota']['mailbox']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Aliases quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasAlias . '&#160;/&#160;' . $quotasTotal['0']['Quota']['alias']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Domains quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasDomain . '&#160;/&#160;' . $quotasTotal['0']['Quota']['domain']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Subdomains quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasSubdomain . '&#160;/&#160;' . $quotasTotal['0']['Quota']['subdomain']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Cronjobs quotas'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $quotasCron . '&#160;/&#160;' . $quotasTotal['0']['Quota']['cron']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Disk space'); ?></td>
					<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo (int) ($quotasDisk['0']['Quotasprogress']['diskspace']) . '&#160;Mo&#160;/&#160;' . $quotasTotal['0']['Quota']['diskspace']; ?>&nbsp;Mo</span></td>
				</tr>
			</table>

		<div class="advice">
			<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
			<?php __d('core', 'Large files cause a greater consumption of bandwidth.'); ?>
		</div>

		</div>
	</div>
</div>