<?php 
    include_once('../connectdb.php');
    session_start();
     
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }


    $key_id = $_GET['key_id'];
    $select = $pdo->prepare("SELECT * FROM tbl_product WHERE pro_id = :ppid");
    $select->bindParam(":ppid",$key_id);
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);
    $respone = $row;
    array_push($_SESSION['opt'],$row['pro_name']);
    header('Content-Type: application/json');
    echo json_encode($respone);
?>