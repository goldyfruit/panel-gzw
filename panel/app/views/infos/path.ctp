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
		<div class="image"><?php echo $html->image('options/info/path_full.png', array('alt' => 'Path')); ?></div>
		<div class="name"><?php __d('core', 'Absolute path'); ?>
			<div class="infos">
				<?php __d('core', 'The absolute path is useful in PHP, it gives the path of the root server to your web directory.<br />
									It is often used for .htaccess files.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

		<p class="warning"><?php __d('core', 'Do not abuse the absolute path in your scripts.'); ?></p>

			<?php foreach ($options as $option): ?>

			<table>
					<tr>
						<td class="form_part1"><?php __d('core', 'Your absolute path'); ?></td>
						<td class="form_part2"><span class="highlight" style="font-family: monospace;"><?php echo $option['Option']['path'] . $session->read('Auth.User.name') . '/'; ?></span></td>
					</tr>
			</table>

			<?php endforeach; ?>

		<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('core', 'In case of the server change don\'t forget to change the path (only if necessary).'); ?>
		</div>

		</div>
	</div>
</div>