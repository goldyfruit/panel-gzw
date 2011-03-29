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
 * Display the sql options.
 */
echo $this->element('sql');
 
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('/sql/img/options/sqldatas/add_sql_database_full.png', array('alt' => 'AddSQLUser')); ?></div>
		<div class="name"><?php __d('sql', 'SQL databases management.'); ?>
			<div class="infos">
				<?php __d('sql', 'A database can store informations other than in a web page. <br />
								Forums, galeries, blogs, wiki, etc... use this kind of method, the database should be named 3 characters minimum.'
						);
				?>
			</div>
		</div>
		<div class="main_display">
			<?php
				/**
				 * Display messages.
				 */
				echo $session->flash();

				/**
				 * Create the "Sqldata" form.
				 */

				echo $form->create('Sqldata');

				/**
				 * This field is very important for an edit.
				 * He said which sqldata is edited.
				 */
				echo $form->input('Sqldata.id');

				/**
				 * Create a hidden form field, this one contain the user ID.
				 */
				echo $form->hidden('Sqldata.user_id', array('value' => $session->read('Auth.User.id')));
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('sql', 'Available SQL user(s)'); ?></td>
					<td class="form_part2"><?php echo $form->input('Sqldata.sqluser_id', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('sql', 'SQL database name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Sqldata.name', array('value' => $nameEdit['0'], 'label' => false, 'size' => '31', 'after' => '<span class="highlight" style="font-family: monospace;">_' . $session->read('Auth.User.name').'</span>')); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('sql', 'Select the SQL engine'); ?></td>
					<td class="form_part2"><?php echo $form->input('Sqldata.type', array('options' => array('mysql' => __d('sql', 'MySQL', true)), 'label' => false)); ?></td>
				</tr>
			</table>			
			<?php echo $form->end(__d('sql', 'Edit the database', true)); ?>

			<div class="advice">
				<?php echo $html->image('/img/main/advice.png', array('alt' => 'Advice')); ?>
				<?php __d('sql', 'All special characters will be replaced by their equivalents for the "SQL database name" field (é by e, à by a, space by _, etc...).'); ?>
			</div>

		</div>
	</div>
</div>
