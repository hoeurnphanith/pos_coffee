<!DOCTYPE html>
<?php
	require '../conn.php';
	$date = date("Y/m/d", strtotime("+6 HOURS"));
?>
<html lang="en">
<head>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
	<title>Report Product device</title>
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
			  	/* this affects the margin in the printer settings */
				 /* auto is the initial value */
				margin-top: 60px;
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
				<div class="col-12 center" style="font-size: 28px;">របាយការណ៍ផលិតផលអស់ស្តុក</div>
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

				<div class="col-2"></div>

				<div class="col-2" style="font-size: 20px;float:right;">
					កាលបរិច្ឆេទ: <br> <?php echo $date;?>
				</div>
			</div>

            <table class="table">
                <thead>
                    <tr>
						<th>ល.រ</th>
						<th>ក្រុមផលិតផល</th>
                        <th>ផលិតផល</th>
                        <th>បរិមាណ</th>
                        <th>តម្លៃទិញចូល</th>
						<th>បរិយាយ​</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					   $query = $conn->query("SELECT pro_id,cate_id,cate_name,pro_name,qty,purchase_price,des,date FROM view_product_list WHERE qty=0 AND status='Enable'");
					   	while($fetch = $query->fetch_array()){
							$pro_id = $fetch['pro_id'];
							$cate_name = $fetch['cate_name'];
							$pro_name = $fetch['pro_name'];
							$qty = $fetch['qty'];
							$purchase_price = $fetch['purchase_price'];
							$des = $fetch['des'];
                    ?>
					<tr>
                   		<td style="text-align:center;"><?php echo $pro_id;?></td>
						<td><?php echo $cate_name;?></td>
						<td><?php echo $pro_name;?></td>
						<td style="text-align:center;"><?php echo $qty;?></td>
						<td style="text-align:center;"><?php echo $purchase_price;?> $</td>
						<td><?php echo $des;?></td>
					</tr>
                    <?php
						}
                    ?>
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
		window.location = "../product_device_admin_report.php";
	}
</script>

</html>


