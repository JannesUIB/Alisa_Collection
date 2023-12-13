<?php
	$subtotal = 0;
	$dicount_total = 0;
	$sale_total = 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Sales</title>
	</head>
	<style>
		div.row div.col table.table-bordered tr td{
			height:30px;
			border:  0.5px solid grey;
		}
		div.row div.col table.table-bordered tr th{
			height:30px;
			border: 0.5px solid grey;
		}
	</style>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light" style="background-color:#c1adcc;">
			<a class="navbar-brand" style="color:white;" href="#">Modules</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse navv" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" style="color:white;" href="#">Sales</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:white;" href="#">Purchase</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:white;" href="#">Inventory</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:white;" href="#">Accounting Reporting</a>
					</li>
				</ul>
			</div>
		</nav>
		<?php foreach($sale_invoice_record as $rec){?>
		<div class="container shadow p-3 mb-3 mt-5 bg-white rounded">
			<div class="row">
				<div class="col">
					<div class="d-flex flex-row">
						<div class="p-2"><a class="btn btn-secondary"  style="width:90px;text-decoration:none;" href="<?php echo site_url('SalesInvoice/Print/'. $rec->ID); ?>">Print</a></div>
						<div class="p-2"><a class="btn btn-danger"  style="width:90px;text-decoration:none;" href="<?php echo site_url('SalesInvoice/delete/'. $rec->ID); ?>">Delete</a></div>
						<div class="ml-auto p-2"><a class="btn btn-info"  style="width:150px;text-decoration:none;" href="<?php echo site_url('SalesInvoice/GoToSaleOrder/'. $rec->Sale_ID); ?>">Go Back To Sales</a></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="">
						<form id="sale_form" method="POST" action="<?php echo site_url('Sales/AddSales'); ?>">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Sales Order ID" value="<?php echo $rec->ID?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;height:80px;font-size:24px; width:50%" readonly>
							</div>
							<div class="form-group">
								<Label>Customer</label>
								<input type="text" class="form-control" placeholder="Customer Name" name="customer_name" value="<?php echo $rec->Customer?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;width:30% " readonly>
							</div>
							<!-- <h3>Item's Details</h3>
							<div class="row">
								<div class="col">
									<Label>Item's Name</label>
									<input type="text" class="form-control" placeholder="Item's Name" id="item_name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
								<div class="col">
									<Label>Quantity</label>
									<input type="text" class="form-control" placeholder="Quantity" id="item_quantity" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
							</div>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<Label>Price</label>
									<input type="text" class="form-control" placeholder="Price" id="item_price" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
								<div class="col">
									<Label>Discount(%)</label>
									<input type="text" class="form-control" placeholder="Discount (%)" id="item_discount" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
							</div> -->
							<!-- <button type="button" class="btn btn-info btn-lg btn-block" id="insert_item" style="margin-top:10px;">Insert Item Details</button> -->
							<div class="row" style="margin-top:10px;"> 
								<div class="col">
									<table id="table_sol" class="table table-sm table-bordered border-dark">
										<thead>
											<tr>
												<th class="d-none" id="SIL_ID">SIL ID</th>
												<th id="Account_Code">Account Code</th>
												<th id="Description">Description</th>
												<th id="Debit">Debit</th>
												<th id="Credit">Credit</th>
												<!-- <th>Balance</th> -->
											</tr>
										</thead>
										<tbody>
												<?php foreach($sale_invoice_line_record as $reco){
													echo "<tr>";
													echo "<td class='d-none'>" .  $reco->ID . "</td>" ;
													echo "<td>" . $reco->Account_Codes . " " .$reco->Account_Name . "</td>" ;
													echo "<td>" . $reco->Description . "</td>" ;
													echo "<td>" . number_format($reco->Debit,2,',','.') . "</td>" ;
													echo "<td>" . number_format($reco->Credit,2,',','.')."</td>" ;
													// echo "<td>" . number_format($reco->Quantity * $reco->Price,2,',','.') ."</td>" ;
													echo "</tr>";
													// $subtotal += $reco->Quantity * $reco->Price;
													// $dicount_total += ($reco->Quantity * $reco->Price) * $reco->Discount / 100;	
												}
												// $sale_total += $subtotal - $dicount_total;?>
										</tbody>
									</table>
								</div>
							</div>
							<!-- <button type="button" onclick="submitForm()" class="btn btn-info btn-lg btn-block" style="margin-top:10px;">Create Sale</button> -->
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
