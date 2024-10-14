<?php
    include_once('connectdb.php');

    $id = $_POST['useridd'];
    
    $sql = "DELETE FROM tbl_user WHERE userid = $id";
    $delete = $pdo->prepare($sql);
    if( $delete->execute() ) {

    }else{
        echo 'Error User is not deleted...!';
    }
?>