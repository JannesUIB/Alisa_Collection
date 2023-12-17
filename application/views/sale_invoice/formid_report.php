<?php
	$subtotal = 0;
	$dicount_total = 0;
	$sale_total = 0;
	$debit_total = 0;
	$credit_total = 0;
	$balance = 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Sales Invoice | Report</title>
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
		<?php foreach($sale_invoice_record as $rec){?>
		<div class="d-flex flex-row">
			<div class="p-2"><button class="btn btn-secondary" id="print_button" style="width:90px;text-decoration:none;" href="">Print</button></div>
			<div class="p-2"><a class="btn btn-secondary" id="print_button" style="width:180px;text-decoration:none;" href="<?php echo site_url('SalesInvoice/formselectedid/'. $rec->ID); ?>">Back To Sales Invoice</a></div>
		</div>
		<div class="container" style="height:100vh; padding:20px;" id="content">
			<div class="row">
				<div class="col text-center">
					<h1>Ailisa Collection</h1>
				</div>
			</div><div class="row">
				<div class="col text-right">
					<h2>Sales Invoice</h2>
				</div>
			</div>
			<div class="row">
				<div class="col d-flex flex-row">
					<h4>Customer Name</h4>
					<h4>:</h4>
					<h4><?php echo $rec->Customer ?></h4>
				</div>
				<div class="col d-flex flex-row-reverse">
					<h4><?php echo $rec->Sale_Invoice_Name ?></h4>
					<h4>:</h4>
					<h4>Sales Invoice Name</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-6 d-flex flex-row ">
					<h4>Created Date</h4>
					<h4>:</h4>
					<h4><?php echo $rec->Create_Date; ?></h4>
				</div>
				<div class="col-6 d-flex flex-row-reverse">
					<h4><?php echo $rec->Sale_ID ?></h4>
					<h4>:</h4>
					<h4>Sales ID</h4>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="">
						<form id="sale_form" method="POST" action="<?php echo site_url('Sales/AddSales'); ?>">
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
									<table id="table_sol" class="table table-sm table-bordered border-dark" class="padding:10px">
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
													$debit_total += $reco->Debit;
													$credit_total += $reco->Credit;
													// $subtotal += $reco->Quantity * $reco->Price;
													// $dicount_total += ($reco->Quantity * $reco->Price) * $reco->Discount / 100;	
												}
												// $sale_total += $subtotal - $dicount_total;?>
												<tr>
													<td class="border-0" />
													<td class="border-0" />
													<td class="border-bottom border-top-0 border-right-0 border-left-0 border-dark"><strong>Debit Total</strong></td>
													<td class="border-bottom border-top-0 border-right-0 border-left-0 border-dark"><span>Rp.</span><?php  echo "<span style='float:right'>" . number_format($debit_total,2,',','.'). "</span>" ?>  </td>
												</tr>
												<tr class="">
													<td class="border-0" />
													<td class="border-0" />
													<td class="border-bottom border-top-0 border-right-0 border-left-0 border-dark"><strong>Credit Total</strong></td>
													<td class="border-bottom border-top-0 border-right-0 border-left-0 border-dark"><span>Rp.</span><?php  echo "<span style='float:right'>" . number_format($credit_total,2,',','.'). "</span>" ?>  </td>
												</tr>
												<tr>
													<td class="border-0" />
													<td class="border-0" />
													<td class="border-bottom border-top-0 border-right-0 border-left-0 border-dark"><strong>Balance</strong></td>
													<td class="border-bottom border-top-0 border-right-0 border-left-0 border-dark"><span>Rp.</span><?php  echo "<span style='float:right'>" . number_format($debit_total - $credit_total,2,',','.'). "</span>" ?>  </td>
												</tr>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
	<script>
		const btn = document.getElementById("print_button");

		btn.addEventListener("click", function(){
		console.log("im in");
		var element = document.getElementById('content');
		html2pdf().from(element).save('SalesInvoice.pdf');
		});
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
