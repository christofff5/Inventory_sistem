<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$vendorDetailsSearchSql = 'SELECT * FROM vendor';
$vendorDetailsSearchStatement = $conn->prepare($vendorDetailsSearchSql);
$vendorDetailsSearchStatement->execute();

$output = '<table id="vendorDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>ID Supplier</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Telp</th>
						<th>Alamat</th>
						<th>Alamat 2</th>
					</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while ($row = $vendorDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
	$output .= '<tr>' .
		'<td>' . $row['vendorID'] . '</td>' .
		'<td>' . $row['fullName'] . '</td>' .
		'<td>' . $row['email'] . '</td>' .
		'<td>' . $row['mobile'] . '</td>' .
		'<td>' . $row['address'] . '</td>' .
		'<td>' . $row['address2'] . '</td>' .
		'</tr>';
}

$vendorDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
						
					</tfoot>
				</table>';
echo $output;
