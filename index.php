<?php
session_start();
// Redirect the user to login page if he is not logged in.
if (!isset($_SESSION['loggedIn'])) {
	header('Location: login.php');
	exit();
}

require_once('inc/config/constants.php');
require_once('inc/config/db.php');
require_once('inc/header.html');
?>

<body>
	<?php
	require 'inc/navigation.php';
	?>
	<!-- Page Content -->
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-2">
				<h1 class="my-4"></h1>
				<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
					<a class="nav-link active" id="v-pills-item-tab" data-toggle="pill" href="#v-pills-item" role="tab" aria-controls="v-pills-item" aria-selected="true">Barang</a>
					<a class="nav-link" id="v-pills-purchase-tab" data-toggle="pill" href="#v-pills-purchase" role="tab" aria-controls="v-pills-purchase" aria-selected="false">Barang Masuk</a>
					<a class="nav-link" id="v-pills-sale-tab" data-toggle="pill" href="#v-pills-sale" role="tab" aria-controls="v-pills-sale" aria-selected="false">Barang Keluar</a>
					<a class="nav-link" id="v-pills-vendor-tab" data-toggle="pill" href="#v-pills-vendor" role="tab" aria-controls="v-pills-vendor" aria-selected="false">Supplier</a>
					<a class="nav-link" id="v-pills-customer-tab" data-toggle="pill" href="#v-pills-customer" role="tab" aria-controls="v-pills-customer" aria-selected="false">Peminta</a>
					<a class="nav-link" id="v-pills-search-tab" data-toggle="pill" href="#v-pills-search" role="tab" aria-controls="v-pills-search" aria-selected="false">Cari</a>
					<a class="nav-link" id="v-pills-reports-tab" data-toggle="pill" href="#v-pills-reports" role="tab" aria-controls="v-pills-reports" aria-selected="false">Laporan</a>
				</div>
			</div>
			<div class="col-lg-10">
				<div class="tab-content" id="v-pills-tabContent">
					<div class="tab-pane fade show active" id="v-pills-item" role="tabpanel" aria-labelledby="v-pills-item-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Detail Barang </div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#itemDetailsTab">Barang</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#itemImageTab">Unggah Gambar Barang</a>
									</li>
								</ul>

								<!-- Tab panes for item details and image sections -->
								<div class="tab-content">
									<div id="itemDetailsTab" class="container-fluid tab-pane active">
										<br>
										<!-- Div to show the ajax message from validations/db submission -->
										<div id="itemDetailsMessage"></div>
										<form>
											<div class="form-row">
												<div class="form-group col-md-3" style="display:inline-block">
													<label for="itemDetailsItemNumber">Nomor Barang<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" name="itemDetailsItemNumber" id="itemDetailsItemNumber" autocomplete="off">
													<div id="itemDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<!-- <div class="form-group col-md-3">
													<label for="itemDetailsDate">Incoming Goods Date<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control datepicker" id="itemDetailsDate" name="itemDetailsDate" readonly value="yyyy-mm-dd">
												</div> -->
												<div class="form-group col-md-3">
													<label for="itemDetailsProductID">ID Barang</label>
													<input class="form-control invTooltip" type="number" readonly id="itemDetailsProductID" name="itemDetailsProductID" title="This will be auto-generated when you add a new item">
												</div>

											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label for="itemDetailsItemName">Nama Barang<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" name="itemDetailsItemName" id="itemDetailsItemName" autocomplete="off">
													<div id="itemDetailsItemNameSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<!-- <div class="form-group col-md-2">
													<label for="itemDetailsStatus">Status</label>
													<select id="itemDetailsStatus" name="itemDetailsStatus" class="form-control chosenSelect">
														?php include('inc/statusList.html'); ?>
													</select>
												</div> -->
											</div>
											<div class="form-row">
												<div class="form-group col-md-6" style="display:inline-block">
													<!-- <label for="itemDetailsDescription">Description</label> -->
													<textarea rows="4" class="form-control" placeholder="Deskripsi" name="itemDetailsDescription" id="itemDetailsDescription"></textarea>
												</div>
											</div>
											<div class="form-row">
												<!-- <div class="form-group col-md-3">
													<label for="itemDetailsDiscount">Discount %</label>
													<input type="text" class="form-control" value="0" name="itemDetailsDiscount" id="itemDetailsDiscount">
												</div> -->
												<div class="form-group col-md-4">
													<label for="vendorDetailsName">Nama Supplier<span class="requiredIcon">*</span></label>
													<select id="vendorDetailsName" name="vendorDetailsName" class="form-control chosenSelect">
														<?php
														require('model/vendor/getVendorNames.php');
														?>
													</select>
												</div>
												<div class="form-group col-md-3">
													<label for="itemDetailsQuantity">Jumlah<span class="requiredIcon">*</span></label>
													<input type="number" class="form-control" value="0" name="itemDetailsQuantity" id="itemDetailsQuantity">
												</div>
												<!-- <div class="form-group col-md-3">
													<label for="itemDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" value="0" name="itemDetailsUnitPrice" id="itemDetailsUnitPrice">
												</div> -->
												<div class="form-group col-md-3">
													<label for="itemDetailsTotalStock">Stok</label>
													<input type="text" class="form-control" name="itemDetailsTotalStock" id="itemDetailsTotalStock" readonly>
												</div>
												<div class="form-group col-md-3">
													<div id="imageContainer"></div>
												</div>
											</div>
											<button type="button" id="addItem" class="btn btn-success">Tambahkan Barang</button>
											<!-- <button type="button" id="updateItemDetailsButton" class="btn btn-primary">Perbarui</button> -->
											<button type="button" id="deleteItem" class="btn btn-danger">Hapus</button>
											<button type="reset" class="btn" id="itemClear">Bersihkan</button>
										</form>
									</div>
									<div id="itemImageTab" class="container-fluid tab-pane fade">
										<br>
										<div id="itemImageMessage"></div>
										<p>You can upload an image for a particular item using this section.</p>
										<p>Please make sure the item is already added to database before uploading the image.</p>
										<br>
										<form name="imageForm" id="imageForm" method="post">
											<div class="form-row">
												<div class="form-group col-md-3" style="display:inline-block">
													<label for="itemImageItemNumber">Nomor Barang<span class="requiredIcon">*</span></label>
													<input type="text" class="form-control" name="itemImageItemNumber" id="itemImageItemNumber" autocomplete="off">
													<div id="itemImageItemNumberSuggestionsDiv" class="customListDivWidth"></div>
												</div>
												<div class="form-group col-md-4">
													<label for="itemImageItemName">Nama Barang</label>
													<input type="text" class="form-control" name="itemImageItemName" id="itemImageItemName" readonly>
												</div>
											</div>
											<br>
											<div class="form-row">
												<div class="form-group col-md-7">
													<label for="itemImageFile">Pilih Gambar ( <span class="blueText">jpg</span>, <span class="blueText">jpeg</span>, <span class="blueText">gif</span>, <span class="blueText">png</span> only )</label>
													<input type="file" class="form-control-file btn btn-dark" id="itemImageFile" name="itemImageFile">
												</div>
											</div>
											<br>
											<button type="button" id="updateImageButton" class="btn btn-primary">Unggah Gambar</button>
											<button type="button" id="deleteImageButton" class="btn btn-danger">Hapus Gambar</button>
											<button type="reset" class="btn">Bersihkan</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="v-pills-purchase" role="tabpanel" aria-labelledby="v-pills-purchase-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Detail Barang Masuk</div>
							<div class="card-body">
								<div id="purchaseDetailsMessage"></div>
								<form>
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="purchaseDetailsItemNumber">Nomor Barang<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="purchaseDetailsItemNumber" name="purchaseDetailsItemNumber" autocomplete="off">
											<div id="purchaseDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
										</div>
										<div class="form-group col-md-3">
											<label for="purchaseDetailsPurchaseDate">Tanggal Barang Masuk<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control datepicker" id="purchaseDetailsPurchaseDate" name="purchaseDetailsPurchaseDate" readonly value="yyyy-mm-dd">
										</div>
										<div class="form-group col-md-2">
											<label for="purchaseDetailsPurchaseID">ID Barang Masuk</label>
											<input type="text" class="form-control invTooltip" id="purchaseDetailsPurchaseID" name="purchaseDetailsPurchaseID" title="This will be auto-generated when you add a new record" autocomplete="off">
											<div id="purchaseDetailsPurchaseIDSuggestionsDiv" class="customListDivWidth"></div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-4">
											<label for="purchaseDetailsItemName">Nama Barang<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control invTooltip" id="purchaseDetailsItemName" name="purchaseDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
										</div>
										<div class="form-group col-md-2">
											<label for="purchaseDetailsCurrentStock">Sisa Stok</label>
											<input type="text" class="form-control" id="purchaseDetailsCurrentStock" name="purchaseDetailsCurrentStock" readonly>
										</div>
										<div class="form-group col-md-4">
											<label for="purchaseDetailsVendorName">Nama Supplier<span class="requiredIcon">*</span></label>
											<select id="purchaseDetailsVendorName" name="purchaseDetailsVendorName" class="form-control chosenSelect">
												<?php
												require('model/vendor/getVendorNames.php');
												?>
											</select>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-2">
											<label for="purchaseDetailsQuantity">Jumlah<span class="requiredIcon">*</span></label>
											<input type="number" class="form-control" id="purchaseDetailsQuantity" name="purchaseDetailsQuantity" value="0">
										</div>
										<!-- <div class="form-group col-md-2">
											<label for="purchaseDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="purchaseDetailsUnitPrice" name="purchaseDetailsUnitPrice" value="0">

										</div> -->
										<!-- <div class="form-group col-md-2">
											<label for="purchaseDetailsTotal">Total Cost</label>
											<input type="text" class="form-control" id="purchaseDetailsTotal" name="purchaseDetailsTotal" readonly>
										</div> -->
									</div>
									<button type="button" id="addPurchase" class="btn btn-success">Tambahkan Barang Masuk</button>
									<button type="button" id="updatePurchaseDetailsButton" class="btn btn-primary">Perbarui</button>
									<button type="reset" class="btn">Bersihkan</button>
								</form>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-vendor" role="tabpanel" aria-labelledby="v-pills-vendor-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Detail Supplier</div>
							<div class="card-body">
								<!-- Div to show the ajax message from validations/db submission -->
								<div id="vendorDetailsMessage"></div>
								<form>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="vendorDetailsVendorFullName">Nama Supplier<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="vendorDetailsVendorFullName" name="vendorDetailsVendorFullName" placeholder="">
										</div>
										<!-- <div class="form-group col-md-2">
											<label for="vendorDetailsStatus">Status</label>
											<select id="vendorDetailsStatus" name="vendorDetailsStatus" class="form-control chosenSelect">
												?php include('inc/statusList.html'); ?>
											</select>
										</div> -->
										<div class="form-group col-md-3">
											<label for="vendorDetailsVendorID">ID Supplier</label>
											<input type="text" class="form-control invTooltip" id="vendorDetailsVendorID" name="vendorDetailsVendorID" title="This will be auto-generated when you add a new vendor" autocomplete="off">
											<div id="vendorDetailsVendorIDSuggestionsDiv" class="customListDivWidth"></div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="vendorDetailsVendorMobile">Telp<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control invTooltip" id="vendorDetailsVendorMobile" name="vendorDetailsVendorMobile" title="Do not enter leading 0">
										</div>
										<!-- <div class="form-group col-md-3">
											<label for="vendorDetailsVendorPhone2">Phone 2</label>
											<input type="text" class="form-control invTooltip" id="vendorDetailsVendorPhone2" name="vendorDetailsVendorPhone2" title="Do not enter leading 0">
										</div> -->
										<div class="form-group col-md-6">
											<label for="vendorDetailsVendorEmail">Email</label>
											<input type="email" class="form-control" id="vendorDetailsVendorEmail" name="vendorDetailsVendorEmail">
										</div>
									</div>
									<div class="form-group">
										<label for="vendorDetailsVendorAddress">Alamat<span class="requiredIcon">*</span></label>
										<input type="text" class="form-control" id="vendorDetailsVendorAddress" name="vendorDetailsVendorAddress">
									</div>
									<div class="form-group">
										<label for="vendorDetailsVendorAddress2">Alamat 2</label>
										<input type="text" class="form-control" id="vendorDetailsVendorAddress2" name="vendorDetailsVendorAddress2">
									</div>
									<div class="form-row">
										<!-- <div class="form-group col-md-6">
											<label for="vendorDetailsVendorCity">City</label>
											<input type="text" class="form-control" id="vendorDetailsVendorCity" name="vendorDetailsVendorCity">
										</div> -->
										<!-- <div class="form-group col-md-4">
											<label for="vendorDetailsVendorDistrict">Department</label>
											<select id="vendorDetailsVendorDistrict" name="vendorDetailsVendorDistrict" class="form-control chosenSelect">
												?php include('inc/districtList.html'); ?>
											</select>
										</div> -->
									</div>
									<button type="button" id="addVendor" name="addVendor" class="btn btn-success">Tambahkan Supplier</button>
									<button type="button" id="updateVendorDetailsButton" class="btn btn-primary">Perbarui</button>
									<button type="button" id="deleteVendorButton" class="btn btn-danger">Hapus</button>
									<button type="reset" class="btn">Bersihkan</button>
								</form>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-sale" role="tabpanel" aria-labelledby="v-pills-sale-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Detail Barang Keluar</div>
							<div class="card-body">
								<div id="saleDetailsMessage"></div>
								<form>
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="saleDetailsItemNumber">Nomor Barang<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="saleDetailsItemNumber" name="saleDetailsItemNumber" autocomplete="off">
											<div id="saleDetailsItemNumberSuggestionsDiv" class="customListDivWidth"></div>
										</div>
										<div class="form-group col-md-3">
											<label for="saleDetailsCustomerID">ID Peminta<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="saleDetailsCustomerID" name="saleDetailsCustomerID" autocomplete="off">
											<div id="saleDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
										</div>
										<div class="form-group col-md-4">
											<label for="saleDetailsCustomerName">Nama Peminta</label>
											<input type="text" class="form-control" id="saleDetailsCustomerName" name="saleDetailsCustomerName" readonly>
										</div>
										<div class="form-group col-md-2">
											<label for="saleDetailsSaleID">ID Barang Keluar</label>
											<input type="text" class="form-cobntrol invTooltip" id="saleDetailsSaleID" name="saleDetailsSaleID" title="This will be auto-generated when you add a new record" autocomplete="off">
											<div id="saleDetailsSaleIDSuggestionsDiv" class="customListDivWidth"></div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-5">
											<label for="saleDetailsItemName">Nama Barang</label>
											<!--<select id="saleDetailsItemNames" name="saleDetailsItemNames" class="form-control chosenSelect"> -->
											<?php
											//require('model/item/getItemDetails.php');
											?>
											<!-- </select> -->
											<input type="text" class="form-control invTooltip" id="saleDetailsItemName" name="saleDetailsItemName" readonly title="This will be auto-filled when you enter the item number above">
										</div>
										<div class="form-group col-md-3">
											<label for="saleDetailsSaleDate">Tanggal Barang Susulan<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control datepicker" id="saleDetailsSaleDate" value="yyyy-mm-dd" name="saleDetailsSaleDate" readonly>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-2">
											<label for="saleDetailsTotalStock">Stok</label>
											<input type="text" class="form-control" name="saleDetailsTotalStock" id="saleDetailsTotalStock" readonly>
										</div>
										<!-- <div class="form-group col-md-2">
											<label for="saleDetailsDiscount">Discount %</label>
											<input type="text" class="form-control" id="saleDetailsDiscount" name="saleDetailsDiscount" value="0">
										</div> -->
										<div class="form-group col-md-2">
											<label for="saleDetailsQuantity">Jumlah<span class="requiredIcon">*</span></label>
											<input type="number" class="form-control" id="saleDetailsQuantity" name="saleDetailsQuantity" value="0">
										</div>
										<!-- <div class="form-group col-md-2">
											<label for="saleDetailsUnitPrice">Unit Price<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="saleDetailsUnitPrice" name="saleDetailsUnitPrice" value="0">
										</div>
										<div class="form-group col-md-3">
											<label for="saleDetailsTotal">Total</label>
											<input type="text" class="form-control" id="saleDetailsTotal" name="saleDetailsTotal">
										</div> -->
									</div>
									<div class="form-row">
										<div class="form-group col-md-3">
											<div id="saleDetailsImageContainer"></div>
										</div>
									</div>
									<button type="button" id="addSaleButton" class="btn btn-success">Tambahkan Barang Susulan</button>
									<button type="button" id="updateSaleDetailsButton" class="btn btn-primary">Perbarui</button>
									<button type="reset" id="saleClear" class="btn">Bersihkan</button>
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="v-pills-customer" role="tabpanel" aria-labelledby="v-pills-customer-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Detail Peminta</div>
							<div class="card-body">
								<!-- Div to show the ajax message from validations/db submission -->
								<div id="customerDetailsMessage"></div>
								<form>
									<div class="form-row">
										<div class="form-group col-md-6">
											<label for="customerDetailsCustomerFullName">Nama<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control" id="customerDetailsCustomerFullName" name="customerDetailsCustomerFullName">
										</div>
										<!-- <div class="form-group col-md-2">
											<label for="customerDetailsStatus">Status</label>
											<select id="customerDetailsStatus" name="customerDetailsStatus" class="form-control chosenSelect">
												?php include('inc/statusList.html'); ?>
											</select>
										</div> -->
										<div class="form-group col-md-3">
											<label for="customerDetailsCustomerID">ID Peminta</label>
											<input type="text" class="form-control invTooltip" id="customerDetailsCustomerID" name="customerDetailsCustomerID" title="This will be auto-generated when you add a new customer" autocomplete="off">
											<div id="customerDetailsCustomerIDSuggestionsDiv" class="customListDivWidth"></div>
										</div>
									</div>
									<div class="form-row">
										<div class="form-group col-md-3">
											<label for="customerDetailsCustomerMobile">Telp<span class="requiredIcon">*</span></label>
											<input type="text" class="form-control invTooltip" id="customerDetailsCustomerMobile" name="customerDetailsCustomerMobile" title="Do not enter leading 0">
										</div>
										<!-- <div class="form-group col-md-3">
											<label for="customerDetailsCustomerPhone2">Phone 2</label>
											<input type="text" class="form-control invTooltip" id="customerDetailsCustomerPhone2" name="customerDetailsCustomerPhone2" title="Do not enter leading 0">
										</div> -->
										<div class="form-group col-md-6">
											<label for="customerDetailsCustomerEmail">Email</label>
											<input type="email" class="form-control" id="customerDetailsCustomerEmail" name="customerDetailsCustomerEmail">
										</div>
									</div>
									<!-- <div class="form-group">
										<label for="customerDetailsCustomerAddress">Address<span class="requiredIcon">*</span></label>
										<input type="text" class="form-control" id="customerDetailsCustomerAddress" name="customerDetailsCustomerAddress">
									</div>
									<div class="form-group">
										<label for="customerDetailsCustomerAddress2">Address 2</label>
										<input type="text" class="form-control" id="customerDetailsCustomerAddress2" name="customerDetailsCustomerAddress2">
									</div> -->
									<div class="form-row">
										<!-- <div class="form-group col-md-6">
											<label for="customerDetailsCustomerCity">City</label>
											<input type="text" class="form-control" id="customerDetailsCustomerCity" name="customerDetailsCustomerCity">
										</div> -->
										<div class="form-group col-md-4">
											<label for="customerDetailsCustomerDistrict">Departemen</label>
											<select id="customerDetailsCustomerDistrict" name="customerDetailsCustomerDistrict" class="form-control chosenSelect">
												<?php include('inc/districtList.html'); ?>
											</select>
										</div>
									</div>
									<button type="button" id="addCustomer" name="addCustomer" class="btn btn-success">Tambahkan Peminta</button>
									<button type="button" id="updateCustomerDetailsButton" class="btn btn-primary">Perbarui</button>
									<button type="button" id="deleteCustomerButton" class="btn btn-danger">Hapus</button>
									<button type="reset" class="btn">Bersihkan</button>
								</form>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-search" role="tabpanel" aria-labelledby="v-pills-search-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Mencari Inventaris<button id="searchTablesRefresh" name="searchTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#itemSearchTab">Barang</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#customerSearchTab">Peminta</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#saleSearchTab">Barang Keluar</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#purchaseSearchTab">Barang Masuk</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#vendorSearchTab">Supplier</a>
									</li>
								</ul>

								<!-- Tab panes -->
								<div class="tab-content">
									<div id="itemSearchTab" class="container-fluid tab-pane active">
										<br>
										<p>Gunakan grid di bawah ini untuk mencari semua detail barang</p>
										<!-- <a href="#" class="itemDetailsHover" data-toggle="popover" id="10">wwwee</a> -->
										<div class="table-responsive" id="itemDetailsTableDiv"></div>
									</div>
									<div id="customerSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search all details of customers</p>
										<div class="table-responsive" id="customerDetailsTableDiv"></div>
									</div>
									<div id="saleSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search sale details</p>
										<div class="table-responsive" id="saleDetailsTableDiv"></div>
									</div>
									<div id="purchaseSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search purchase details</p>
										<div class="table-responsive" id="purchaseDetailsTableDiv"></div>
									</div>
									<div id="vendorSearchTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to search vendor details</p>
										<div class="table-responsive" id="vendorDetailsTableDiv"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
						<div class="card card-outline-secondary my-4">
							<div class="card-header">Laporan<button id="reportsTablesRefresh" name="reportsTablesRefresh" class="btn btn-warning float-right btn-sm">Refresh</button></div>
							<div class="card-body">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" data-toggle="tab" href="#itemReportsTab">Barang</a>
									</li>
									<!-- <li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#customerReportsTab">Peminta</a>
									</li> -->
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#saleReportsTab">Barang Keluar</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#purchaseReportsTab">Barang Masuk</a>
									</li>
									<!-- <li class="nav-item">
										<a class="nav-link" data-toggle="tab" href="#vendorReportsTab">Supplier</a>
									</li> -->
								</ul>

								<!-- Tab panes for reports sections -->
								<div class="tab-content">
									<div id="itemReportsTab" class="container-fluid tab-pane active">
										<br>
										<p>Use the grid below to get reports for items</p>
										<div class="table-responsive" id="itemReportsTableDiv"></div>
									</div>
									<div id="customerReportsTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to get reports for customers</p>
										<div class="table-responsive" id="customerReportsTableDiv"></div>
									</div>
									<div id="saleReportsTab" class="container-fluid tab-pane fade">
										<br>
										<!-- <p>Use the grid below to get reports for sales</p> -->
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="saleReportStartDate">Tanggal Mulai</label>
													<input type="text" class="form-control datepicker" id="saleReportStartDate" value="yyyy-mm-dd" name="saleReportStartDate" readonly>
												</div>
												<div class="form-group col-md-3">
													<label for="saleReportEndDate">Tanggal akhir</label>
													<input type="text" class="form-control datepicker" id="saleReportEndDate" value="yyyy-mm-dd" name="saleReportEndDate" readonly>
												</div>
											</div>
											<button type="button" id="showSaleReport" class="btn btn-dark">Tampilkan Laporan</button>
											<button type="reset" id="saleFilterClear" class="btn">Bersihkan</button>
										</form>
										<br><br>
										<div class="table-responsive" id="saleReportsTableDiv"></div>
									</div>
									<div id="purchaseReportsTab" class="container-fluid tab-pane fade">
										<br>
										<!-- <p>Use the grid below to get reports for purchases</p> -->
										<form>
											<div class="form-row">
												<div class="form-group col-md-3">
													<label for="purchaseReportStartDate">Tanggal mulai</label>
													<input type="text" class="form-control datepicker" id="purchaseReportStartDate" value="yyyy-mm-dd" name="purchaseReportStartDate" readonly>
												</div>
												<div class="form-group col-md-3">
													<label for="purchaseReportEndDate">Tanggal akhir</label>
													<input type="text" class="form-control datepicker" id="purchaseReportEndDate" value="yyyy-mm-dd" name="purchaseReportEndDate" readonly>
												</div>
											</div>
											<button type="button" id="showPurchaseReport" class="btn btn-dark">Tampilkan Laporan</button>
											<button type="reset" id="purchaseFilterClear" class="btn">Bersihkan</button>
										</form>
										<br><br>
										<div class="table-responsive" id="purchaseReportsTableDiv"></div>
									</div>
									<div id="vendorReportsTab" class="container-fluid tab-pane fade">
										<br>
										<p>Use the grid below to get reports for vendors</p>
										<div class="table-responsive" id="vendorReportsTableDiv"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	require 'inc/footer.php';
	?>
</body>

</html>