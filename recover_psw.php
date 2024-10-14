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
        <link rel="stylesheet" href="css/sweetalert2.min.css">
        <script src="css/sweetalert2.all.min.js"></script>


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
                <p class="login-box-msg index">
                    Password Recover
                </p>

                <form action="#" method="post" name="recover_psw">
                    <div class="form-group has-feedback">
                        <label for="" class="label-control">អ៊ីម៉ែល</label>
                        <input type="text" class="form-control frm-control" id="email_address" name="email" placeholder="Email" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="row">
                        <div class="col-xs-12" style="margin-top:10px;margin-bottom:10px;">
                            <button type="submit" name="recover" onclick="apple_sound.play()"  class="btn btn-login ">យល់ព្រម</button>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>

        <script>
            var apple_sound = new Audio();
            apple_sound.src = "dist/img/apple.mp3";
        </script>

        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="plugins/iCheck/icheck.min.js"></script>
    </body>
</html>

<?php 
    if(isset($_POST["recover"])){
        include('connect/connection.php');
        $email = $_POST["email"];

        $sql = mysqli_query($connect, "SELECT userid,username,useremail,password  FROM tbl_user WHERE useremail='$email'");
        $query = mysqli_num_rows($sql);
  	    $fetch = mysqli_fetch_assoc($sql);

        if(mysqli_num_rows($sql) <= 0){
            ?>
            <script>
                alert("<?php  echo "Sorry, no emails exists "?>");
            </script>
            <?php
        }else{
            // generate token by binaryhexa 
            $token = bin2hex(random_bytes(50));

            //session_start ();
            $_SESSION['token'] = $token;
            $_SESSION['email'] = $email;

            require "Mail/phpmailer/PHPMailerAutoload.php";
            $mail = new PHPMailer;

            $mail->isSMTP();
            $mail->Host='smtp.gmail.com';
            $mail->Port=587;
            $mail->SMTPAuth=true;
            $mail->SMTPSecure='tls';

            // h-hotel account
            $mail->Username='rongc5831@gmail.com';
            $mail->Password='clttavhejscerhui';

            // send by h-hotel email
            $mail->setFrom('rongc5831@gmail.com', 'Password Reset');
            // get email from input
            $mail->addAddress($_POST["email"]);
            //$mail->addReplyTo('lamkaizhe16@gmail.com');

            // HTML body
            $mail->isHTML(true);
            $mail->Subject="Recover your password";
            $mail->Body="<b>Dear User</b>
            <h3>We received a request to reset your password.</h3>
            <p>Kindly click the below link to reset your password</p>
            http://localhost/pos_coffee/reset_psw.php
            <br><br>
            <p>With regrads,</p>
            <b>Programming with Lam</b>";

            if(!$mail->send()){
                ?>
                    <script>
                        alert("<?php echo " Invalid Email "?>");
                    </script>
                <?php
            }else{
                ?>
                    <script>
                        window.location.replace("notification.php");
                        // const Toast = Swal.mixin({
                        // toast: true,
                        // position: 'top-end',
                        // showConfirmButton: false,
                        // timer: 3000,
                        // timerProgressBar: true,
                        // didOpen: (toast) => {
                        //     toast.addEventListener('mouseenter', Swal.stopTimer)
                        //     toast.addEventListener('mouseleave', Swal.resumeTimer)
                        // }
                        // })

                        // Toast.fire({
                        // icon: 'success',
                        // title: 'Signed in successfully'
                        // })
                    </script>
                <?php
            }
        }
    }


?>
