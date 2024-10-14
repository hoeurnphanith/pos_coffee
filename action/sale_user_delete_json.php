<?php
    include_once('../connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }


    $id = $_POST['sale_id'];
    
    $sql = "Call Sd_DeleteSale($id)" ;
    $delete = $pdo->prepare($sql);
    
    if( $delete->execute() ) {
       
    }else{
        echo 'Error User is not deleted...!';
    }
?>