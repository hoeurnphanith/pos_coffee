<!DOCTYPE html>
<?php
	require '../conn.php';
    session_start();
?>
<html lang="en">
	<head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">
        <title>Invoice</title>
        <link rel="icon" href="dist/img/logo.png">

        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/print.css">
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
                size: auto;  
                margin-top: 50px;
				margin-bottom: 50px;
            }
	    </style>
	</head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 title">
                    <!-- <img src="dist/img/logo.png" alt="" style="width: 100px;padding-right:10px"> -->
                    កន្រ្តេ-កន្ត្រក
                </div>
            </div>

            <div class="row">
                <div class="col-12 center">070 891 331</div>
            </div>

            <div class="row">
                <div class="col-12 center">អ៊ីម៉ែល : ktrektrok@gmail.com</div>
            </div>

            <div class="row">
                <div class="col-12 center">អាស័យដ្ឋាន​ : ផ្លូវ 1.5, បាត់ដំបង, កម្ពុជា</div>
            </div>

            <div class="row mt-2">

                <?php
                    if(isset($_GET['key_id'])){
                    $key_id = $_GET['key_id'];

                    $query = $conn->query("SELECT sale_id,username,customer_id,customer_name,sale_date,sub_total,discount,total,paid,due,payment_type FROM view_sales WHERE sale_id=$key_id");
                    $fetch = $query->fetch_array();
                    $sale_id = $fetch['sale_id'];
                    $username = $fetch['username'];
                    $customer = $fetch['customer_name'];
                    $date = $fetch['sale_date'];
                    $sub_total = $fetch['sub_total'];
                    $disc = $fetch['discount'];
                    $total = $fetch['total'];
                    $paid = $fetch['paid'];
                    $due = $fetch['due'];
                    $padment_method = $fetch['payment_type'];
                ?>

                <div class="col-5">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">
                                អតិថិជន : <?php echo $customer;?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">បង់ដោយ/ Method : <?php echo $padment_method; ?></div>
                    </div>
                </div>
                <div class="col-2"></div>
               
                <div class="col-5" style="text-align:left;">
                   
                    <div class="row">
                        <div class="col-md-12">
                            វិក្កយបត្រ/Invoice: <?php echo "No00".$sale_id;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            កាលបរិច្ឆេទ/Date: <?php echo $date;?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            អ្នកគិតលុយ: <?php echo $username;?>
                        </div>
                    </div>
                </div>

            </div>

            
            <table class="table" style="border-bottom: 1px dashed black;">
                <thead>
                    <tr>
                        <th>ផលិតផល <br>Products</th>
                        <th width="100">បរិមាណ <br>Qty</th>
                        <th width="100">តម្លៃ<br>Price</th>
                        <th width="200">តម្លៃសរុប <br>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $query = $conn->query("SELECT sale_id,pro_name,q,price
                                                FROM view_sale_detail WHERE sale_id=$key_id");
                        while($fetch = $query->fetch_array()){
                    ?>
                    <tr>
                        <td><?php echo $fetch['pro_name'];?></td>
                        <td style="text-align:center;"><?php echo $fetch['q'];?></td>
                        <td style="text-align:center;"><?php echo $fetch['price'];?></td>
                        <td style="text-align:center;"><?php echo $fetch['q'] * $fetch['price'];?></td>
                    </tr>
            
                    <?php
                        }
                    ?>
                </tbody>   
            </table>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-5"  style="text-align: right;">
                        <div class="row">
                            <div class="col-12">ប្រាក់ត្រូវបង់/ GrandTotal :</div>
                        </div>
                        <div class="row">
                            <div class="col-12">ប្រាក់ទទួល/ Paid :</div>
                        </div>
                        <div class="row">
                            <div class="col-12">ប្រាក់អាប់់/ Due :</div>
                        </div>
                    </div>
                    <div class="col-2" style="text-align: right;">
                        <div class="row">
                            <div class="col-12"><?php echo  $total;?> $</div>
                        </div>
                        <div class="row">
                            <div class="col-12"><?php echo  $paid;?> $</div>
                        </div>
                        <div class="row">
                            <div class="col-12"><?php echo  $due;?> $</div>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="container-fluid mt-2">
                <div class="row">
                    <div class="col-md-12 border-dashed center">
                        Thank You ! Please Come Again.
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 center">
                        ទំនិញទិញរួចមិនអាចដូរវិញបានទេ
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 center">
                        Goods sold are not returnable
                    </div>
                </div>
                <!-- <img src="dist/img/wifi-code.jpg" alt="" style="width: 160px;padding-right:10px;"> -->
            </div>

        </div>
        <?php
            }
        ?>
        <center><button id="PrintButton" onclick="PrintPage()">Print</button></center>
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
    
</script>
</html>