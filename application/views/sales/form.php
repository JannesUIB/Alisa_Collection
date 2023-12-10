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
					<h1>Sales Order</h1>
					<div class="">
						<form id="sale_form" method="POST" action="<?php echo site_url('Sales/AddSales'); ?>">
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Sales Order ID" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;height:80px;font-size:24px; width:50%" readonly>
							</div>
							<div class="form-group">
								<Label>Customer</label>
								<input type="text" class="form-control" placeholder="Customer Name" name="customer_name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;width:30% ">
							</div>
							<h3>Item's Details</h3>
							<div class="row">
								<div class="col">
									<Label>Item's Name</label>
									<!-- <input type="text" class="form-control" placeholder="Item's Name" id="item_name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
									 -->
									 <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
										<?php foreach($inventory_records as $inventory) {
											echo "<option value='" . $inventory->ID . "'>" . $inventory->Item_Name . "</option>";
										}
										?>
									</select>
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
												<th id="Price">Price</th>
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
											<tr>
												<td rowspan="3"><textarea class="form-control border-top-0 border-right-0 border-left-0 border-bottom border-dark" rows="3" placeholder="Sales Note" style="resize:none;"></textarea></td>
												<td class="text-right">Subtotal</td>
												<td style="width:1%;">:</td>
												<td id="sale_subtotal">0</td>
											</tr>
											<tr>
												<td  class="text-right">Discount</td>
												<td style="width:1%;">:</td>
												<td id="sale_discount">0</td>
											</tr>
											<tr>
												<td  class="text-right"><h5>Sales Total</h5></td>
												<td style="width:1%;">:</td>
												<td id="sales_total">0</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
							<button type="button" onclick="submitForm()" class="btn btn-info btn-lg btn-block" style="margin-top:10px;">Create Sale</button>
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
				for (var j = 0; j < 5; j++) {
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
			document.getElementById("sale_form").appendChild(hiddenInput);

			// Submit the form
			document.getElementById("sale_form").submit();
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

				// Create a new row
				const newRow = document.createElement("tr");
				newRow.innerHTML = `
					<td class='d-none'>${name.value}</td>
					<td>${name.options[name.selectedIndex].text}</td>
					<td>${quantity}</td>
					<td>${price}</td>
					<td>${discount}</td>
					<td>${subtotal}</td>
				`;

				// Append the new row to the table
				document.getElementById("table_sol").getElementsByTagName('tbody')[0].appendChild(newRow);


				// Clear the input fields
				document.getElementById("item_name").value = "";
				document.getElementById("item_quantity").value = "";
				document.getElementById("item_price").value = "";
				document.getElementById("item_discount").value = "";
				document.getElementById("sale_subtotal").textContent = parseFloat(document.getElementById("sale_subtotal").textContent) + subtotal;
				document.getElementById("sale_discount").textContent = parseFloat(document.getElementById("sale_discount").textContent) + discount_amount;
				document.getElementById("sales_total").textContent = parseFloat(document.getElementById("sale_subtotal").textContent) - parseFloat(document.getElementById("sale_discount").textContent);
			});
		});
	</script>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
