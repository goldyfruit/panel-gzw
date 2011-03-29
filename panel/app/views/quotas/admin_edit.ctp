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
 * Display the offers options.
 */
echo $this->element('offers');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/offer/add_offer_full.png', array('alt' => 'Offer')); ?></div>
		<div class="name"><?php __d('core', 'Quotas management'); ?>
			<div class="infos">
				<?php __d('core', 'After the offer creation, you will need to manage the quotas like choose how many disk space you want to allow, etc...<br />
						If the offer is deleted, the quotas will about this offer will be deleted too.');
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
				 * Create the offer form.
				 */
				echo $form->create('Quota');

				/**
				 * This field is very important for an edit.
				 * He said which quota is edited.
				 */
				echo $form->create('Quota.id');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of FTP user(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.ftpuser', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of SQL user(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.sqluser', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of SQL database(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.sqldata', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of mailbox(es)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.mailbox', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of email redirection(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.alias', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of domain(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.domain', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of subdomain(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.subdomain', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Number of cronjob(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.cron', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Disk space'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.diskspace', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Bandwidth quota'); ?></td>
					<td class="form_part2"><?php echo $form->input('Quota.bandwidth', array('label' => false, 'size' => '31')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Edit the offer quotas', true)); ?>

		</div>
	</div>
</div>