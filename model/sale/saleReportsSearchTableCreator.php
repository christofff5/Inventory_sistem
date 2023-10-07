<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$uPrice = 0;
$qty = 0;
$totalPrice = 0;

$saleDetailsSearchSql = 'SELECT * FROM sale';
$saleDetailsSearchStatement = $conn->prepare($saleDetailsSearchSql);
$saleDetailsSearchStatement->execute();

$output = '<table id="saleReportsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>ID Barang Keluar</th>
						<th>Nomor Barang</th>
						<th>ID Peminta</th>
						<th>Nama Peminta</th>
						<th>Nama Barang</th>
						<th>Tanggal Barang Keluar</th>
						<th>Jumlah</th>
					</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while ($row = $saleDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {


	$output .= '<tr>' .
		'<td>' . $row['saleID'] . '</td>' .
		'<td>' . $row['itemNumber'] . '</td>' .
		'<td>' . $row['customerID'] . '</td>' .
		'<td>' . $row['customerName'] . '</td>' .
		'<td>' . $row['itemName'] . '</td>' .
		'<td>' . $row['saleDate'] . '</td>' .
		'<td>' . $row['quantity'] . '</td>' .
		'</tr>';
}

$saleDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
						
					</tfoot>
				</table>';
echo $output;
