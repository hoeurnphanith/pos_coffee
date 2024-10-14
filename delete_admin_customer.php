<?php
    include_once('connectdb.php');

    $id = $_POST['customer_id'];
    
    $sql = "DELETE FROM tbl_customer WHERE customer_id = $id";
    $delete = $pdo->prepare($sql);
    if( $delete->execute() ) {

    }else{
        echo 'Error User is not deleted...!';
    }
?>