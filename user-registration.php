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
                <h1 class="dashboard-h1">អ្នកប្រើប្រាស់</h1>
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
                    <form role="form" action="" method="POST">
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-12">
                                
                                    <table class="table" id="table-user">
                                        <thead>
                                            <tr>
                                                <th width="50">ល.រ</th>
                                                <th>ឈ្មោះ</th>
                                                <th>អ៊ីម៉ែល</th>
                                                <th width="100">សិទ្ធិអ្នកប្រើប្រាស់</th>
                                                <th width="50">ស្ថានភាព</th>
                                                <th width="60">ប្រត្តិបត្តិការ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $select = $pdo->prepare("SELECT * FROM tbl_user ORDER BY userid ASC");
                                                $select->execute();
                                                $id = 0;
                                                while($row = $select->fetch(PDO::FETCH_OBJ)){
                                                    $user_id =$row->userid;
                                                    $id = $id+1;
                                                    $user_name = $row->username;
                                                    $user_email = $row->useremail;
                                                    $role = $row->role;
                                                    $status = $row->status;

                                                    $sql = $pdo->prepare("SELECT userid  FROM tbl_sale WHERE userid = $user_id");
                                                    $sql->execute();
                                                    $count_rows = $sql->rowCount();
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $id; ?></td>
                                                        <td><?php echo $user_name;?></td>
                                                        <td><?php echo $user_email;?></td>
                                                        <?php 
                                                            if($role =="Admin"){
                                                                echo'<td>'.$role.'</td>';
                                                            }else if($role=="User"){
                                                                echo'<td>'.$role.'</td>';
                                                            }
                                                        ?>
                                                        
                                                        <?php 
                                                            if($status =="Enable"){
                                                                echo'<td><span class="label" style="background-color: #05c46b;color:white;">'.$status.'</span></td>';
                                                            }else if($status=="Disable"){
                                                                echo'<td><span class="label" style="background-color: #ff4757;color:white;">'.$status.'</span></td>';
                                                            }
                                                        ?>

                                                        <td>
                                                            
                                                            <?php
                                                                if(($user_id == $_SESSION['userid']) || $user_id == 2){
                                                            ?>   
                                                                <a href="update-admin-name.php?id=<?php echo $user_id;?>" class="text-primary"><i class="fa-solid fa-pen-to-square btn1"></i></a>
                                                                <a href="#"><i class="fa-regular fa-trash-can btn2-disable"></i></a>
                                                            <?php
                                                                }else{
                                                            ?>
                                                                <a href="update-registration.php?id=<?php echo $user_id;?>"><i class="fa-solid fa-pen-to-square btn1"></i></a>
                                                                <?php 
                                                                     if($count_rows > 0){
                                                                ?>
                                                                    <a href="#"><i class="fa-regular fa-trash-can btn2-disable"></i></a>
                                                                <?php
                                                                    }else{
                                                                ?>
                                                    
                                                                    <a href="#" id="<?php echo $user_id;?>" class="btn-delete"><i class="fa-regular fa-trash-can btn2"></i></a>
                                                                <?php
                                                                    }
                                                                ?>
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
                    </form>
                </div>
            </section>
        </div>

        <script>
            $(document).ready( function () {
                $('#table-user').DataTable({order: [[0, 'desc']],});
            } );

            //Button Delete
            $(document).ready( function () {
                $('.btn-delete').click( function () {
                    var td = $(this);
                    var userid = $(this).attr("id");

                    swal({
                        title: "តើអ្នកត្រូវការលុប​អ្នកប្រើប្រាស់ឬ?",
                        text: "លុបឬក៍​ អត់លុប",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                        })
                        .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url:'delete-registration.php',
                                type: 'post',
                                data: {useridd: userid},
                                success:function(data){
                                    td.parents('tr').hide();
                                }
                            });
                            swal("អ្នកប្រើប្រាស់គឺត្រូវបានលុបចេញពីប្រព័ន្ធ!", {
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

