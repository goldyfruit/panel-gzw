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
 * Select the state of the reset link account.
 * @var string
 */
$resetLink = $options['0']['Option']['display_reset_account'];

/**
 * Select the state of the delete link account.
 * @var string
 */
$deleteLink = $options['0']['Option']['display_delete_account'];

/**
 * Call the "element" method in the "Modules" controller.
 */
$modules = $this->requestAction('modules/element');
?>

<div id="options">
	<div class="title"><i>&gt;&gt; <?php __d('core', 'Users management.'); ?></i></div>
	<div class="menu_links">
		<table>
			<tr>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/user/profile.png', array('alt' => 'Profile')); ?></dt>
						
						<?php
							/**
							 * If the user connected is an administrator, the "account" link will be different. 
							 */
							if ($session->read('Auth.User.profile_id') == 1) {
						?>
						
							<dd><?php echo $html->link(__d('core', 'The users', true), array('plugin' => null, 'controller' => 'users', 'action' => 'index')); ?></dd>
						
						<?php } else { ?>
						
							<dd><?php echo $html->link(__d('core', 'My profile', true), array('plugin' => null, 'controller' => 'users', 'action' => 'index')); ?></dd>
						
						<?php } ?>
						
					</dl>
				</td>

				<?php
					/**
					 * If the user connected is only a member, all "profile" links will be display.
					 */
					if ($session->read('Auth.User.profile_id') == 2) {
				?>

				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/user/password.png', array('alt' => 'Password')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Password' ,true), array('plugin' => null, 'controller' => 'users', 'action' => 'password', $session->read('Auth.User.id'))); ?></dd>
					</dl>
				</td>

				<?php
					/**
					 * If the reset link account is not available, this one is not displayed.
					 */
					if ($resetLink == 0) {
				?>
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/user/reset.png', array('alt' => 'Reset')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Reset account' ,true), array('plugin' => null, 'controller' => 'users', 'action' => 'reset')); ?></dd>
					</dl>
				</td>

				<?php
					}

					/**
					 * If the delete link account is not available, this one is not displayed.
					 */
					if ($deleteLink == 0) {
				?>

				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/user/delete.png', array('alt' => 'Delete')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Delete account' ,true), array('plugin' => null, 'controller' => 'users', 'action' => 'delete', $session->read('Auth.User.id')), null, sprintf(__d('core', 'Do you really want delete your account ?', true), $session->read('Auth.User.id'))); ?></dd>
					</dl>
				</td>
				
				<?php } ?>
				
				<td>
					<dl class="links_option">
						<dt><?php echo $html->image('options/user/quotas.png', array('alt' => 'Quotas')); ?></dt>
						<dd><?php echo $html->link(__d('core', 'Quotas' ,true), array('plugin' => null, 'controller' => 'users', 'action' => 'quotas')); ?></dd>
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
						if ($module['Module']['element'] == 'users') {

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
				}
				?>

			</tr>
		</table>
	</div>
</div>