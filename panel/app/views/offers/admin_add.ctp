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
 * Display the offers options.
 */
echo $this->element('offers');
?>

<div id="content">
	<div class="main">
		<div class="image"><?php echo $html->image('options/offer/add_offer_full.png', array('alt' => 'Offer')); ?></div>
		<div class="name"><?php __d('core', 'Offers management.'); ?>
			<div class="infos">
				<?php __d('core', 'offers_informations'); ?>
			</div>
		</div>
		<div class="main_display">

			<?php
				/**
				 * Display the messages.
				 */
				echo $session->flash();

				/**
				 * Create the offer form.
				 */
				echo $form->create('Offer');
			?>

			<table>
				<tr>
					<td class="form_part1"><?php __d('core', 'Offer name'); ?></td>
					<td class="form_part2"><?php echo $form->input('Offer.name', array('label' => false)); ?></td>
				</tr>
				<tr>
					<td class="form_part1"><?php __d('core', 'Enable the offer')?></td>
					<td class="form_part2"><?php echo $form->radio('Offer.status', array(__d('core', 'Yes', true), __d('core', 'No', true)), array('default' => 'No', 'legend' => false, 'separator' => '&nbsp&nbsp')); ?></td>
				</tr>
			</table>

			<?php echo $form->end(__d('core', 'Create the offer', true)); ?>

		</div>
	</div>
</div>