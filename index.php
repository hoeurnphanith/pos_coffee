<script src="bower_components/sweetalert/sweetalert.js"></script>
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<?php
    include_once('connectdb.php');
    session_start();

    if(isset($_POST['btn_login'])){
        $username = $_POST['txt_username'];
        $password = MD5($_POST['txt_password']);

        $select= $pdo->prepare("select userid,username,useremail,password,role,status from tbl_user where username='$username' AND password='$password'AND status='Enable'");
        $select->execute();
        $row=$select->fetch(PDO::FETCH_ASSOC);

        if($row && $row['username'] == $username && $row['password'] == $password && $row['role']=="Admin"){

            $_SESSION['userid'] = $row['userid'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['useremail'] = $row['useremail'];
            $_SESSION['role'] = $row['role'];

            echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                        title:"ដំណើរការប្រព័ន្ធ!",
                        text: "ចូលដំណើរការប្រព័ន្ធដោយជោគជ័យ!",
                        icon: "success",
                        button: "Ok!",
                        });
                    });
            </script>';

            header('refresh:1;dashboard.php');
        }else if($row && $row['username'] == $username && $row['password'] == $password && $row['role']=='User'){

            $_SESSION['userid'] = $row['userid'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['useremail'] = $row['useremail'];
            $_SESSION['role'] = $row['role'];

            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                    title: "ដំណើរការប្រព័ន្ធ!",
                    text: "ចូលដំណើរការប្រព័ន្ធដោយជោគជ័យ!",
                    icon: "success",
                    button: "Ok!",
                    });
                });
            </script>';
            header('refresh:1;dashboard_user.php');
        }else{
            echo '<script type="text/javascript">
                jQuery(function validation(){
                swal({
                    title: "កំហុស!",
                    text: "ឈ្មោះអ្នកប្រើប្រាស់​ ឬពាក្យសម្ងាត់ខុស!",
                    icon: "error",
                    button: "Ok!",
                });
                });
            </script>';
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Log in</title>
        <link rel="icon" href="dist/img/logo.png">
        <link rel="stylesheet" href="css/css.css">
        <link rel="stylesheet" href="icon/css/all.min.css">

        <!-- Start google font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Shantell+Sans:wght@300&display=swap" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">

        <!-- End google font -->

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    </head>
    <body class="hold-transition login-page bg_img">
        <div class="login-box" style="width: 26%;">
            <div class="login-logo">
            </div>
            <div class="login-box-body login_bg">
                <p class="login-box-msg index">
                    Pos Coffee
                </p>
                <form action="#" method="post">
                    
                    <div class="form-group has-feedback">
                        <label for="" class="label-control">ឈ្មោះ</label>
                        <input type="text" class="form-control frm-control" name="txt_username" id="txt-username" placeholder="Username" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <label for="" class="label-control">លេខសម្ងាត់</label>
                        <input type="password" class="form-control frm-control" name="txt_password" id="txt_password" placeholder="Password" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>        
                        <input type="checkbox" onclick="myFunction()" class="form-check-input" style="margin-top:10px;">
                        <label for="txt_show">បង្ហាញលេខសម្ងាត់</label> 
                        
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin-top:10px;">
                            <a href="recover_psw.php">ភ្លេចលេខសម្ងាត់</a><br>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin-top:10px;margin-bottom:10px;">
                            <button type="submit" name="btn_login"  class="btn btn-login">ចូលគណនី</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>

        <script>
            function myFunction() {
                var x = document.getElementById("txt_password");
                if (x.type === "password") {
                  x.type = "text";
                } else {
                  x.type = "password";
                }
            }
        </script>

        <script>
            document.querySelector('#txt-username').addEventListener('keydown', (e) => {
                console.log(e.which);
                if (e.which === 32) {
                    e.preventDefault();
                }
            });
        </script>

        <script>
            document.querySelector('#txt_password').addEventListener('keydown', (e) => {
                console.log(e.which);
                if (e.which === 32) {
                    e.preventDefault();
                }
            });
        </script>

        
        
        <!-- <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%'
                });
            });
        </script> -->
    </body>
</html>
