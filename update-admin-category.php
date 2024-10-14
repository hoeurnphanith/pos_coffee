<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    error_reporting(0);

    $key_id = $_GET['cate_id'];
    $select = $pdo->prepare("SELECT * FROM tbl_category WHERE cate_id = $key_id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $cate_id_db = $row['cate_id'];
    $cate_name_db = $row['cate_name'];
    $des_db = $row['des'];
    $status_db = $row['status'];

    if(isset($_POST['btnupdate'])){
        $cate_name = trim($_POST['txt-name']);
        $des = $_POST['txt-des'];
        $status = $_POST['txt-status'];

        if(isset($_POST['txt-name'])){
            $select = $pdo->prepare("SELECT * FROM tbl_category WHERE cate_name = '$cate_name' && cate_id != $cate_id_db");
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
                $update=$pdo->prepare("UPDATE tbl_category SET cate_name=:cate_name, des=:des,status=:status where cate_id = $key_id");   
                $update->bindParam(':cate_name',$cate_name);
                $update->bindParam(':des',$des);
                $update->bindParam(':status',$status);
                if($update->execute()){
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            swal({
                                title:"ជោគជ័យ!",
                                text:"ក្រុមផលិតផលគឺត្រូវបានកែប្រែដោយជោគជ័យ!",
                                icon:"success",
                                timer:1000,
                                button:"OK",
                            });
                        });
                    </script>';

                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            window.location.replace("category-admin.php");
                        });
                    </script>';
                }else{
                    echo '<script type="text/javascript">jQuery(function validation(){
                            swal({
                                title:"កំហុស!",
                                text:"ក្រុមផលិតផលគឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
                                icon:"error",
                                button:"OK",
                            });
                        });
                    </script>';
                }
            }
        }
    } 
?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">កែប្រែក្រុមផលិតផល</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active text-right">ទំព័រដើម</li>
                </ol>
            </section>
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title title">សូមបញ្ចូលព័ត៍មានខាងក្រោម</h5>
                    </div>
                    <form role="form" action="" method="post" name="formcategory" style="width:50%;margin-left:0;">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="">ក្រុមផលិតផល</label>
                                <input type="text" class="form-control" value="<?php echo $cate_name_db;?>" name="txt-name" required>
                            </div>

                            <div class="form-group">
                                <label for="">ស្ថានភាព</label>
                                <select  class="form-control" name="txt-status">
                                    <?php
                                        $option=$_POST['txt-status'];
                                        echo $option;
                                    ?>
                                    <option value="Enable" <?php if($status_db == 'Enable'){ echo "selected";}?>>Enable</option>
                                    <option value="Disable" <?php if($status_db == 'Disable'){ echo "selected";}?>>Disable</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">បរិយាយ</label>
                                <textarea name="txt-des" id="editor1" cols="30" rows="4" class="form-control"> <?php echo $des_db; ?> </textarea>
                            </div>
                            
                        </div>
                        <div class="box-footer">
                            <a href="category-admin.php" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ </a>
                            <button type="submit" name="btnupdate" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> កែប្រែក្រុមផលិតផល</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
<?php
    include_once('action/footer.php');
?>