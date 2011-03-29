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
		<div class="image"><?php echo $html->image('options/user/profile_full.png', array('alt' => 'Profile')); ?></div>
		<div class="name"><?php __d('core', 'Users management.'); ?>
			<div class="infos">
				<?php __d('core', 'users_informations'); ?>
			</div>
		</div>
		<div class="main_display">
			<div class="admin">

				<?php
					/**
				 	 * Display the messages.
					 */
					echo $session->flash();

					/**
					 * Display the add user link.
					 */
					echo $html->link(__d('core', 'Add a new user', true), array('controller' => 'users', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<br /><br />

				<table  cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('core', 'Profil', true), 'profile_id'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'ID', true), 'id'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Email', true), 'email'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Name', true), 'name'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Status', true), 'status'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Registered', true), 'registered'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Offer', true), 'offer_id'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Country', true), 'country'); ?></th>
						<th><?php __d('core', 'Actions'); ?></th>
					</tr>

					<?php foreach ($users as $user): ?>

					<tr class="<?php echo $status->htmlClass($user['User']['status']); ?>">
						<td>
							<?php echo $status->rank($user['User']['profile_id']); ?>
						</td>
						<td>
							<?php echo $user['User']['id']; ?>
						</td>
						<td>
							<?php echo $text->autoLinkEmails($user['User']['email']); ?>
						</td>
						<td>
							<?php echo $user['User']['name']; ?>
						</td>
						<td>
							<?php echo $status->display($user['User']['status']); ?>
						</td>
						<td>
							<?php echo $user['User']['registered']; ?>
						</td>
						<td>
							<?php echo $html->link(ucfirst($user['Offer']['name']), array('controller'=> 'offers', 'action' => 'view', $user['Offer']['id'])); ?>
						</td>
						<td>
							<?php echo $user['User']['country']; ?>
						</td>
						<td class="actions">
							<?php
								echo $html->image(
									'/img/options/admin/view.png', array(
									'alt' => __d('core', 'View', true),
									'url' => array('action' => 'view', $user['User']['id']))
								);

								echo $html->image(
									'/img/options/admin/edit.png', array(
									'alt' => __d('core', 'Edit', true),
									'url' => array('action' => 'edit', $user['User']['id']))
								); 

								echo $html->image(
									'/img/options/admin/password.png', array(
									'alt' => __d('core', 'Password', true),
									'url' => array('action' => 'password', $user['User']['id']))
								);

								echo $html->image(
									'/img/options/admin/reset.png', array(
									'alt' => __d('core', 'Reset', true),
									'url' => array('action' => 'reset', $user['User']['id']))
								);

								echo $html->link(
										$html->image(
											'/img/options/admin/delete.png', array(
											'alt' => __d('core', 'Delete', true))),
									array('action' => 'delete', $user['User']['id']),
									array('escape' => false), __d('core', 'Do you really want delete this account ?', true)
								);

								echo $status->change('users', $user['User']['status'], $user['User']['id']);
							?>
						</td>
					</tr>

					<?php endforeach; ?>

				</table>
			</div>

			<div class="paging">
				<?php echo $paginator->prev('<< ' . __d('core', 'Previous', true), array(), null, array('class' => 'disabled')); ?>
			 | 	<?php echo $paginator->numbers(); ?>
				<?php echo $paginator->next(__d('core', 'Next', true) . ' >>', array(), null, array('class' => 'disabled')); ?>
			</div>

			<div class="legendTitle"><?php echo __d('ftp', 'Options description :', true); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/admin.png', array('alt' => __d('core', 'admin', true))) . '&#160;' . __d('core', 'This user is an administrator.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/member.png', array('alt' => __d('core', 'member', true))) . '&#160;' . __d('core', 'This user is a standard user.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/view.png', array('alt' => __d('core', 'view', true))) . '&#160;' . __d('core', 'View the user profile', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'edit', true))) . '&#160;' . __d('core', 'Edit teh user profile.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/password.png', array('alt' => __d('core', 'password', true))) . '&#160;' . __d('core', 'Change the user password.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/reset.png', array('alt' => __d('core', 'reset', true))) . '&#160;' . __d('core', 'Reset the user account', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'delete', true))) . '&#160;' . __d('core', 'Delete the user account.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => __d('core', 'enabled', true))) . '&#160;' . __d('core', 'Enable the account.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => __d('core', 'disabled', true))) . '&#160;' . __d('core', 'Disable the account.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>