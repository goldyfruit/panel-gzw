<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2009  Gaëtan Trellu - goldyfruit@free.fr

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
	<div class="title"><i>&gt;&gt; <?php __d('core', 'Panel management.'); ?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/config/options.png', array('alt' => 'Options')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Main options' ,true), array('controller' => 'options', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/config/ports.png', array('alt' => 'Ports')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Ports' ,true), array('controller' => 'options', 'action' => 'ports')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/config/links.png', array('alt' => 'Links')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Links' ,true), array('controller' => 'options', 'action' => 'links')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/config/modules.png', array('alt' => 'Modules')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Modules' ,true), array('controller' => 'modules', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/config/quotas.png', array('alt' => 'Quotas')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Quotas' ,true), array('controller' => 'quotas', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/config/maintenance.png', array('alt' => 'Maintenance')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Maintenance' ,true), array('controller' => 'options', 'action' => 'maintenance')); ?></dd>
					</dl>
				</td>
			</tr>
		</table>
	</div>
</div>