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
?>

<div id="options">
	<div class="title"><i>&gt;&gt; <?php echo __d('core', 'Informations' ,true); ?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/info/summary.png', array('alt' => 'Summary')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Summary' ,true), array('controller' => 'infos', 'action' => 'summary')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/info/path.png', array('alt' => 'Path')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Absolute path' ,true), array('controller' => 'infos', 'action' => 'path')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/info/ports.png', array('alt' => 'Ports')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Ports' ,true), array('controller' => 'infos', 'action' => 'ports')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/info/phpinfo.png', array('alt' => 'Phpinfo')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'PHPinfos()' ,true), $options['0']['Option']['link_phpinfo'], array('target' => '_blank')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/info/history.png', array('alt' => 'Events')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Events' ,true), array('controller' => 'logs', 'action' => 'index')); ?></dd>
					</dl>
				</td>
			</tr>
		</table>
	</div>
</div>