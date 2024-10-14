<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    $user = $_SESSION['role'];
    $username = $_SESSION['username'];
    $date = date("Y-m-d");
    
    error_reporting(0);
    
?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">របាយការណ៍ លក់ក្នុងថ្ងៃនេះ</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="prints/print-sale-detail-today.php" class="text-right text-yellow"><i class="fa-solid fa-print" style="font-size:15px;"></i></a></li>
                    <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active text-right">ទំព័រដើម</li>
              
                </ol>
            </section>

            <section class="content">
                <div class="box box-info">
                    <form action="" method="post" name="">
                        <div class="box-body">      
                            <table id="salereporttable" class="table">
                                <thead>
                                    <tr>
                                        <th>ល.រ</th>
                                        <th>អតិថិជន</th>
                                        <th>ផលិតផល</th>
                                        <th>បរិមាណ</th>
                                        <th>តម្លៃលក់ចេញដុល្លារ</th>
                                        <th>តម្លៃសរុបដុល្លារ</th>
                                        <th>ប្រាក់ចំណូលដុល្លារ</th>
                                        <th>កាលបរិច្ឆេទ</th>
                                        <th>បង់ដោយ</th>
                                        <th>អ្នកគិតលុយ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        
                                        $select = $pdo->prepare("SELECT 
                                                    sale_id,customer_id,customer_name,pro_name,sale_date,total,paid,due,payment_type,q,purchase_price,price,username,s_status
                                                    FROM  view_sale_detail WHERE sale_date='$date' AND s_status='Enable'");
                    
                                            $select->execute();
                                            $sub_total = 0;
                                            $total_income = 0;
                                            $id = 0;
                                            while($row =$select->fetch(PDO::FETCH_OBJ)){
                                                $id = $id + 1;
                                                $pur_sale_detatl = $row->q * $row->purchase_price;
                                                $sale_detail = $row->q * $row->price;
                                                $sub_total = $sub_total + $sale_detail;
                                                $income = $sale_detail - $pur_sale_detatl;
                                                $total_income = $total_income + $income;
                                            ?>
                                                <tr>
                                                    <td><?php echo $id;?></td>
                                                    <td><?php echo $row->customer_name;?></td>
                                                    <td><?php echo $row->pro_name;?></td>
                                                    <td><?php echo $row->q;?></td>
                                                    <td><?php echo $row->price;?></td>
                                                    <td><?php echo $sale_detail;?></td>
                                                    <td><?php echo $income;?></td>
                                                    <td><?php echo $row->sale_date;?></td>
                                                    <td> <?php echo $row->payment_type;?></td>
                                                    <td><?php echo $row->username;?></td>
                                                </tr>
                                                
                                            <?php
                                        } 
                                    ?>
                                </tbody>

                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1">ចំនួនទឹកប្រាក់ដែរលក់បាន:</td>
                                    <td><?php echo $sub_total;?> $</td>
                                </tr>

                                <tr>
                                    <td colspan="8"></td>
                                    <td colspan="1" class="text-left">ប្រាក់ចំណូលសរុបនៃការលក់:</td>
                                    <td><?php echo $total_income;?> $</td>
                                </tr>
                                
                            </table>

                        </div>
                    </form>
                </div>
            </section>
        </div>       
  
<?php
    include_once('action/footer.php');
?>



<script>
    $(document).ready( function () {
        $('#salereporttable').DataTable({order: [[0, 'desc']],});
    });

</script>


