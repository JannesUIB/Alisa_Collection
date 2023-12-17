<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Sales | Create</title>
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
			<a class="navbar-brand" style="color:white;" href="<?php echo site_url('Welcome'); ?>">Modules</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse navv" id="navbarNavDropdown">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" style="color:white;"  href="<?php echo site_url('Sales/index'); ?>">Sales</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:white;"  href="<?php echo site_url('Purchase/index'); ?>">Purchase</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:white;"  href="<?php echo site_url('Inventory/index'); ?>">Inventory</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" style="color:white;"  href="<?php echo site_url('Accounting/index'); ?>">Accounting Reporting</a>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container shadow p-3 mb-3 mt-5 bg-white rounded">
			<!-- <div class="row">
				<div class="col">
					<div class="d-flex flex-row">
						<div class="p-2"><button type="button" class="btn btn-primary" style="width:90px;">Edit</button></div>
						<div class="p-2"><button type="button" class="btn btn-danger"  style="width:90px;">Delete</button></div>
					</div>
				</div>
			</div> -->
			<div class="row">
				<div class="col">
					<h1>Quotation</h1>
					<div class="">
						<form id="sales_form" method="POST" action="<?php echo site_url('Sales/AddSales'); ?>">
							<div class="form-group">
								<input type="text" class="form-control" name="sale_name" placeholder="Sales Order Name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;height:80px;font-size:24px; width:50%">
							</div>
							<div class="form-group">
								<Label>Customer</label>
								<input type="text" class="form-control" name="customer_name" placeholder="Customer Name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;width:30% ">
							</div>
							<h3>Item's Details</h3>
							<div class="row">
								<div class="col">
									<Label>Item's Name</label>
									<!-- <input type="text" class="form-control" placeholder="Item's Name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;"> -->
									<select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
										<?php foreach($inventory_records as $inventory) {
											echo "<option value='" . $inventory->ID . "'>" . $inventory->Item_Name . "</option>";
										}
										?>
									</select>
								</div>
								<div class="col">
									<Label>Quantity</label>
									<input type="text" class="form-control" id="item_quantity" placeholder="Quantity" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
							</div>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<Label>Price</label>
									<input type="text" class="form-control" id="item_price" placeholder="Price" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
								<div class="col">
									<Label>Discount(%)</label>
									<input type="text" class="form-control" id="item_discount" placeholder="Discount (%)" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
							</div>
							<button type="button" class="btn btn-info btn-lg btn-block" id="insert_item" style="margin-top:10px;">Insert Item Details</button>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<table id="table_sol" class="table table-sm table-bordered border-dark">
										<thead>
											<tr>
												<th class="d-none" id="Item_ID">ID</th>
												<th id="Item_Name">Product</th>
												<th id="Quantity">Quantity</th>
												<th class="d-none" id="Price">Price</th>
												<th id="Formatted_Price">Price</th>
												<th id="Discount">Disc(%)</th>
												<th>Subtotal</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
								</div>
							</div>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<div class="d-flex flex-row-reverse">
										<table class="table table-sm table-borderless">
											<tr class="d-none">
												<td rowspan="3"><textarea class="form-control border-top-0 border-right-0 border-left-0 border-bottom border-dark" rows="3" placeholder="Purchase Note" style="resize:none;"></textarea></td>
												<td class="text-right">Subtotal</td>
												<td style="width:1%;">:</td>
												<td id="sale_subtotal">0</td>
											</tr>
											<tr class="d-none">
												<td  class="text-right">Discount</td>
												<td style="width:1%;">:</td>
												<td id="sale_discount">0</td>
											</tr>
											<tr class="d-none">
												<td  class="text-right"><h5>Sales Total</h5></td>
												<td style="width:1%;">:</td>
												<td id="sales_total">0</td>
											</tr>
											<tr>
												<td rowspan="3"><textarea class="form-control border-top-0 border-right-0 border-left-0 border-bottom border-dark" rows="3" placeholder="Purchase Note" style="resize:none;"></textarea></td>
												<td class="text-right">Subtotal</td>
												<td style="width:1%;">:</td>
												<td id="formatted_sale_subtotal">0</td>
											</tr>
											<tr>
												<td  class="text-right">Discount</td>
												<td style="width:1%;">:</td>
												<td id="formatted_sale_discount">0</td>
											</tr>
											<tr>
												<td  class="text-right"><h5>Sales Total</h5></td>
												<td style="width:1%;">:</td>
												<td id="formatted_sales_total">0</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<button type="button" onclick="submitForm()" class="btn btn-info btn-lg btn-block" style="margin-top:10px;">Create Sales</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
		function submitForm() {
			// Get the table reference
			var table = document.getElementById("table_sol");

			// Get the table body rows
			var rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");
			
			// Initialize an array to store the extracted data
			var tableData = [];

			var headers = table.rows[0].getElementsByTagName("th");

			// Loop through the rows
			for (var i = 0; i < rows.length; i++) {
				var cells = rows[i].getElementsByTagName("td");
				var rowData = {};

				// Loop through the cells in each row
				for (var j = 0; j < 6; j++) {
					var headerId = headers[j].id;
            		rowData[headerId] = cells[j].textContent;
				}

				// Add the row data to the tableData array
				tableData.push(rowData);
			}

			// Convert the tableData array to a JSON string
			var jsonData = JSON.stringify(tableData);

			// Create a hidden input field and attach the JSON data
			var hiddenInput = document.createElement("input");
			hiddenInput.setAttribute("type", "hidden");
			hiddenInput.setAttribute("name", "tableData");
			hiddenInput.setAttribute("value", jsonData);

			// Append the hidden input to the form
			document.getElementById("sales_form").appendChild(hiddenInput);

			// Submit the form
			document.getElementById("sales_form").submit();
		}

		document.addEventListener("DOMContentLoaded", function() {
			// Handle button click
			document.getElementById("insert_item").addEventListener("click", function() {
				// Get form data
				const name = document.getElementById("inlineFormCustomSelect");
				const quantity = document.getElementById("item_quantity").value;
				const price = document.getElementById("item_price").value;
				const discount = document.getElementById("item_discount").value;
				const subtotal = quantity * price;
				const discount_amount = subtotal * discount / 100;

				// Validate if name and email are not empty
				if (name.value.trim() === "" || quantity.trim() === "" || price.trim() === "" ) {
					alert("Invalid Value");
					return;
				}
				
				const formattedPrice = Number(price).toLocaleString('id-ID', { minimumFractionDigits: 2 });
				const formattedSubtotal = Number(subtotal).toLocaleString('id-ID', { minimumFractionDigits: 2 });
				// Create a new row
				const newRow = document.createElement("tr");
				newRow.innerHTML = `
					<td class='d-none'>${name.value}</td>
					<td>${name.options[name.selectedIndex].text}</td>
					<td>${quantity}</td>
					<td class='d-none'>${price}</td>
					<td>${formattedPrice}</td>
					<td>${discount}</td>
					<td>${formattedSubtotal}</td>
				`;

				// Append the new row to the table
				document.getElementById("table_sol").getElementsByTagName('tbody')[0].appendChild(newRow);
				console.log(parseInt(document.getElementById("sale_subtotal").textContent))
				const sale_subtotal = parseFloat(document.getElementById("sale_subtotal").textContent) + subtotal;
				const sale_discount = parseFloat(document.getElementById("sale_discount").textContent) + discount_amount;
				const sale_total    = sale_subtotal - sale_discount;
				const formattedSale_subtotal= Number(sale_subtotal).toLocaleString('id-ID', { minimumFractionDigits: 2 });
				const formattedSale_discount= Number(sale_discount).toLocaleString('id-ID', { minimumFractionDigits: 2 });
				const formattedsale_total= Number(sale_total).toLocaleString('id-ID', { minimumFractionDigits: 2 });
				// Clear the input fields
				document.getElementById("inlineFormCustomSelect").value = "";
				document.getElementById("item_quantity").value = "";
				document.getElementById("item_price").value = "";
				document.getElementById("item_discount").value = "";
				document.getElementById("sale_subtotal").textContent = sale_subtotal;
				document.getElementById("sale_discount").textContent = sale_discount;
				document.getElementById("sales_total").textContent = sale_total;
				document.getElementById("formatted_sale_subtotal").textContent = formattedSale_subtotal;
				document.getElementById("formatted_sale_discount").textContent = formattedSale_discount;
				document.getElementById("formatted_sales_total").textContent = formattedsale_total;
			});
		});
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
