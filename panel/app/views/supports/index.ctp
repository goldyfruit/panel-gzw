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
 * Display the support options.
 */
echo $this->element('supports');

/**
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');

/**
 * Find all panel emails (admin, robot, abuse, business and support).
 * @var string
 */
$adminEmail = $options['0']['Option']['mail_admin'];
$abuseEmail = $options['0']['Option']['mail_abuse'];
$businessEmail = $options['0']['Option']['mail_business'];
$supportEmail = $options['0']['Option']['mail_support'];
$emailUser	 = $session->read('Auth.User.email');

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/support/contact_full.png', array('alt' => 'Ticket')); ?></div>
		<div class="name"><?php __d('core', 'Support'); ?>
			<div class="infos">
				<?php __d('core', 'The mail support is to answer some of your questions.<br />
								To get an answer from us please write your message properly otherwise it will remain unanswered.'
						);
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
				 * Create the form without connection in database.
				 */
				echo $form->create(null, array('action' => 'index'));

				/**
				 * Hidden field with the user name of the connected user.
				 * It will be used in the email.
				 */
				echo $form->hidden('name', array('value' => $session->read('Auth.User.name')));

				/**
				 * Hidden field with the email address of the robot.
				 * "robot" is the email sender.
				 */
				echo $form->hidden('emailUser', array('value' => $emailUser));
				echo $form->hidden('gzwId', array('value' => $session->read('Auth.User.name')));
				
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Contact service'); ?></td>
					<td class="form_part2"><?php echo $form->input('email', array('options' => array(
																						$supportEmail => __d('core', 'Technical support', true),
																						$adminEmail => __d('core', 'Contact an administrator', true),
																						$abuseEmail => __d('core', 'Abuse service', true),
																						$businessEmail => __d('core', 'Business service', true)), 'label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Message subject'); ?></td>
					<td class="form_part2"><?php echo $form->input('subject', array('label' => false, 'size' => '47')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Message content'); ?></td>
					<td class="form_part2"><?php echo $form->input('message', array('label' => false, 'rows' => '10', 'cols' => '46')); ?></td>
				</tr>
			</table>	

			<?php echo $form->end(__d('core', 'Send the message', true)); ?>

		</div>
	</div>
</div>