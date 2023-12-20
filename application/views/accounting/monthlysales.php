<?php
$no = 1; 
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<title>Accounting | Monthly Report Sales</title>
	</head>
	<style>
		div.row div.col div.d-flex a{
			margin-right: 15px;
			color:white;
		}
		div.row div.col div.report a button{
			width: 200px;
			background: #2d358a;
			color:white;
			padding:10px;
		}
		div.dataTables_wrapper {
			width:100%;
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
			<div class="row">
				<div class="col">
					<div class="report d-flex flex-column justify-content-center align-items-center" style="padding-top:5px;">
						<h1>Alisia Collection's Monthly Sales Report</h1>
						<table id="example" class="table table-bordered">
							<thead>
								<tr>
									<th>No</th>
									<th>Sales ID</th>
									<th>Sales Name</th>
									<th>Created Date</th>
									<th>Sales Amount</th>
									<th>Sales Status</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($sales_record as $sale){
									echo "<tr>";
									echo "<td>" . $no . "</td>";
									echo "<td>" . $sale->ID . "</td>";
									echo "<td>" . $sale->Sale_Name . "</td>";
									echo "<td>" . $sale->Create_Date . "</td>";
									echo "<td>" . $sale->Sale_Total . "</td>";
									if ($sale->Status === "Quotation"){
										echo "<td>Quotation</td>";
									}
									else{
										echo "<td>Sales Order</td>";
									}
									echo "</tr>";
									$no += 1;
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js" type="text/javascript"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#example').DataTable( {
				dom: 'Bfrtip',
				buttons: [
					'excel'
				]
			} );
		} );
	</script>
</html>
