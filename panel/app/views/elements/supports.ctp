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
	<div class="title"><i>&gt;&gt; <?php __d('core', 'Helpdesk'); ?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/support/contact.png', array('alt' => 'Contact')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Contact', true), array('controller' => 'supports', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/support/forum.png', array('alt' => 'Forum')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Forum access', true), $options['0']['Option']['link_forum'], array('target' => '_blank')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/support/irc.png', array('alt' => 'IRC')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'IRC support', true), $options['0']['Option']['link_irc'], array('target' => '_blank')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/support/doc.png', array('alt' => 'Doc')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'FAQ / Wiki', true), $options['0']['Option']['link_doc'], array('target' => '_blank')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/support/mailing-list.png', array('alt' => 'Mailing')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Mailing-list', true), $options['0']['Option']['link_mailing'], array('target' => '_blank')); ?></dd>
					</dl>
				</td>
			</tr>
		</table>
	</div>
</div>