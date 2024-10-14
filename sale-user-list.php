<?php
    include_once('connectdb.php');
    session_start();
    date_default_timezone_set("Asia/Phnom_Penh");
    $date = date("Y-m-d");

    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }
    include_once('action/headeruser.php');

    $user = $_SESSION['role'];
    $username = $_SESSION['username'];
?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="dashboard-h1">បញ្ជីការលក់</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active text-right">ទំព័រដើម</li>
                </ol>
            </section><!-- /.container-fluid -->

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat Box) -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title title">អ្នកអាចស្វែងរកទិន្នន័យដោយប្រើតារាងខាងក្រោម</h5>
                    </div>
                    <!-- .box-header -->
                    <!-- form start  -->
                    <div class="box-body">      
                        <div class="col-md-12">
                            <table class="table" id="orderlisttable">
                                <thead>
                                    <tr>
                                        <th>ល.រ</th>
                                        <th>អតិថិជន</th>
                                        <th>កាលបរិច្ឆេទ</th>
                                        <th>តម្លៃសរុបរួមដុល្លារ</th>
                                        <th>ប្រាក់ទទួលដុល្លារ</th>
                                        <th>ប្រាក់អាប់ដុល្លារ</th>
                                        <th width="60">បង់ដោយ</th>
                                        <th width="60">ប្រត្តិបត្តិការ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select = $pdo->prepare("SELECT * FROM view_sales WHERE sale_date='$date' AND  role='$user' AND username ='$username' AND s_status='Enable'  ORDER BY sale_id ASC");
                                        $select->execute();
                                        $id =0;
                                            while($row = $select->fetch(PDO::FETCH_OBJ)){
                                                $sale_id = $row->sale_id;
                                                $customer_id = $row->customer_name;
                                                $sale_date = $row->sale_date;
                                                $total = $row->total;
                                                $paid = $row->paid;
                                                $due = $row->due;
                                                $payment_type = $row->payment_type;
                                                $id = $id+1;
                                                ?>
                                                
                                                    <tr>
                                                        <td><?php echo $id;?></td>
                                                        <td><?php echo $customer_id;?></td>
                                                        <td><?php echo $sale_date ;?></td> 
                                                        <td><?php echo $total;?></td>
                                                        <td><?php echo $paid;?></td>
                                                        <td><?php echo $due;?></td>
                                                        <td><?php echo $payment_type ;?></td>
                                                        <td style="text-align:center;">
                                                            <a href="prints/print-user.php?key_id=<?php echo $sale_id;?>" target="_blank"><i class="fa-solid fa-print print btn1"></i></a>  
                                                            <a href="sale_list_user_disable.php?key_id=<?php echo $sale_id;?>" id='' class="btn-delete"><i class="fa-regular fa-trash-can btn2"></i></a>
                                                            <!-- <a href="#" id='<?php echo $sale_id;?>' class="btn-delete"><i class="fa-regular fa-trash-can btn2"></i></a> -->
                                                        </td>
                                                    </tr>
                                            
                                                <?php
                                            }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- /.content-header -->
        
        <!-- Call this single Function  -->
        <script>
            $(document).ready( function () {
                $('#orderlisttable').DataTable({order: [[0, 'desc']],});
            });

        </script>
<?php
    include_once('action/footer.php');
?>