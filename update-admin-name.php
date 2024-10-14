<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    error_reporting(0);

    $key_id = $_GET['id'];
    $select = $pdo->prepare("SELECT * FROM tbl_user WHERE userid = $key_id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);
    $userid_db = $row['userid'];
    $user_name_db = $row['username'];
    $user_email_db = $row['useremail'];

    if(isset($_POST['btnupdate'])){
        $user_name = trim($_POST['txt-admin-name']);
        $user_email = trim($_POST['txt-email']);
        if(isset($user_name)){
            $select = $pdo->prepare("SELECT * FROM tbl_user WHERE (username = '$user_name' OR useremail = '$user_email') && userid != $userid_db");
            $select->execute();
            if($select->rowCount() > 0){
                echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                            title: "ព្រមាន!",
                            text: "សូមអភ័យទោស! ឈ្មោះ​ និង អ៊ីម៉ែលគឺមានរួចរាល់ម្តងហើយ!",
                            icon: "warning",
                            button: "Ok!",
                        });
                    });
                </script>';
            }else{
                $update=$pdo->prepare("UPDATE tbl_user SET username=:user_name,useremail=:useremail where userid = $key_id");   
                $update->bindParam(':user_name',$user_name);
                $update->bindParam(':useremail',$user_email);
                if($update->execute()){
                    echo '<script>
                            window.location.replace("user-registration.php");
                        </script>';
                }else{
                    echo '<script type="text/javascript">jQuery(function validation(){
                            swal({
                                title:"កំហុស!",
                                text:"អ្នកប្រើប្រាស់គឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
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
            <h1 class="dashboard-h1">កែប្រែអ្នកប្រើប្រាស់</h1>
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
                            <label for="">ឈ្មោះ</label>
                            <input type="text" class="form-control" value="<?php echo $user_name_db;?>" id="txt-name" name="txt-admin-name" required>
                        </div>
                        <div class="form-group">
                            <label for="">អ៊ីម៉ែល</label>
                            <input type="email" class="form-control" value="<?php echo $user_email_db;?>" id="txt-email" name="txt-email" required>
                        </div>

                    </div>
                    
                    <div class="box-footer">
                        <a href="user-registration.php" style="background-color:#ff4757;color:white;padding:7px 18px;border:none;border-radius: 4px;margin-right:5px;"> <i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                        <button type="submit" name="btnupdate" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> កែប្រែឈ្មោះ</button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        document.querySelector('#txt-name').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>

    <script>
        document.querySelector('#txt-email').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>


<?php
    include_once('action/footer.php');
?>