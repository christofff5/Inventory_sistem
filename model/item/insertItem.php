<?php
require_once('../../inc/config/constants.php');
require_once('../../inc/config/db.php');

$initialStock = 0;
$baseImageFolder = '../../data/item_images/';
$itemImageFolder = '';

if (isset($_POST['itemDetailsItemNumber'])) {

	$itemNumber = htmlentities($_POST['itemDetailsItemNumber']);
	// $itemDate = htmlentities($_POST['itemDetailsDate']);
	$itemName = htmlentities($_POST['itemDetailsItemName']);
	// $vendorName = htmlentities($_POST['vendorDetailsName']);
	// $discount = htmlentities($_POST['itemDetailsDiscount']);
	$quantity = htmlentities($_POST['itemDetailsQuantity']);
	//$unitPrice = htmlentities($_POST['itemDetailsUnitPrice']);
	$description = htmlentities($_POST['itemDetailsDescription']);
	// $purchaseDetailsVendorName = htmlentities($_POST['itemDetailsVendorName']);

	// Periksa apakah bidang wajib tidak kosong
	if (!empty($itemNumber) && !empty($itemName) && isset($quantity)) {

		// Sanitasi nomor barang
		$itemNumber = filter_var($itemNumber, FILTER_SANITIZE_STRING);

		// Validasi jumlah item. Itu harus berupa angka
		if (filter_var($quantity, FILTER_VALIDATE_INT) === 0 || filter_var($quantity, FILTER_VALIDATE_INT)) {
			// Jumlah valid
		} else {
			// Jumlah tidak sesuai
			echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for quantity</div>';
			exit();
		}

		// Validate unit price. It has to be a number or floating point value
		//if (filter_var($unitPrice, FILTER_VALIDATE_FLOAT) === 0.0 || filter_var($unitPrice, FILTER_VALIDATE_FLOAT)) {
		// Valid float (unit price)
	} else {
		// Unit price is not a valid number
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid number for unit price</div>';
		exit();
	}

	// Validate discount only if it's provided
	// if(!empty($discount)){
	// 	if(filter_var($discount, FILTER_VALIDATE_FLOAT) === false){
	// 		// Discount is not a valid floating point number
	// 		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter a valid discount amount</div>';
	// 		exit();
	// 	}
	// }

	// Buat folder gambar untuk mengunggah gambar
	$itemImageFolder = $baseImageFolder . $itemNumber;
	if (is_dir($itemImageFolder)) {
		// Folder sudah ada. Oleh karena itu, jangan lakukan apa pun
	} else {
		// Folder tidak ada, Oleh karena itu, buatlah
		mkdir($itemImageFolder);
	}
	// $vendorIDsql = 'SELECT * FROM vendor WHERE fullName = :fullName';
	// $vendorIDStatement = $conn->prepare($vendorIDsql);
	// $vendorIDStatement->execute(['fullName' => $purchaseDetailsVendorName]);
	// $row = $vendorIDStatement->fetch(PDO::FETCH_ASSOC);
	// $vendorID = $row['vendorID'];

	// Menghitung nilai barang 
	$stockSql = 'SELECT stock FROM item WHERE itemNumber=:itemNumber';
	$stockStatement = $conn->prepare($stockSql);
	$stockStatement->execute(['itemNumber' => $itemNumber]);
	if ($stockStatement->rowCount() > 0) {
		//$row = $stockStatement->fetch(PDO::FETCH_ASSOC);
		//$quantity = $quantity + $row['stock'];
		echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Item already exists in DB. Please click the <strong>Update</strong> button to update the details. Or use a different Item Number.</div>';
		exit();
	} else {
		// Item tidak ada, oleh karena itu, Anda dapat menambahkannya ke DB sebagai item baru
		// Mulai proses penambahan barang
		$insertItemSql = 'INSERT INTO item(itemNumber, itemName, stock, description) VALUES(:itemNumber, :itemName,:stock, :description)';
		$insertItemStatement = $conn->prepare($insertItemSql);
		$insertItemStatement->execute(['itemNumber' => $itemNumber, 'itemName' => $itemName, 'stock' => $quantity, 'description' => $description]);
		echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button>Item added to database.</div>';
		exit();
	}
} else {
	// Satu atau beberapa kolom wajib kosong. Oleh karena itu, tampilkan pesan kesalahan
	echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">&times;</button>Please enter all fields marked with a (*)</div>';
	exit();
}
