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
 * Display the crontab options.
 */
echo $this->element('crons');

/**
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');

/**
 * Select the panel path in "options" table.
 * @var string
 */
$panelPath = $options['0']['Option']['path'];
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/crontab/img/options/cron/add_cron_full.png', array('alt' => 'Cron')); ?></div>
		<div class="name"><?php __d('crontab', 'Cron management.'); ?>
			<div class="infos">
				<?php __d('crontab', 'The planning tasks can run at a specific time a PHP script.<br />
								For example for sending a newsletter, remove a users list, valid users, etc...'
							);
				?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Cron" form.
				 */
				echo $form->create('Cron');

				/**
				 * This field is very important for an edit.
				 * He said which cron task is edited.
				 */
				echo $form->input('Cron.id');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Cron.user_id', array('value' => $session->read('Auth.User.id')));

				/**
				 * Create a hidden form field, this one contain the pane path.
				 */
				echo $form->hidden('panelPath', array('value' => $panelPath));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('crontab', 'Cronjob name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Cron.name', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('crontab', 'Path to PHP script'); ?></td>
					<td class="form_part2"><?php echo $form->input('Cron.path', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('crontab', 'Cronjob description'); ?></td>
					<td class="form_part2"><?php echo $form->input('Cron.description', array('label' => false, 'size' => '31')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('crontab', 'Cronjob execution'); ?></td>
					<td class="form_part2"><?php echo $form->input('Cron.type', array('options' => (array(
																						 	'30 * * * *' => __d('crontab', 'Every 30 minutes', true),
																							'59 * * * *' => __d('crontab', 'Every hours', true),
																							'00 00 * * *' => __d('crontab', 'Every days', true),
																							'* * * * 7' => __d('crontab', 'Every weeks', true),
																							'* * 1 * *' => __d('crontab', 'Every months', true))), 'label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('crontab', 'Enable the cronjob'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Cron.notify', array(__d('crontab', 'Yes', true), __d('crontab', 'No', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('crontab', 'Enable cronjob notification'); ?></td>
					<td class="form_part2"><?php echo $form->radio('Cron.status', array(__d('crontab', 'Yes', true), __d('crontab', 'No', true)), array('default' => 'Non', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('crontab', 'Edit the cronjob', true)); ?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('crontab', 'The email notification is recommended for tasks that are rarely executed so that you can be notified of the proper execution thereof.'); ?>
			</div>

		</div>
	</div>
</div>