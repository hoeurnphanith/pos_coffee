<?php
    include_once('../connectdb.php');
    session_start();
     
    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }

    if(isset($_POST['add-save-customer'])){
        $cust_name = $_POST['txt-name'];
        $gender = $_POST['txt-gender'];
        $phone = $_POST['txt-phone'];
        $des = $_POST['txt-des'];

        $insert = $pdo->prepare("INSERT INTO tbl_customer (customer_name,gender,phone,des)
                                VALUES (:customer_name,:gender,:phone,:des)");
        $insert->bindParam(":customer_name",$cust_name);
        $insert->bindParam(":gender",$gender);
        $insert->bindParam(":phone",$phone);
        $insert->bindParam(":des",$des);
        $insert->execute();
           
        echo '<script>
                window.location.replace("../sale-detail-user.php");
            </script>';      
    }
?>