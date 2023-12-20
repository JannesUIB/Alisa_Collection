<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Inventory | Form</title>
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
		<?php foreach ($record as $rec ) { ?>
		<div class="container shadow p-3 mb-3 mt-4 bg-white rounded">
			<div class="row">
				<div class="col">
					<div class="d-flex flex-row">
						<div class="p-2"><a class="btn btn-primary" style="width:90px;text-decoration:none;" href="<?php echo site_url('inventory/edit/'. $rec->ID); ?>">Edit</a></div>
						<div class="p-2"><a class="btn btn-danger"  style="width:90px;text-decoration:none;" href="<?php echo site_url('inventory/delete/'. $rec->ID); ?>">Delete</a></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h1>Inventory</h1>
					<div class="">
						<form method="POST" action="<?php echo site_url('inventory/AddInventory/'. $rec->ID); ?>">
							<div class="form-group">
								<input type="text" class="form-control" name="inventory_name" placeholder="Item's Name" value="<?php echo $rec->Item_Name ?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;height:80px;font-size:24px; width:50%" readonly>
							</div>
							<h3>Item's Details</h3>
							<div class="row">
								<div class="col">
									<Label>Item's Category</label>
									<input type="text" class="form-control" name="inventory_category" placeholder="Item's Category" value="<?php echo $rec->Item_Category ?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;" readonly>
								</div>
								<div class="col">
									<Label>Product Type</label>
									<input type="text" class="form-control" name="inventory_type" placeholder="Product Type" value="<?php echo $rec->Item_Type ?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;" readonly>
								</div>
								<div class="col">
									<Label>Internal References</label>
									<input type="text" class="form-control" name="inventory_internal_references" placeholder="Interal References" value="<?php echo $rec->Internal_Ref ?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;" readonly>
								</div>
							</div>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<Label>Barcode</label>
									<input type="text" class="form-control" name="inventory_barcode" placeholder="Barcode" value="<?php echo $rec->Barcode ?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;" readonly>
								</div>
								<div class="col">
									<Label>Sales Price</label>
									<input type="text" class="form-control" name="inventory_price" placeholder="Sales Price" value="<?php echo $rec->Sales_Prices ?>" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;" readonly>
								</div>
							</div>
							<h3 style="margin-top:10px;">Description</h3>
							<div class="form-group">
								<textarea name="inventory_description" class="form-control border-top-0 border-right-0 border-left-0 border-bottom border-dark" rows="3" placeholder="Item's Description" style="resize:none;" readonly><?php echo $rec->description ?></textarea>
							</div>
							<!-- <button type="submit" class="btn btn-info btn-lg btn-block" style="margin-top:10px;">Add Inventory</button> -->
						</form>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
