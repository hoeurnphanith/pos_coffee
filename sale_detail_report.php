<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');
    error_reporting(0);
    
?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">របាយការណ៍លក់សរុប</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li>
                        <a href="prints/print-sale-detail.php" class="text-right text-yellow"><i class="fa-solid fa-print" style="font-size:15px;"></i></a>
                    </li>
                    <li class="active text-right">
                        <i class="fa-solid fa-calendar-days"></i>
                        ថ្ងៃចាប់ផ្ដើម: <?php echo $_POST['date_1'];?> / 
                        <i class="fa-solid fa-calendar-days"></i>
                        រហូតដល់: <?php echo $_POST['date_2'];?>
                    </li>
                </ol>
            </section>

            <section class="content">
                <div class="box box-info">
                    <form action="" method="post" name="">
                        <div class="box-body">      
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">ថ្ងៃចាប់ផ្ដើម:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa-solid fa-calendar-days text-blue"></i>
                                            </div>
                                            <input type="text" name="date_1" class="form-control pull-right" id="datepicker1" value="Start Date" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">រហូតដល់:</label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa-solid fa-calendar-days text-blue"></i>
                                            </div>
                                            <input type="text" name="date_2" class="form-control pull-right" id="datepicker2" value="End Date" data-date-format="yyyy-mm-dd">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div align="center">
                                        <label for=""></label>
                                        <div class="form-group">
                                            <div align="center">
                                                <input type="submit" name="btndatefilter" id="" value="ធ្វើការជ្រើសរើស" class="btn" style="border-radius: 4px;margin-top:5px;background-color:#45aaf2;color:white;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                </div>

                            </div>
                            
                            <br>

                            <table id="salereporttable" class="table">
                                <thead>
                                    <tr>
                                        <th>ល.រ</th>
                                        <th>ផលិតផល</th>
                                        <th>បរិមាណ</th>
                                        <th>តម្លៃទិញចូល</th>
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
                                        $date1 = date("Y-m-d", strtotime($_POST['date_1']));
                                        $date2 = date("Y-m-d", strtotime($_POST['date_2']));

                                        $select = $pdo->prepare("SELECT customer_id,pro_name,sale_date,total,paid,due,payment_type,q,purchase_price,price,username,s_status
                                                    FROM  view_sale_detail WHERE (sale_date BETWEEN :fromdate AND :todate) AND s_status='Enable'");
                                        $select->bindParam(':fromdate',$date1,PDO::PARAM_STR);
                                        $select->bindParam(':todate',$date2,PDO::PARAM_STR);
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
                                                    <td><?php echo $row->pro_name;?></td>
                                                    <td><?php echo $row->q;?></td>
                                                    <td><?php echo $row->purchase_price;?></td>
                                                    <td><?php echo $row->price;?></td>
                                                    <td><?php echo $sale_detail;?></td>
                                                    <td><?php echo $income;?></td>
                                                    <td><?php echo $row->sale_date;?></td>
                                                    <td><?php echo $row->payment_type;?></td>
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
    // Date picker
    $('#datepicker1').datepicker({
        autoclose:true
    });

    $('#datepicker2').datepicker({
        autoclose:true
    });  

    $(document).ready( function () {
        $('#salereporttable').DataTable({order: [[0, 'desc']],});
    });

</script>


