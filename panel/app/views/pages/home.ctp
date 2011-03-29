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
 * Call the "index" method in the "Options" controller. 
 */
$options = $this->requestAction('options/index');

/**
 * Call the "sqlVersion" method in the "Options" controller. 
 */
$sqlVersion = $this->requestAction('options/sqlVersion');

/**
 * Select the panel option to check new version in "options" table.
 * @var string
 */
$check = $options['0']['Option']['check_version'];

/**
 * Select the panel version in "options" table.
 * @var string
 */
$panelVersion = $options['0']['Option']['version'];

/**
 * Set the $color variable to avoid an error.
 */
$color = '';

?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/info/infos_panel.png', array('alt' => 'Infos')); ?></div>
		<div class="name"><?php __d('core', 'Server informations'); ?>
			<div class="infos">
				<?php __d('core', 'The following informations about the server and the panel, it is important to check the version of the panel.<br />
									In case of discrepancy with the informations returned please contact a developer to resolve the problem.'
						);
				?>
			</div>
		</div>
		<div class="main_display">

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Official panel version'); ?></td>
					<td class="form_part2"><span class="highlight">
						<?php
							/**
							 * If checking version is enabled the panel check if a new panel version is available.
							 */
							if ($check == '0') {

								/**
								 * Check if the "allow_url_fopen" function is enable.
								 * If not an error message is displayed.
								 */
								if (!ini_get('allow_url_fopen')) 

									echo __d('core', '"allow_url_open" function is disable, check your PHP configuration.', true);

									/**
									 * Open the "version.txt" file to take the official panel version.
									 * @var string
									 */
									$check_version = fopen('http://www.panel-gzw.com/version.txt', 'r');

									/**
									 * Read the "version.txt" file.
									 * @var string
									 */
									$version = trim(@fread($check_version, 16));

									/**
									 * Close the "version.txt" file.
									 */
									@fclose($check_version);

									/**
									 * Display the panel version.
									 */
									echo $version;
									
									/**
									 * Check the panel version and determine which color will be used.
									 */
									if ($version == $panelVersion) {
										$color = 'color: #009900;';
									} else {
										$color = 'color: #FF0000;';
									}

							} else {
								echo __d('core', 'Check version disabled', true);
							}

						?>
					</span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Your panel version'); ?></td>
					<td class="form_part2"><span class="highlight" <?php if ($color) { echo 'style="' . $color . '"'; } ?>"><?php echo $panelVersion; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'PHP version'); ?></td>
					<td class="form_part2"><span class="highlight"><?php echo phpversion(); ?> ( <a href="<?php echo 'phpinfo'; ?>" title="phpinfos">phpinfos()</a> )</span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'MySQL version'); ?></td>
					<td class="form_part2"><span class="highlight"><?php echo $sqlVersion['0']['0']['v']; ?></span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Copyright'); ?></td>
					<td class="form_part2"><span class="highlight">2005 - 2011 GoldZone Web ( <a href="mailto:gaetan.trellu@goldzoneweb.info">gaetan.trellu@goldzoneweb.info</a> )</span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Server informations'); ?></td>
					<td class="form_part2"><span class="highlight">
						<?php
							$commande = shell_exec('uptime');
							$uptime = explode('up', $commande);
							$uptime = $uptime[1];
							echo $uptime;
						?>
					</span></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Server IP address'); ?></td>
					<td class="form_part2"><span class="highlight"><?php echo $_SERVER['SERVER_ADDR']; ?></span></td>
				</tr>
			</table>

		</div>
	</div>
</div>