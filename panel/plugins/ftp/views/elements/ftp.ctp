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
	<div class="title"><i>&gt;&gt; <?php __d('ftp', 'FTP Management.'); ?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/ftp/img/options/ftpusers/add_ftp_user.png', array('alt' => 'AddFTP')); ?></dt>
						<dd><?php echo $html->link(__d('ftp', 'FTP users', true), array('controller' => 'ftpusers', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/ftp/img/options/ftpusers/ftp_status.png', array('alt' => 'Status')); ?></dt>
						<dd><?php echo $html->link(__d('ftp', 'Status', true), array('controller' => 'ftpusers', 'action' => 'status')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/ftp/img/options/ftpusers/webftp.png', array('alt' => 'WebFTP')); ?></dt>
						<dd><?php echo $html->link(__d('ftp', 'WebFTP', true), 'https://webftp.goldzoneweb.info'); ?></dd>
					</dl>
				</td>
			</tr>
		</table>
	</div>
</div>