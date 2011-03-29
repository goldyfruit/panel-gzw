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
	<div class="title"><i>&gt;&gt; <?php __d('mail', 'Mail management.')?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/mail/img/options/mailbox/add_mailbox.png', array('alt' => 'AddMailbox')); ?></dt>
						<dd><?php echo $html->link(__d('mail', 'Mailboxes', true), array('controller' => 'mailboxes', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/mail/img/options/alias/add_alias.png', array('alt' => 'AddAlias')); ?></dt>
						<dd><?php echo $html->link(__d('mail', 'Aliases', true), array('controller' => 'aliases', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/mail/img/options/mailbox/webmail.png', array('alt' => 'Webmail')); ?></dt>
						<dd><?php echo $html->link(__d('mail', 'Webmail', true), 'https://webmail.goldzoneweb.info'); ?></dd>
					</dl>
				</td>
			</tr>
		</table>
	</div>
</div>