<!-- <script src="bower_components/sweetalert/sweetalert.js"></script>
<script src="bower_components/jquery/dist/jquery.min.js"></script> -->
<?php
    include_once('connectdb.php');
    session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Forgot Password</title>
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
        <div class="login-box" style="width: 28%;">
            <div class="login-logo">
                <!-- <a href="#"><b>COFFEE MANAGEMENT SYSTEM</b></a> -->
                <!-- <img class="img-fluid" src="dist/img/logo.png" alt="LOGO" style="width: 100px;heigh: 100px;"> -->
            </div>
            <div class="login-box-body login_bg">
                <p class="login-box-msg index">New Password</p>

                <form action="#" method="post" name="login">
                    <div class="form-group has-feedback">
                        <label for="" class="label-control">លេខសម្ងាត់</label>
                        <input type="password" class="form-control frm-control" minlength="3" id="password" name="password" placeholder="Password" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin-top:10px;margin-bottom:10px;">
                            <button type="submit" name="reset" class="btn btn-login">កំណត់ពាក្យសម្ងាត់ឡើងវិញ</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>

        <script>
            document.querySelector('#password').addEventListener('keydown', (e) => {
                console.log(e.which);
                if (e.which === 32) {
                    e.preventDefault();
                }
            });
        </script>
    
    </body>
</html>
<?php
    if(isset($_POST["reset"])){
        include('connect/connection.php');
        $psw = $_POST["password"];

        $token = $_SESSION['token'];
        $Email = $_SESSION['email'];

        $Md5 = MD5($psw);

        $sql = mysqli_query($connect, "SELECT userid,useremail,password FROM tbl_user WHERE useremail='$Email'");
        $query = mysqli_num_rows($sql);
  	    $fetch = mysqli_fetch_assoc($sql);

        if($Email){
            $new_pass = $Md5;
            mysqli_query($connect, "UPDATE tbl_user SET password='$new_pass' WHERE useremail='$Email'");
            ?>
            <script>
                window.location.replace("index.php");
                alert("<?php echo "your password has been succesful reset"?>");
            </script>
            <?php
        }else{
            ?>
            <script>
                alert("<?php echo "Please try again"?>");
            </script>
            <?php
        }
    }

?>
