<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">បញ្ចីក្រុមផលិតផល</h1>
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
                                        <th>ក្រុមផលិតផល</th>
                                        <th width="200">បរិយាយ</th>
                                        <th width="50">ស្ថានភាព</th>
                                        <th width="60">ប្រត្តិបត្តិការ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY cate_id ASC");
                                        $select->execute();
                                        $id = 0;
                                        while($row = $select->fetch(PDO::FETCH_OBJ)){
                                            $cate_id =$row->cate_id;
                                            $cate_name = $row->cate_name;
                                            $des = $row->des;
                                            $status = $row->status;
                                            $id = $id + 1;

                                            $sql = $pdo->prepare("SELECT cate_id  FROM tbl_product WHERE cate_id = $cate_id");
                                            $sql->execute();
                                            $count_rows = $sql->rowCount();
                                            ?>
                                            
                                                <tr>
                                                    <td><?php echo $id;?></td>
                                                    <td><?php echo $cate_name?></td>
                                                    <td style="margin:0;padding:0;padding-top:7px;"><?php echo $des;?></td> 
                                                    
                                                    <?php 
                                                        if($status =="Enable"){
                                                            echo'<td><span class="label" style="background-color: #05c46b;color:white;">'.$status.'</span></td>';
                                                        }else if($status=="Disable"){
                                                            echo'<td><span class="label" style="background-color: #ff4757;color:white;">'.$status.'</span></td>';
                                                        }
                                                    ?>

                                                    <td>
         
                                                        <!-- <a href="#" data-toggle="modal" data-target="#update_category"><i class="fa-solid fa-pen-to-square btn1"></i></a> -->
                                                        <a href="update-admin-category.php?cate_id=<?php echo $cate_id;?>"><i class="fa-solid fa-pen-to-square btn1"></i></a>
                                                            <?php
                                                            if($count_rows > 0){
                                                            ?>
                                                                <a href="#"><i class="fa-regular fa-trash-can btn2-disable"></i></a>
                                                            <?php
                                                                }else{
                                                            ?>
                                                                <a href="#" id='<?php echo $cate_id;?>' class="btn-delete"><i class="fa-regular fa-trash-can btn2"></i></a>
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
                    var cate_id = $(this).attr("id");
        
                    swal({
                        title: "តើអ្នកត្រូវការលុប​​ក្រុមផលិតផលចេញពីប្រព័ន្ធឬ?",
                        text: "លុបឬក៍​ អត់លុប",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'category-admin-delete.php',
                                type: 'post',
                                data: {cate_idd:cate_id},
                                success:function(data){
                                    td.parents('tr').hide();
                                }
                            });
                            swal("ក្រុមផលិតផលគឺត្រូវបានលុបចេញពីប្រព័ន្ធ!!", {
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