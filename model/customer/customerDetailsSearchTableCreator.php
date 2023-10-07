<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$customerDetailsSearchSql = 'SELECT * FROM customer';
$customerDetailsSearchStatement = $conn->prepare($customerDetailsSearchSql);
$customerDetailsSearchStatement->execute();

$output = '<table id="customerDetailsTable" class="table table-sm table-striped table-bordered table-hover" style="width:100%">
				<thead>
					<tr>
						<th>ID Peminta</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Telp</th>
					</tr>
				</thead>
				<tbody>';

// Create table rows from the selected data
while ($row = $customerDetailsSearchStatement->fetch(PDO::FETCH_ASSOC)) {
	$output .= '<tr>' .
		'<td>' . $row['customerID'] . '</td>' .
		'<td>' . $row['fullName'] . '</td>' .
		'<td>' . $row['email'] . '</td>' .
		'<td>' . $row['mobile'] . '</td>' .
		'</tr>';
}

$customerDetailsSearchStatement->closeCursor();

$output .= '</tbody>
					<tfoot>
						<tr>
							<th>ID Peminta</th>
							<th>Nama</th>
							<th>Email</th>
							<th>Telp</th>
						</tr>
					</tfoot>
				</table>';
echo $output;
