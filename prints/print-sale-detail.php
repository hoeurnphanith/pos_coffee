<!DOCTYPE html>
<?php
	require '../conn.php';
	$date = date("Y-m-d", strtotime("+6 HOURS"));
?>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
	<title>Report Sale</title>
	<link rel="icon" href="dist/img/logo.png">

	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="../css/print-product-list.css">
	<style>		
			@media print{
				#print {
					display:none;
				}
			}
			@media print {
				#PrintButton {
					display: none;
				}
			}
		
			@page {
				size: auto;   /* auto is the initial value */
				margin-top: 60px;
				margin-bottom: 60px;  /* this affects the margin in the printer settings */
			}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-10"></div>
			<div class="col-2" style="float:right;">
				<button id="PrintButton" onclick="PrintPage()" class="btn btn-primary">Print</button>
				<button id="PrintButton" onclick="ClosePage()" class="btn btn-danger">Cancel</button>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<img src="../dist/img/logo.png" alt="" style="width: 90px;float:left;">
				<h2 class="title1">កន្រ្តេ-កន្ត្រក</h2>
			</div>
		</div>
		<div class="row text-center">
			<div class="col-12 center" style="font-size: 28px;">របាយការណ៍លំអិតការលក់</div>
		</div>
		<div class="row">

			<div class="col-8">
				<div class="row">
					<div class="col-12">អាស័យដ្ឋាន​ : ផ្លូវ 1.5, បាត់ដំបង, កម្ពុជា</div>
				</div>
				<div class="row">
					<div class="col-12">អ៊ីម៉ែល : ktrektrok@gmail.com</div>
				</div>
			</div>

			<!-- <div class="col-1"></div> -->

			<div class="col-4" style="text-align:right;">
				កាលបរិច្ឆេទ: <br> <?php echo $date;?>
			</div>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th>ល.រ</th>
					<th>ផលិតផល</th>
					<th>បរិមាណ</th>
					<th>តម្លៃលក់ចេញ</th>
					<th>តម្លៃសរុប</th>
					<th>ប្រាក់ចំណូល</th>
					<th>កាលបរិច្ឆេទ</th>
					<th>អ្នកគិតលុយ</th>
					<th>បង់ដោយ</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = $conn->query("SELECT username,customer_name,pro_name,sale_date,total,paid,due,payment_type,q,purchase_price,price,s_status
					 					FROM view_sale_detail WHERE s_status='Enable'");
					$sub_total = 0;
					$total_income = 0;
					$id =0;
					while($fetch = $query->fetch_array()){
						$id = $id +1;
						$username = $fetch['username'];
						$pro_name = $fetch['pro_name'];
						$qty = $fetch['q'];
						$purchase = $fetch['purchase_price'];
						$price = $fetch['price'];
						$total = $fetch['total'];
						$sale_date = $fetch['sale_date'];
						$payment_type = $fetch['payment_type'];

						$pur_sale_detatl = $qty * $purchase;
						$sale_detail = $qty * $price;
						$sub_total = $sub_total + $sale_detail;
						$income = $sale_detail - $pur_sale_detatl;
						$total_income = $total_income + $income;
				?>
				<tr>
					<td><?php echo $id;?></td>
					<td><?php echo $pro_name;?></td>
					<td style="text-align:center;"><?php echo $qty;?></td>
					<td style="text-align:center;"><?php echo $price;?></td>
					<td style="text-align:center;"><?php echo $sale_detail;?> $</td>
					<td style="text-align:center;"><?php echo $income;?> $</td>
					<td style="text-align:center;"><?php echo $sale_date;?></td>
					<td style="text-align:center;"><?php echo $username;?></td>
					<td style="text-align:center;"><?php echo $payment_type;?></td>
				</tr>

				<?php
					}
				?>

				<tr>
					<td colspan="7" style="text-align:right;border:none;padding-right:20px;font-weight:bold;">ចំនួនទឹកប្រាក់ដែរលក់បាន: </td><br>
					<td colspan="2" style="text-align:center;"><?php echo $sub_total;?> $</td>
				</tr>
				<tr>
					<td colspan="7" style="text-align:right;border:none;padding-right:20px;font-weight:bold;">ប្រាក់ចំណូលសរុបនៃការលក់: </td>
					<td colspan="2" style="text-align:center;"><?php echo $total_income;?> $</td>
				</tr>
			</tbody>   

		</table>

        </div>
    </body>
<script type="text/javascript">
	function PrintPage() {
		window.print();
	}
	document.loaded = function(){
		
	}
	window.addEventListener('DOMContentLoaded', (event) => {
   		PrintPage()
		setTimeout(function(){ window.close() },750)
	});

	function ClosePage(){
		window.location = "../sale_detail_report.php";
	}
</script>

</html>


