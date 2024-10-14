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
                <h1 class="dashboard-h1">របាយការណ៍ផលិតផលអស់ស្តុក</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="prints/print-product-device.php" class="text-right text-yellow"><i class="fa-solid fa-print" style="font-size:15px;"></i></a></li>
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
                                        <th>បរិយាយទំនិញ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $select = $pdo->prepare("SELECT pro_id,cate_id,cate_name,pro_name,qty,purchase_price,sale_price,des,date,status
                                                    FROM view_product_list WHERE qty=0 AND status='Enable'");
                                        $select->execute();

                                        while($row =$select->fetch(PDO::FETCH_OBJ)){
                                            echo '
                                                <tr>
                                                    <td>'.$row->pro_id.'</td>
                                                    <td>'.$row->cate_name.'</td>
                                                    <td>'.$row->pro_name.'</td>
                                                    <td>'.$row->qty.'</td>
                                                    <td>'.$row->purchase_price.'</td>
                                                    <td>'.$row->des.'</td>
                                                </tr>
                                            ';
                                        }
                                    ?>
                                </tbody>
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

