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
 * Display the crontab options.
 */
echo $this->element('ftp');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/ftp/img/options/ftpusers/add_ftp_user_full.png', array('alt' => 'FTP')); ?></div>
		<div class="name"><?php __d('ftp', 'FTP management.'); ?>
			<div class="infos">
				<?php __d('ftp', 'To transfer your site to the server an FTP user to be created. <br />
							If you have multiple users it is possible to assign a directory specific to each.'
						);
				?>
			</div>
		</div>
		<div class="main_display">
			<div class="admin">
				<?php
					/**
					 * Display messages.
					 */
					echo $session->flash();
				?>
				
				<table cellpadding="0" cellspacing="0">
				<tr>
					<th><?php echo $paginator->sort(__d('ftp', 'Name', true)); ?></th>
					<th><?php echo $paginator->sort(__d('ftp', 'Count', true)); ?></th>
					<th><?php echo $paginator->sort(__d('ftp', 'Homedir', true)); ?></th>
					<th><?php echo $paginator->sort(__d('ftp', 'Accessed', true)); ?></th>
					<th><?php echo $paginator->sort(__d('ftp', 'Modified', true)); ?></th>
				</tr>

				<?php foreach ($ftpusers as $ftpuser): ?>

					<tr class="<?php echo $status->htmlClass($ftpuser['Ftpuser']['status']); ?>">
						<td>
							<?php echo $ftpuser['Ftpuser']['name']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['count']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['homedir']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['accessed']; ?>
						</td>
						<td>
							<?php echo $ftpuser['Ftpuser']['modified']; ?>
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

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<? __d('ftp', 'In case of inconsistencies that may mean that a third person has access to your web space.'); ?>
			</div>

		</div>
	</div>
</div>

