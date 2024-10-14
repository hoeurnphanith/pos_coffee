<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    if(isset($_POST['btn-add-category'])){
        $cate_name = trim($_POST['txt-cate']);
        $des = $_POST['txt-des'];
        $status = $_POST['txt-status'];

        if(isset($_POST['txt-cate'])){
            $select = $pdo->prepare("SELECT cate_name FROM tbl_category WHERE cate_name = '$cate_name'");
            $select->execute();
            if($select->rowCount() > 0){
                echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                            title: "ព្រមាន!",
                            text: "សូមអភ័យទោស! ក្រុមផលិតផលគឺមានរួចរាល់ម្តងហើយ!",
                            icon: "warning",
                            button: "Ok!",
                        });
                    });
                </script>';
            }else{
                    $insert = $pdo->prepare("INSERT INTO tbl_category (cate_name,des,status) VALUES(:cate_name,:des,:status)");
                    $insert->bindParam(':cate_name',$cate_name);
                    $insert->bindParam(':des',$des);
                    $insert->bindParam(':status',$status);
                    if($insert->execute()){

                        echo '<script type="text/javascript">
                        jQuery(function validation(){
                                swal({
                                    title: "ជោគជ័យ!",
                                    text: "ក្រុមផលិតផលគឺត្រូវបានបញ្ចូលដោយជោគជ័យ!",
                                    icon: "success",
                                    timer: 1500,
                                    button: "Ok!",
                                });
                            });
                        </script>';

                    }else{
                        echo '<script type="text/javascript">
                            jQuery(function validation(){
                                swal({
                                    title: "កំហុស!",
                                    text: "ក្រុមផលិតផលគឺមិនត្រូវបានបញ្ចូលក្នុងប្រព័ន្ធ!",
                                    icon: "error",
                                    button: "Ok!",
                                });
                            });
                        </script>';
                    }
            } 
      
        }
    }

?>
    
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="dashboard-h1">បន្ថែមក្រុមផលិតផល</h1>
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
                        <h5 class="box-title title">សូមបញ្ចូលព័ត៍មានខាងក្រោម</h5>
                    </div>
                    <form role="form" action="" method="post" style="width:50%;">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="">ក្រុមផលិតផល</label>
                                <input type="text" class="form-control" name="txt-cate" id="txt-cate" placeholder="Enter Category" required>
                            </div>
                            <div class="form-group">
                                <label for="">ស្ថានភាព</label>
                                <select name="txt-status" id="" class="form-control">
                                    <option value="Enable">Enable</option>
                                    <option value="Disable">Disable</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">បរិយាយ</label>
                                <textarea name="txt-des" id="editor1" class="form-control" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="category-admin.php" name="btn-back" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                            <button type="submit" name="btn-add-category" class="btn" style="background-color:#45aaf2;color:white;"><i class="fa-solid fa-floppy-disk"></i> បន្ថែមក្រុមផលិតផល</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <!-- /.content-header -->
  
    <?php
    include_once('action/footer.php');
?>