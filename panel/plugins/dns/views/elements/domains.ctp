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
 * Call the "element" method in the "Modules" controller.
 */
$modules = $this->requestAction('modules/element');
?>

<div id="options">
	<div class="title"><i>&gt;&gt; <?php __d('domain', 'Domain management.'); ?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/dns/img/options/domain/add_domain.png', array('alt' => 'Domain')); ?></dt>
						<dd><?php echo $html->link(__d('domain', 'Domains', true), array('plugin' => 'dns', 'controller' => 'domains', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('/dns/img/options/subdomain/add_subdomain.png', array('alt' => 'Subdomain')); ?></dt>
						<dd><?php echo $html->link(__d('domain', 'Subdomains', true), array('plugin' => 'dns', 'controller' => 'subdomains', 'action' => 'index')); ?></dd>
					</dl>
				</td>
				
				<?php
					/**
					 * Put all modules in a loop.
					 */
					foreach ($modules as $module):

						/**
						 * Display all modules who have "domains" as "element" field.
						 */
						if ($module['Module']['element'] == 'domains') {

							/**
							 * Get the image path.
							 */
							$moduleImage = $module['Module']['image'];
							
							/**
							 * Get the module name.
							 */
							$moduleName = $module['Module']['translateName'];
							
							/**
							 * Get the controller name path.
							 */
							$moduleController = $module['Module']['controller'];
							
							/**
							 * Get the action name path.
							 */
							$moduleAction = $module['Module']['action'];
							
							/**
							 * Get the module link path.
							 */
							$modulePlugin = explode('/', $module['Module']['link']);

							/**
							 * Display.
							 */
							echo "<td>
								<dl class=\"links_option\">
									<dt>" . $html->image($moduleImage, array('alt' => $moduleName)) . "</dt>
									<dd>" . $html->link(__d('core', $moduleName ,true), array('plugin' => $modulePlugin['1'], 'controller' => $moduleController, 'action' => $moduleAction)) . "</dd>
								</dl>
							</td>";
						}
					endforeach;
				?>

			</tr>
		</table>
	</div>
</div>