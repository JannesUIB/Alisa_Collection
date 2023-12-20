<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Accounting | Index</title>
	</head>
	<style>
		div.row div.col div.d-flex a{
			margin-right: 15px;
			color:white;
		}
		div.row div.col div.report a button{
			width: 200px;
			height: 75px;
			background: #2d358a;
			color:white;
			padding:10px;
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
		<div class="container" style="min-width:100%; height: 100dvh">
			<div class="row shadow p-3 mb-5 bg-white rounded">
				<div class="col">
					<table class="table table-sm table-borderless">
						<tr>
							<td><h1 class="text-muted text-center">Accounting Report</h1></td>
						</td>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col">
					<div class="report d-flex flex-column justify-content-center align-items-center">
						<div class="d-flex justify-content-center align-items-center">
							<div class="d-flex flex-column">
								<h5>Sales Report</h5>
								<a class="rounded" href="<?php echo site_url('Accounting/GetDailySalesReport'); ?>"><button>Daily Sales Report</button></a>
								<a class="rounded" href="<?php echo site_url('Accounting/GetMonthlySalesReport'); ?>"><button>Monthly Sales Report</button></a>
								<a class="rounded" href="<?php echo site_url('Accounting/GetMonthlySalesItemsReport'); ?>"><button>Monthly Sales Items Report</button></a>
							</div>
							<div class="d-flex flex-column">
								<h5>Purchase Report</h5>
								<a class="rounded" href="<?php echo site_url('Accounting/GetDailyPurchaseReport'); ?>"><button>Daily Purchase Report</button></a>
								<a class="rounded" href="<?php echo site_url('Accounting/GetMonthlyPurchaseReport'); ?>"><button>Monthly Purchase Report</button></a>
								<a class="rounded" href="<?php echo site_url('Accounting/GetMonthlyPurchaseItemsReport'); ?>"><button>Monthly Purchase Items Report</button></a>
							</div>
						</div>
						<div class="d-flex flex-column">
							<h5>Accounting Report</h5>
							<a class="rounded"><button data-toggle="modal" data-target=".bd-example-modal-lg" >Journal Report</button></a>
							<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<form id="journal_report_form"  method="POST" action="<?php echo site_url('Accounting/GetSelectedDateInvoiceAndBills'); ?>">
												<div class="d-flex flex-column">
													<div class="d-flex">
														<label for="start" style="width:10%;">Start Date</label>
														<input type="date" name="start_date" id="start" style="margin-left:10px; padding-left:10px;" />
													</div>
													<div class="d-flex" style="margin-top:10px;">
														<label for="end" style="width:10%;">End Date</label>
														<input type="date" name="end_date" id="end" style="margin-left:10px; padding-left:10px;" />
													</div>
												</div>
											</form>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											<button type="button" onclick="submitForm()" class="btn btn-primary">Save changes</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script>
		function submitForm() {
			document.getElementById("journal_report_form").submit();
		}
	</script>
</html>
