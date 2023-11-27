<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Purchase</title>
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
		<div class="container shadow p-3 mb-3 mt-4 bg-white rounded">
			<div class="row">
				<div class="col">
					<div class="d-flex flex-row">
						<div class="p-2"><button type="button" class="btn btn-primary" style="width:90px;">Edit</button></div>
						<div class="p-2"><button type="button" class="btn btn-danger"  style="width:90px;">Delete</button></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<h1>Inventory</h1>
					<div class="">
						<form>
							<div class="form-group">
								<input type="text" class="form-control" placeholder="Item's Name" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;height:80px;font-size:24px; width:50%">
							</div>

							<h3>Item's Details</h3>
							<div class="row">
								<div class="col">
									<Label>Item's Category</label>
									<input type="text" class="form-control" placeholder="Item's Category" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
								<div class="col">
									<Label>Product Type</label>
									<input type="text" class="form-control" placeholder="Product Type" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
								<div class="col">
									<Label>Internal References</label>
									<input type="text" class="form-control" placeholder="Interal References" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
							</div>
							<div class="row" style="margin-top:10px;">
								<div class="col">
									<Label>Barcode</label>
									<input type="text" class="form-control" placeholder="Barcode" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
								<div class="col">
									<Label>Sales Price</label>
									<input type="text" class="form-control" placeholder="Sales Price" style="border-top:0px solid black;border-right:0px solid black;border-left:0px solid black;">
								</div>
							</div>
							<h3 style="margin-top:10px;">Description</h3>
							<div class="form-group">
								<textarea class="form-control border-top-0 border-right-0 border-left-0 border-bottom border-dark" rows="3" placeholder="Item's Description" style="resize:none;"></textarea>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
