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
		<div class="image"><?php echo $html->image('options/config/modules_full.png', array('alt' => 'Modules')); ?></div>
		<div class="name"><?php __d('core', 'Modules management.'); ?>
			<div class="infos">
				<?php __d('core', 'A module is a part of the panel who allow you to manage DNS, Email, or what you want. :)<br />
							You can find some modules on internet or try to develop one by your self.');
				?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				echo $session->flash();
			?>

			<p class="warning"><?php __d('core', 'Be very careful with the changes you make in the modules !'); ?></p>

			<div class="admin">
				<table cellpadding="0" cellspacing="0">
					<tr>
						<th><?php echo $paginator->sort(__d('core', 'Name', true), 'name'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Translate', true), 'translateName'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Link', true), 'link'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Version', true), 'version'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Display', true), 'display'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Controller', true), 'controller'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Action', true), 'action'); ?></th>
						<th><?php echo $paginator->sort(__d('core', 'Status', true), 'status'); ?></th>
						<th><?php __d('core', 'Actions'); ?></th>
					</tr>

					<?php foreach ($modules as $module): ?>

					<tr class="<?php echo $status->htmlClass($module['Module']['status']); ?>">
						<td>
							<?php echo $module['Module']['name']; ?>
						</td>
						<td>
							<?php echo $module['Module']['translateName']; ?>
						</td>
						<td>
							<?php echo $module['Module']['link']; ?>
						</td>
						<td>
							<?php echo $module['Module']['version']; ?>
						</td>
						<td>
							<?php echo $module['Module']['display']; ?>
						</td>
						<td>
							<?php echo $module['Module']['controller']; ?>
						</td>
						<td>
							<?php echo $module['Module']['action']; ?>
						</td>
						<td>
							<?php echo $status->display($module['Module']['status']); ?>
						</td>
						<td class="actions">
							<?php
								echo $html->image(
									'/img/options/admin/edit.png',
									array('alt' => __d('core', 'Edit', true),
										'url' => array('action' => 'edit',
										$module['Module']['id'])
									)
								);
								echo $status->change('modules', $module['Module']['status'], $module['Module']['id']);
							?>
						</td>
					</tr>

				<?php endforeach; ?>

				</table>
			</div>

			<div class="legendTitle"><?php __d('core', 'Description of options :'); ?></div>
			<div class="legend">
				<ul>
					<li><?php echo $html->image('/img/options/admin/edit.png', array('alt' => __d('core', 'edit', true))) . '&#160;' . __d('core', 'Edit the module.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/enabled.png', array('alt' => __d('core', 'enabled', true))) . '&#160;' . __d('core', 'Enable the module.', true); ?></li>
					<li><?php echo $html->image('/img/options/admin/disabled.png', array('alt' => __d('core', 'disabled', true))) . '&#160;' . __d('core', 'Disable the module.', true); ?></li>
				</ul>
			</div>

		</div>
	</div>
</div>