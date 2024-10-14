<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    
    if(isset($_POST['btn-add-user'])){
        $username = trim($_POST['txt-name']);
        $useremail = $_POST['txt-email'];
        $password = MD5($_POST['txt-password']);
        $password = trim($password);
        $role = $_POST['txt-role'];
        $status = $_POST['txt-status'];

        if(isset($_POST['txt-name'])){
            $select = $pdo->prepare("SELECT username,useremail FROM tbl_user WHERE username = '$username' OR useremail = '$useremail'");
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
                    $insert = $pdo->prepare("INSERT INTO tbl_user(username,useremail,password,role,status) VALUES(:username,:useremail,:password,:role,:status)");
                    $insert->bindParam(':username',$username);
                    $insert->bindParam(':useremail',$useremail);
                    $insert->bindParam(':password',$password);
                    $insert->bindParam(':role',$role);
                    $insert->bindParam(':status',$status);
                    if($insert->execute()){
                        echo '<script type="text/javascript">
                        jQuery(function validation(){
                                swal({
                                    title: "ជោគជ័យ!",
                                    text: "អ្នកប្រើប្រាស់គឺត្រូវបានបញ្ចូលដោយជោគជ័យ!",
                                    icon: "success",
                                    timer:1000,
                                    button: "Ok!",
                                });
                            });
                        </script>';
                    }else{
                        echo '<script type="text/javascript">
                            jQuery(function validation(){
                                swal({
                                    title: "កំហុស!",
                                    text: "អ្នកប្រើប្រាស់គឺមិនត្រូវបានបញ្ចូលក្នុងប្រព័ន្ធ!",
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
                <h1 class="dashboard-h1">បន្ថែមអ្នកប្រើប្រាស់</h1>
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
                                <label for="">ឈ្មោះ</label>
                                <input type="text" class="form-control" name="txt-name" id="txt-name" placeholder="Enter Username" required>
                            </div>
                            <div class="form-group">
                                <label for="">អ៊ីម៉ែល</label>
                                <input type="email" class="form-control" name="txt-email" id="txt-email" placeholder="Enter Email" required>
                            </div>
                            <div class="form-group">
                                <label for="">លេខសម្ងាត់</label>
                                <input type="password" class="form-control" minlength="3" name="txt-password" id="txt-password" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group">
                                <label for="">សិទ្ធិអ្នកប្រើប្រាស់</label>
                                <select name="txt-role" id="" class="form-control">
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">ស្ថានភាព</label>
                                <select name="txt-status" id="" class="form-control">
                                    <option value="Enable">Enable</option>
                                    <option value="Disable">Disable</option>
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="user-registration.php" name="btn-back" class="btn" style="background-color:#ff4757;color:white;padding:7px 18px;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                            <button type="submit" name="btn-add-user" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> បន្ថែមអ្នកប្រើប្រាស់</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        <!-- /.content-header -->
    <script>
        document.querySelector('#txt-name').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>

    <script>
        document.querySelector('#txt-password').addEventListener('keydown', (e) => {
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