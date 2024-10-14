<?php
    include_once('connectdb.php');

    $id = $_POST['pro_id'];
    
    $sql = "DELETE FROM tbl_product WHERE pro_id = $id";
    $delete = $pdo->prepare($sql);
    if( $delete->execute() ) {

    }else{
        echo 'Error User is not deleted...!';
    }
?>