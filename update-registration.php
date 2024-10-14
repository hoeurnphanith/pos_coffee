<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    error_reporting(0);

    $id = $_GET['id'];
    $select = $pdo->prepare("select * from tbl_user where userid = $id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $id_db = $row['userid'];
    $username_db = $row['username'];
    $email_db = $row['useremail'];
    $password_db = $row['password'];
    $role_db = $row['role'];
    $status_db = $row['status'];

    if( isset($_POST['btn-update']) ) {
        $username = $_POST['txt-username'];
        $useremail = $_POST['txt-email'];
        $role = $_POST['txt-role'];
        $status = $_POST['txt-status'];
        if(isset($_POST['txt-username'])){
            $select = $pdo->prepare("SELECT * FROM tbl_user WHERE (username = '$username' OR useremail = '$useremail') AND userid != $id_db");
            $select->execute();
            if($select->rowCount() > 0){
                echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                            title: "ព្រមាន!",
                            text: "សូមអភ័យទោស! ឈ្មោះគឺមានរួចរាល់ម្តងហើយ!",
                            icon: "warning",
                            button: "Ok!",
                        });
                    });
                </script>';
            }else{
        
                $update = $pdo->prepare("UPDATE tbl_user SET username=:username, useremail=:email, role=:role, status=:status WHERE userid = $id"); 
                $update->bindParam(':username',$username);
                $update->bindParam(':email',$useremail);
                $update->bindParam(':role',$role);
                $update->bindParam(':status',$status);

                if($update->execute()){    
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            swal({
                                title:"ជោគជ័យ!",
                                text:"អ្នកប្រើប្រាស់គឺត្រូវបានកែប្រែដោយជោគជ័យ!",
                                icon:"success",
                                timer:1000,
                                button:"OK",
                            });
                        });
                    </script>';
                    
                    echo '<script>
                        window.location.replace("user-registration.php");
                    </script>';
                }else{
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
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
                    <form role="form" action="" method="post">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username">ឈ្មោះ</label>
                                    <input type="text" class="form-control"  name="txt-username"  value="<?php echo $username_db;?>" id="username" placeholder="Enter Username" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">អ៊ីម៉ែល</label>
                                    <input type="text" class="form-control" name="txt-email" value="<?php echo $email_db;?>" id="email" placeholder="Enter Email" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">លេខសម្ងាត់</label>
                                    <input type="password" class="form-control" name="txt-password" value="<?php echo $password_db;?>" id="password" placeholder="Enter Password" readonly> 
                                    <div style="margin-top:10px;padding-left:72%;">
                                        <a href="update-registration-password.php?key_pwd=<?php echo $id;?>" class="btn" style="border-radius: 4px;background-color:#45aaf2;;color:white;">កំណត់ពាក្យសម្ងាត់ឡើងវិញ</a>
                                    </div>
                                </div>

                    
                                <div class="form-group">
                                    <label for="role">សិទ្ធិអ្នកប្រើប្រាស់</label>
                                    <select  class="form-control" name="txt-role">
                                        <option value="Admin"<?php if($role_db == 'Admin'){ echo "selected";}?>>Admin</option>
                                        <option value="User" <?php if($role_db == 'User'){ echo "selected";}?>>User</option>
                                    </select>
                                </div>
                              

                                <div class="form-group">
                                    <label for="status">ស្ថានភាព</label>
                                    <select  class="form-control" name="txt-status">
                                        <?php
                                            $option=$_POST['txt-status'];
                                            echo $option;
                                        ?>
                                        <option value="Enable" <?php if($status_db == 'Enable'){ echo "selected";}?>>Enable</option>
                                        <option value="Disable" <?php if($status_db == 'Disable'){ echo "selected";}?>>Disable</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <a href="user-registration.php" class="btn" style="background-color: #ff4757;color:white;" role="button"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                            <button type="submit" name="btn-update" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> កែប្រែអ្នកប្រើប្រាស់</button>
                        </div>
                    </form>

                </div>
            </section>
        </div>

    <script>
        document.querySelector('#username').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>

    <script>
        document.querySelector('#email').addEventListener('keydown', (e) => {
            console.log(e.which);
            if (e.which === 32) {
                e.preventDefault();
            }
        });
    </script>

<?php
    include_once('action/footer.php');
?>