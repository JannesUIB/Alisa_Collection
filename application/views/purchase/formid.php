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
		<title>Purchase | Form</title>
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
		<?php foreach($purchase_record as $rec){?>
		<div class="container shadow p-3 mb-3 mt-5 bg-white rounded">
			<div class="row">
				<div class="col">
					<div class="d-flex flex-row">
						<div class="p-2"><a class="btn btn-primary" style="width:90px;text-decoration:none;" href="<?php echo site_url('Purchase/edit/'. $rec->ID); ?>">Edit</a></div>
						<div class="p-2"><a class="btn btn-danger"  style="width:90px;text-decoration:none;" href="<?php echo site_url('Purchase/delete/'. $rec->ID); ?>">Delete</a></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h1>Sales Order</h1>
					<div class="">
						<form id="sale_form" method="POST" action="<?php echo site_url('Sales/AddSales'); ?>">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Purchase Order ID" value="<?php echo $rec->ID?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;height:80px;font-size:24px; width:50%" readonly>
							</div>
							<div class="form-group">
								<Label>Vendor</label>
								<input type="text" class="form-control" placeholder="Vendor Name" name="customer_name" value="<?php echo $rec->Customer_Name?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;width:30% " readonly>
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
												<th class="d-none" id="SOl_ID">SOL ID</th>
												<th id="Item_ID">Product</th>
												<th id="Quantity">Quantity</th>
												<th id="Price">Price</th>
												<th id="Discount">Disc(%)</th>
												<th>Subtotal</th>
											</tr>
										</thead>
										<tbody>
												<?php foreach($purchase_order_line_record as $reco){
													echo "<tr>";
													echo "<td class='d-none'>" .  $reco->ID . "</td>" ;
													echo "<td>" . $reco->Item_Name . "</td>" ;
													echo "<td>" . $reco->Quantity . "</td>" ;
													echo "<td>" . number_format($reco->Price,2,',','.') . "</td>" ;
													echo "<td>" . $reco->Discount."</td>" ;
													echo "<td>" . number_format($reco->Quantity * $reco->Price,2,',','.') ."</td>" ;
													echo "</tr>";
													$subtotal += $reco->Quantity * $reco->Price;
													$dicount_total += ($reco->Quantity * $reco->Price) * $reco->Discount / 100;
													
												} $sale_total += $subtotal - $dicount_total;?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<div class="d-flex flex-row-reverse">
										<table class="table table-sm table-borderless">
											<tr>
												<td rowspan="3"><textarea class="form-control border-top-0 border-right-0 border-left-0 border-bottom border-dark" rows="3" placeholder="Purchase Note" style="resize:none;" readonly></textarea></td>
												<td class="text-right">Subtotal</td>
												<td style="width:1%;">:</td>
												<td id="sale_subtotal"><?php echo number_format($subtotal,2,',','.')  ?></td>
											</tr>
											<tr>
												<td  class="text-right">Discount</td>
												<td style="width:1%;">:</td>
												<td id="sale_discount"><?php echo number_format($dicount_total,2,',','.')  ?></td>
											</tr>
											<tr>
												<td  class="text-right"><h5>Sales Total</h5></td>
												<td style="width:1%;">:</td>
												<td id="sales_total"><?php echo number_format($sale_total,2,',','.') ?></td>
											</tr>
										</table>
									</div>
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
