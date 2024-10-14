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
	<title>Report Product Lists</title>
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
				margin-top: 60px; /* this affects the margin in the printer settings */
				margin-bottom: 60px;
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
				<div class="col-12 center" style="font-size: 28px;">របាយការទំនិញលំអិត</div>
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

				<div class="col-4" style="font-size: 20px;text-align:right;">
					កាលបរិច្ឆេទ: <br> <?php echo $date;?>
				</div>
			</div>

            <table class="table">
                <thead>
                    <tr>
						<th>ល.រ</th>
                        <th>ផលិតផល</th>
                        <th>បរិមាណ</th>
                        <th>តម្លៃទិញចូល</th>
						<th>តម្លៃសរុម​</th>
                        <th>តម្លៃលក់ចេញ</th>
						<th>តម្លៃសរុប</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					   $query = $conn->query("SELECT pro_id,cate_id,cate_name,pro_name,qty,purchase_price,sale_price,date,status FROM view_product_list WHERE status='Enable'");
					   $sum_purchase = 0;
					   $sum_sale = 0;
					   	while($fetch = $query->fetch_array()){
							$pro_id = $fetch['pro_id'];
							$cate_name = $fetch['cate_name'];
							$pro_name = $fetch['pro_name'];
							$qty = $fetch['qty'];

							$purchase_price =  $fetch['purchase_price'];
							$total_purchase = $qty * $purchase_price;
							$sum_purchase = $sum_purchase + $total_purchase;

							$sale_price = $fetch['sale_price'];
							$total_sale = $qty * $sale_price;
							$sum_sale = $sum_sale + $total_sale;
							$income = $sum_sale - $sum_purchase;
                    ?>
					<tr>
                   		<td style="text-align:center;"><?php echo $pro_id;?></td>
						<td><?php echo $pro_name;?></td>
						<td style="text-align:center;"><?php echo $qty;?></td>
						<td style="text-align:center;"><?php echo $purchase_price;?> $</td>
						<td style="text-align:center;"><?php echo $total_purchase;?> $</td>
						<td style="text-align:center;"><?php echo $sale_price;?> $</td>
						<td style="text-align:center;"><?php echo $total_sale;?> $</td>
					</tr>
                    <?php
						}
                    ?>

					<tr>
						<td colspan="5" style="text-align:right;border:none;padding-right:20px;font-weight:bold;">តម្លៃសរុបរួម</td><br>
						<td colspan="2" style="text-align:center;"><?php echo $sum_purchase ;?> $</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;border:none;padding-right:20px;font-weight:bold;">តម្លៃលក់ចេញសរុប </td>
						<td colspan="2" style="text-align:center;"><?php echo $sum_sale;?> $</td>
					</tr>
					<tr>
						<td colspan="5" style="text-align:right;border:none;padding-right:20px;font-weight:bold;">ប្រាក់ចំណូលសរុប</td>
						<td colspan="2"style="text-align:center;"><?php echo $income;?> $</td>
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
		window.location = "../admin-product-list.php";
	}
</script>

</html>


