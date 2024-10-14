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
                <h1 class="dashboard-h1">របាយការណ៍ផលិតផលក្នុងស្តុក</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="prints/print-product-list.php" class="text-right text-yellow"><i class="fa-solid fa-print" style="font-size:15px;"></i></a></li>
                    <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active text-right">ទំព័រដើម</li>
              
                </ol>
            </section>

            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title title">អ្នកអាចស្វែងរកទិន្នន័យដោយប្រើតារាងខាងក្រោម</h5>
                    </div>
                    <form action="" method="post" name="">
                        <div class="box-body">      
                            <table id="salereporttable" class="table">
                                <thead>
                                    <tr>
                                        <th>ល.រ</th>
                                        <th>ក្រុមផលិតផល</th>
                                        <th>ផលិតផល</th>
                                        <th>បរិំមាណ</th>
                                        <th>តម្លៃទិញចូលដុល្លារ</th>
                                        <th>តម្លៃសរុបការទិញចូលដុល្លារ</th>
                                        <th>តម្លៃលក់ចេញដុល្លារ</th>
                                        <th>តម្លៃសរុបការលក់ចេញដុល្លារ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $date1 = date("Y-m-d", strtotime($_POST['date_1']));
                                        $date2 = date("Y-m-d", strtotime($_POST['date_2']));
                                        $select = $pdo->prepare("SELECT pro_id,cate_id,cate_name,pro_name,qty,purchase_price,sale_price,status
                                                                FROM view_product_list WHERE qty>0 AND status='Enable'");
                                        $select->execute();
                                        $sub_purchase = 0;
                                        $sub_sale = 0;
                                        $total_income = 0;
                                        $id = 0;
                                        while($row =$select->fetch(PDO::FETCH_OBJ)){
                                            $id = $id + 1;
                                            $pro_id = $row->pro_id;
                                            $cate_name = $row->cate_name;
                                            $pro_name = $row->pro_name;
                                            $qty = $row->qty;

                                            $purchase_price = $row->purchase_price;
                                            $total_purchase = $qty * $purchase_price;
                                            $sub_purchase = $sub_purchase + $total_purchase;

                                            $sale_price = $row->sale_price;
                                            $total_sale = $qty * $sale_price;
                                            $sub_sale = $sub_sale + $total_sale;

                                            $total_income = $sub_sale - $sub_purchase;
                                            echo '
                                                <tr>
                                                    <td>'.$id.'</td>
                                                    <td>'.$cate_name.'</td>
                                                    <td>'.$pro_name.'</td>
                                                    <td>'.$qty.'</td>
                                                    <td>'.$purchase_price.'</td>
                                                    <td>'.$total_purchase.'</td>
                                                    <td>'.$sale_price .'</td>
                                                    <td>'.$total_sale.'</td> 
                                                
                                            ';
                                        }
                                    ?>
                                </tbody>
                                <tr>
                                    <td colspan="6"></td>
                                    <td colspan="1">ចំនួនទឹកប្រាក់ទិញចូលសរុប​:</td>
                                    <td><?php echo $sub_purchase;?> $</td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td colspan="1" class="text-left">ចំនួនទឹកប្រាក់លក់ចេញសរុប:</td>
                                    <td><?php echo $sub_sale;?> $</td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td colspan="1">ប្រាក់ចំណូលសរុប:</td>
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

