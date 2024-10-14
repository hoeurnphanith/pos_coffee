<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }
    include_once('action/headeruser.php');
    
    if(isset($_POST['btn-change-password'])){
        $old_password = MD5($_POST['txt-old-password']);
        $new_password = MD5($_POST['txt-new-password']);
        $confirm_password = MD5($_POST['txt-confirm-password']);

        // using of select query we get out database record according to useremail
        $email = $_SESSION['useremail'];
        $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail ='$email'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);

        $useremail_db = $row['useremail'];
        $password_db = $row['password'];

        // we compare userinput  and database value
        if($old_password == $password_db){
            if( $new_password == $confirm_password){
                $update = $pdo->prepare("UPDATE tbl_user SET password=:pass WHERE useremail=:email");
                $update->bindParam(":pass",$confirm_password);
                $update->bindParam(":email",$email);
                if($update->execute()){
                    echo '<script type="text/javascript">
                            jQuery(function validation(){
                                swal({
                                    title: "ជោគជ័យ!",
                                    text: "លេខសម្ងាត់គឺត្រូវបានកែប្រែដោយជោគជ័យ!",
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
                                    text: "លេខសម្ងាត់គឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
                                    icon: "error",
                                    button: "Ok!",
                                });
                            });
                        </script>';
                }
            }else{
                echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                            title: "ព្រមាន!",
                            text: "លេខសម្ងាត់ថ្មី និង​បញ្ជាក់របស់អ្នកគឺមិនត្រឹមត្រូវ!",
                            icon: "warning",
                            button: "Ok!",
                        });
                    });
                </script>';
            }
        }else{
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                        title: "ព្រមាន!",
                        text: "លេខសម្ងាត់របស់អ្នកខុស​! សូមបំពេញលេខសម្ងាត់អោយបានត្រឹមត្រូវ!",
                        icon: "warning",
                        button: "Ok!",
                    });
                });
            </script>';
        }
    }

?>
    
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1 class="dashboard-h1">ផ្លាស់ប្ដូរលេខសម្ងាត់</h1>
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
                        <h5 class="box-title title">សូមបញ្ចូលព័ត៍មានខាង</h5>
                    </div>
                    <form role="form" action="" method="post" style="width:50%;margin-left:0;">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="exampleInputPassword1">បញ្ចូល លេខសម្ងាត់ចាស់</label>
                                <input type="password" class="form-control" minlength="3" name="txt-old-password" id="Password1" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">បញ្ចូល​ លេខសម្ងាត់ថ្មី</label>
                                <input type="password" class="form-control" minlength="3" name="txt-new-password" id="Password2" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">បញ្ជាក់​ ​លេខសម្ងាត់</label>
                                <input type="password" class="form-control" minlength="3" name="txt-confirm-password" id="Password3" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="dashboard_user.php" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                            <button type="submit" name="btn-change-password" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> ផ្លាស់​ប្ដូរលេខសម្ងាត់</button>
                        </div>
                    </form>
            </section>
        </div>
        <!-- /.content-header -->

    <script>
        document.querySelector('#Password1').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>

    <script>
        document.querySelector('#Password2').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>

    <script>
        document.querySelector('#Password3').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>
  
    <?php
    include_once('action/footer.php');
?>