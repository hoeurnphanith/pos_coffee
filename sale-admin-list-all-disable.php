<?php
    include_once('connectdb.php');
    session_start();
    date_default_timezone_set("Asia/Phnom_Penh");
    $date = date("Y-m-d");

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');
?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">បញ្ជីការលក់សរុបខូច</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active text-right">ទំព័រដើម</li>
                </ol>
            </section>

            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title title">អ្នកអាចស្វែងរកទិន្នន័យដោយប្រើតារាងខាងក្រោម</h5>
                    </div>
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
                                        <th>ស្ថានភាព</th>
                                        <th>អ្នកគិតលុយ</th>
                                        <th width="60">ប្រត្តិបត្តិការ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select = $pdo->prepare("SELECT * FROM view_sales WHERE s_status='Disable' ORDER BY sale_id ASC");
                                        $select->execute();
                                        $id =0;
                                            while($row = $select->fetch(PDO::FETCH_OBJ)){
                                                $sale_id = $row->sale_id;
                                                $staff = $row->username;
                                                $customer_id = $row->customer_name;
                                                $sale_date = $row->sale_date;
                                                $total = $row->total;
                                                $paid = $row->paid;
                                                $due = $row->due;
                                                $s_status = $row->s_status;
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
                     
                                                        <?php 
                                                            if($s_status=="Disable"){
                                                                echo'<td><span class="label" style="background-color: #ff4757;color:white;">'.$s_status.'</span></td>';
                                                            }
                                                        ?>
                                                       
                                                        <td><?php echo $staff;?></td>
                                                        <td style="text-align: center;">
                                                            <a href="#" id='<?php echo $sale_id;?>' class="btn-delete"><i class="fa-regular fa-trash-can btn2"></i></a>
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

            //Button Delete
            $(document).ready(function(){
                $('.btn-delete').click(function(){
                    var td = $(this);
                    var sale_id = $(this).attr("id");
        
                    swal({
                        title: "តើអ្នកត្រូវការលុប​​ការលក់ចេញពីប្រព័ន្ធឬ?",
                        text: "លុបឬក៍​ អត់លុប",
                        icon: "info",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'action/sale_admin_delete_json.php',
                                type: 'post',
                                data: {sale_id:sale_id},
                                success:function(data){
                                    td.parents('tr').hide();
                                }
                            });
                            swal("ការលក់គឺត្រូវបានលុបចេញពីប្រព័ន្ធ!", {
                                icon: "success",
                                timer: 1000,
                            });
                        }
                    });
                });
            });

        </script>
<?php
    include_once('action/footer.php');
?>