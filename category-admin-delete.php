<?php
    include_once('connectdb.php');

    $cate_id = $_POST['cate_idd'];
    $sql = "DELETE FROM tbl_category WHERE cate_id = $cate_id";
    $delete = $pdo->prepare($sql);
    if( $delete->execute() ) {

    }else{
        echo 'Error category is not deleted...!';
    }
?>