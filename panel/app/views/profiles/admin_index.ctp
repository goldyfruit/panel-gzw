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
 * Display the profile options.
 */
echo $this->element('profiles');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/profile/add_profile_full.png', array('alt' => 'Profile')); ?></div>
		<div class="name"><?php __d('core', 'Profiles management.'); ?>
			<div class="infos">
				<?php __d('core', 'profiles_informations'); ?>
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
					 * Display the add profile link.
					 */
					echo $html->link(__d('core', 'Add a new profile', true), array('controller' => 'profiles', 'action'=> 'add'), array('class' => 'addButton'));
				?>

				<br /><br />

				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('core', 'id', true)); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Name', true)); ?></th>
						<th><?php __d('core', 'Actions'); ?></th>
					</tr>

					<?php foreach ($profiles as $profile): ?>

					<tr>
						<td>
							<?php echo $profile['Profile']['id']; ?>
						</td>
						<td>
							<?php echo $profile['Profile']['name']; ?>
						</td>
						<td class="actions">
							<?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'Edit', true), 'url' => array('action' => 'edit', $profile['Profile']['id']))); ?>
							<?php echo $html->link(
												$html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'Delete', true))),
											array('action' => 'delete', $profile['Profile']['id']), array('escape' => false), __d('core', 'Do you really want delete this profile ?', true)
										);
							?>
						</td>
					</tr>

					<?php endforeach; ?>

				</table>
			</div>

			<div class="paging">
				<?php echo $paginator->prev('<< ' . __d('core', 'previous', true), array(), null, array('class' => 'disabled')); ?>
			 | 	<?php echo $paginator->numbers();?>
				<?php echo $paginator->next(__d('core', 'next', true) . ' >>', array(), null, array('class' =>' disabled')); ?>
			</div>

			<div class="legendTitle"><?php __d('core', 'options_legend'); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'edit', true))) . '&#160;' . __d('core', 'Edit the profile.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/delete.png', array('alt' => __d('core', 'delete', true))) . '&#160;' . __d('core', 'Delete the profile.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>