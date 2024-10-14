<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }
    include_once('action/headeruser.php');

?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">បញ្ចីអតិថិជន</h1>
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
                            <table class="table" id="tablecategory">
                                <thead>
                                    <tr>
                                        <th width="50">ល.រ</th>
                                        <th>អតិថិជន</th>
                                        <th width="50">ភេទ</th>
                                        <th width="200">លេខទូរស័ព្ទ</th>
                                        <th width="60">បរិយាយ</th>
                                        <th width="60">ប្រតិបត្តិការ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select = $pdo->prepare("SELECT * FROM tbl_customer ORDER BY customer_id ASC");
                                        $select->execute();
                                        $id = 0;
                                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                                            $customer_id =$row->customer_id;
                                            $customer_name = $row->customer_name;
                                            $gender = $row->gender;
                                            $phone = $row->phone;
                                            $des = $row->des;
                                            $id = $id + 1;

                                            $sql = $pdo->prepare("SELECT customer_id FROM view_sales WHERE customer_id = $customer_id");
                                            $sql->execute();
                                            $count_rows = $sql->rowCount();
                                            ?>
                                            
                                                <tr>
                                                    <td><?php echo $id;?></td>
                                                    <td><?php echo $customer_name?></td>
                                                    <td><?php echo $gender;?></td>
                                                    <td><?php echo $phone;?></td>
                                                    <td style="margin:0;padding:0;padding-top:7px;"><?php echo $des;?></td> 
                                                    
                                                    <td>
                                                        <a href="update-user-customer.php?customer_id=<?php echo $customer_id;?>"><i class="fa-solid fa-pen-to-square btn1"></i></a>
                                                        
                                                        <?php
                                                         
                                                         if($count_rows>0){
                                                         ?>
                                                             <a href="#"><i class="fa-regular fa-trash-can btn2-disable"></i></a>
                                                         <?php
                                                             }else{
                                                         ?>
                                                            <a href="#" id='<?php echo $customer_id;?>' class="btn-delete"><i class="fa-regular fa-trash-can btn2"></i></a>
                                                         <?php
                                                             }
                                                         ?>
                                                          
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


        <script>
            $(document).ready( function () {
                $('#tablecategory').DataTable({order: [[0, 'desc']],});
            });

            //Button Delete
            $(document).ready(function(){
                $('.btn-delete').click(function(){
                    var td = $(this);
                    var customer_id = $(this).attr("id");
        
                    swal({
                        title: "តើលោកអ្នកចង់លុបអតិថិជនឬ?",
                        text: "លុបឬក៍​ អត់លុប!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'delete_user_customer.php',
                                type: 'post',
                                data: {customer_id:customer_id},
                                success:function(data){
                                    td.parents('tr').hide();
                                }
                            });
                            swal("អតិថិជនគឺត្រូវបានលុបចេញពីប្រព័ន្ធ!", {
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