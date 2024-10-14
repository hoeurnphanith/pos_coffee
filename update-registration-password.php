<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

     error_reporting(0);

     $key_pwd = $_GET['key_pwd'];
     $select = $pdo->prepare("select * from tbl_user where userid = $key_pwd");
     $select->execute();
     $row = $select->fetch(PDO::FETCH_ASSOC);

     $id_db = $row['userid'];
     $password_db = $row['password'];
     $password_db = md5($password_db);

     if( isset($_POST['btn-update']) ) {
        $password = $_POST['txt-password'];
        $password = md5($password);
        
        $update = $pdo->prepare("update tbl_user set password=:password where userid = $key_pwd");
            
        $update->bindParam(':password',$password);
        if($update->execute()){    
            echo '<script>
                    window.location.replace("user-registration.php");
                </script>';

        }else{
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                        title:"Error!",
                        text:"លេខសម្ងាត់គឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
                        icon:"error",
                        button:"OK",
                    });
                });
            </script>';
        }
    }
?>
    
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">កែប្រែអ្នកប្រើប្រាស់</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active">ទំព័រដើម</li>
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
                                    <label for="password">លេខសម្ងាត់</label>
                                    <input type="password" class="form-control" minlength="3" name="txt-password" placeholder="Please Enter New Password" id="password" placeholder="Enter Password" required>   
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <a href="user-registration.php" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                            <button type="submit" name="btn-update" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> កំណត់ពាក្យសម្ងាត់ឡើង</button>
                        </div>
                    </form>

                </div>
            </section>
        </div>

<script>
    document.querySelector('#password').addEventListener('keydown', (e) => {
        console.log(e.which);
        if (e.which === 32) {
            e.preventDefault();
        }
    });
</script>

<?php
    include_once('action/footer.php');
?>
