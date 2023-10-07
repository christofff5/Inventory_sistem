<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$uPrice = 0;
$qty = 0;
$totalPrice = 0;

$purchaseDetailsSearchSql = 'SELECT * FROM purchase';
$purchaseDetailsSearchStatement = $conn->prepare($purchaseDetailsSearchSql);
$purchaseDetailsSearchStatement->execute();

$output = '<table id="purchaseDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>ID Barang Susulan</th>
						<th>Nomor Barang</th>
						<th>Tanggal Barang Susulan</th>
						<th>Nama Barang</th>
						<th>Jumlah</th>
						<th>Nama Supplier</th>
						<th>ID Supplier</th>
					</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while ($row = $purchaseDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
	// $uPrice = $row['unitPrice'];
	// $qty = $row['quantity'];
	// $totalPrice = $uPrice * $qty;

	$output .= '<tr>' .
		'<td>' . $row['purchaseID'] . '</td>' .
		'<td>' . $row['itemNumber'] . '</td>' .
		'<td>' . $row['purchaseDate'] . '</td>' .
		'<td>' . $row['itemName'] . '</td>' .
		// '<td>' . $row['unitPrice'] . '</td>' .
		'<td>' . $row['quantity'] . '</td>' .
		'<td>' . $row['vendorName'] . '</td>' .
		'<td>' . $row['vendorID'] . '</td>' .
		// '<td>' . $totalPrice . '</td>' .
		'</tr>';
}

$purchaseDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
		
					</tfoot>
				</table>';
echo $output;
