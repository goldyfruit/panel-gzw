<html>
<head>
	<title><?php __d('billing', 'GoldZone Web - Bill N&ordm; : ' . $bill['Bill']['id']); ?></title>
	<?php echo $html->css('/billing/css/bill.css'); ?>
</head>
<body>
	<div id="globalbox">
		<div>
			<img src="/billing/img/logos/logo_billing.png" id="logo" alt="GoldZone Web" title="GoldZone Web" />
		</div>

		<div id="main">

		<div id="bill_header">
			<h1><?php __d('billing', 'Bill N&ordm; : ' . $bill['Bill']['id']); ?></h1>
			<h2><?php __d('billing', 'Date : ' . $bill['Bill']['created']); ?></h2>
		</div>

		<table id="bill_infos">
			<tr>
				<td>
					<strong><?php __d('billing', 'Sender :'); ?></strong>
					<br /><br />
					<b>GoldZone Web Limited</b><br />
					94 Chichester Road<br />
					N9 9DG Londres<br />
					Royaume-Uni<br />
					
					Number 7370665 registered in England and Wales<br />
					GB 906 3421 47<br />
					Mail : <a href="mailto:facture@goldzoneweb.info">facture@goldzoneweb.info</a>
				</td>
				<td>
					<strong><?php __d('billing', 'Client ID : ' . strtoupper($bill['User']['name'])); ?></strong>
					<br /><br />
					<?php echo $bill['User']['firstname'] . ' ' . $bill['User']['lastname']; ?>
					<br />
					<?php echo $bill['User']['address']; ?>
					<br />
					<?php echo $bill['User']['zipcode'] . ' ' . $bill['User']['city']; ?>
					<br />
					<?php echo $bill['User']['country']; ?>
					<br />
					<?php echo __d('billing', 'Phone : ', true) . $bill['User']['telephone']; ?>
					<br /><br />
					<?php echo __d('billing', 'Mail : ', true) . '<a href="mailto:' . $bill['User']['email'] . '">' . $bill['User']['email'] . '</a>'; ?>
					<br /><br />
				</td>
			</tr>
		</table>

		<p id="bill_date">
			<strong><?php __d('billing', 'Payment'); ?></strong>
			<br />
			<?php echo __d('billing', 'Validated on ', true) . $bill['Bill']['created']; ?>
		</p>

			<div class="table" id="bill">
				<table class="bill_detail">
					<thead>
						<tr>
							<th><?php __d('billing', 'Product'); ?></th>
							<th style="width: 150px"><?php __d('billing', 'Description'); ?></th>
							<th style="width: 150px"><?php __d('billing', 'Owner'); ?></th>
							<th style="width: 75px"><?php __d('billing', 'Price'); ?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $bill['Bill']['product']; ?></td>
							<td><?php echo $bill['Bill']['description']; ?></td>
							<td><?php echo $bill['User']['firstname'] . ' ' . $bill['User']['lastname']; ?></td>
							<td><?php echo number_format($bill['Bill']['price'], 2, ',', ' '); ?>&nbsp;&euro;</td>
						</tr>
					</tbody>
				</table>
			</div>

		<table id="summary">
			<tr>
				<td class="title"><?php __d('billing', 'Price without duty'); ?></td>
				<td class="price"><?php echo number_format($bill['Bill']['price'], 2, ',', ' '); ?>&nbsp;&euro;</td>
		
			</tr>
			<tr>
				<td class="title"><?php __d('billing', 'TVA (20 %)'); ?></td>
				<td class="price"><?php echo number_format(($bill['Bill']['price'] * 0.20), 2, ',', ' '); ?>&nbsp;&euro;</td>
			</tr>
			<tr>
				<td class="title">
					<span class="highlight"><?php __d('billing', 'Price with duty'); ?></span>
				</td>
				<td class="price">
					<span class="highlight"><?php echo number_format($bill['Bill']['taxe'], 2, ',', ' '); ?>&nbsp;&euro;</span>
				</td>
			</tr>
		</table>

		<span class="hrclear10"></span>

		<div class="print">
			<p>
				<a href="#" onclick="window.print();return false;"><?php __d('billing', 'Print this page'); ?></a>
			</p>
			<a href="/billing/bills/" onclick="window.close();" ><?php __d('billing', 'Close'); ?></a>
		</div>
	</div>

</body>
</html>
