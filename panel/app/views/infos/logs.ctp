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
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/info/history_full.png', array('alt' => 'History')); ?></div>
		<div class="name"><?php __d('core', 'Events log.'); ?>
			<div class="infos">
				<?php __d('core', 'All the actions taken by you in the members area are recorded.<br />
									In case of discrepancies please contact an administrator.'
						);
				?>
			</div>
		</div>
		<div class="main_display">
		</div>
	</div>
</div>
