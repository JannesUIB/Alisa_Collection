<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Sales | Index</title>
	</head>
	<style>
		div.row div.col table.table-striped tr td{
			height:30px;
		}
		div.row div.col table.table-striped tr th{
			height:30px;
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
		<div class="container" style="min-width:100%">
			<div class="row shadow p-3 mb-5 bg-white rounded">
				<div class="col">
					<table class="table table-sm table-borderless">
						<tr>
							<td><h1 class="text-muted">Sales Order</h1></td>
						</td>
						<tr>
							<td>
								<div class="d-flex flex-row" style="margin:0;padding:0;">
									<div class="p-2"><a href="https://localhost/codeigniter_jannes/index.php/Sales/Form"><button type="button" class="btn btn-warning" style="width:90px;">Create</button></a></div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<table class="table table-sm table-striped">
						<tr>
							<th>Sales Order Name</th>
							<th>Customer</th>
							<th>Sales Order Total</th>
						</td>
						<?php
							foreach ($sales as $sale) {
								echo "<tr>";
								echo "<td><a href='". site_url('Sales/formselectedid/'. $sale->ID) ."'>". $sale->Sale_Name ."</a></td>";
								echo "<td>".$sale->Customer_Name."</td>";
								echo "<td>".$sale->Sale_Total."</td>";
								echo "</tr>";
							}
						?>
						<tr>
							<td />
							<td />
							<td />
						</tr>
						<tr>
							<td />
							<td />
							<td />
						</tr>
						<tr>
							<td />
							<td />
							<td />
						</tr>
						<tr>
							<td />
							<td />
							<td />
						</tr>
					</table>
				</div>
			</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</html>
