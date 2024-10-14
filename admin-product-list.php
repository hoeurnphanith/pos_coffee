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
                <h1 class="dashboard-h1">បញ្ជីផលិតផល</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="prints/print-product-list-device.php" class="text-right text-yellow"><i class="fa-solid fa-print"></i></a></li>
                    <li><a href="#"class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
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
                            <table class="table  text-center" id="tablecategory">
                                <thead>
                                    <tr>
                                        <th width="50">រូបភាព</th>
                                        <th width="50">ល.រ</th>
                                        <th>ឈ្មោះផលិតផល</th>
                                        <th>ក្រុមផលិតផល</th>
                                        <th>បរិមាណ</th>
                                        <th>តម្លៃទិញចូល</th>
                                        <th>តម្លៃលក់ចេញ</th>
                                        <th>ស្ថានភាព</th>
                                        <th>ប្រត្តិបត្តិការ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $select = $pdo->prepare( "SELECT pro_id,cate_id,cate_name,pro_name,qty,purchase_price,sale_price,photo,status FROM view_product_list ORDER BY pro_id DESC" );
                                        $select->execute();
                                        $id = 0;
                                        while( $row = $select->fetch(PDO::FETCH_OBJ)) {
                                            $id = $id + 1;
                                            $pro_id = $row->pro_id;
                                            $pro_name = $row->pro_name;
                                            $cate_name = $row->cate_name;
                                            $qty = $row->qty;
                                            $purchase_price = $row->purchase_price;
                                            $sale_price = $row->sale_price;
                                            $photo = $row->photo;
                                            $status = $row->status;

                                            $sql = $pdo->prepare("SELECT pro_id FROM tbl_sale_detail WHERE pro_id = $pro_id");
                                            $sql->execute();
                                            $count_rows = $sql->rowCount();
                                            ?>
                                                <tr>
                                                    <td><img src = "images/<?php echo $photo;?>" class="img-rounded" width="50px" height="50px"/></td>
                                                    <td><?php echo $id;?></td>
                                                    <td><?php echo mb_substr(strip_tags($pro_name),0,20,'utf8');?></td>
                                                    <td><?php echo $cate_name;?></td>
                                                    <td><?php echo $qty;?></td>
                                                    <td><?php echo $purchase_price?></td>
                                                    <td><?php echo $sale_price;?></td>
                                                    
                                                    <?php 
                                                        if($status =="Enable"){
                                                            echo'<td><span class="label" style="background-color: #05c46b;color:white;">'.$status.'</span></td>';
                                                        }else if($status=="Disable"){
                                                            echo'<td><span class="label" style="background-color: #ff4757;color:white;">'.$status.'</span></td>';
                                                        }
                                                    ?>
                                                    
                                                    <td>
                                                        <!-- <a href="view-admin-product.php?id=<?php echo $pro_id;?>" title="View Product"><i class="fa-solid fa-eye view-product btn-view"></i></a> -->
                                                        <a href="#" data-toggle="modal" data-target="#modal-view" data-id="<?php echo $pro_id;?>" title="View Product" class="view-proudct"><i class="fa-solid fa-eye view-product btn-view"></i></a>
                                                        <a href="update_admin_product.php?id=<?php echo $pro_id;?>" title="Edit Product"><i class="fa-solid fa-pen-to-square btn1"></i></i></a>

                                                            <?php
                                                         
                                                            if($count_rows>0){
                                                            ?>
                                                                <a href="#"><i class="fa-regular fa-trash-can btn2-disable"></i></a>
                                                            <?php
                                                                }else{
                                                            ?>
                                                                <a id='<?php echo $pro_id;?>' class="btn-delete" title="Delete Product"><i class="fa-regular fa-trash-can btn2"></i></a>
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

        <div class="modal fade" id="modal-view">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title title">ព័ត៍មានលំអិតផលិត</h4>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn pull-left" data-dismiss="modal" style="background-color:#ff4757;color:white;padding:7px 18px;">ចាកចេញ</button>
                    </div>
                    </div>
                </div>
        </div>
        
        <script>
            $(document).ready( function () {
                $('#tablecategory').DataTable({order: [[0, 'desc']],});
            });
            
            //Button Delete
            $(document).ready(function(){
                $('.btn-delete').click(function(){
                    var td = $(this);
                    var pro_id = $(this).attr("id");
        
                    swal({
                        title: "តើអ្នកត្រូវការលុប​ផលិតផលឬ?",
                        text: "លុបឬក៍​ អត់លុប",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'delete_admin_product.php',
                                type: 'post',
                                data: {pro_id:pro_id},
                                success:function(data){
                                    td.parents('tr').hide();
                                }
                            });
                            swal("ផលិតផលគឺត្រូវបានលុបចេញពីប្រព័ន្ធ!", {
                                icon: "success",
                                timer: 1000,
                            });
                        }
                    });
                });
            });
        </script>

        <script type='text/javascript'>
            $(document).ready(function(){
                $('.view-proudct').click(function(){
                    var view_proid = $(this).data('id');
                    $.ajax({
                        url: 'action/ajax-view-admin-json.php',
                        type: 'post',
                        data: {view_proid: view_proid},
                        success: function(response){ 
                            $('.modal-body').html(response); 
                            $('#modal-view').modal('show'); 
                        }
                    });
                
                });
            });
        </script>
<?php
    include_once('action/footer.php');
?>