<?php
    try{
        $pdo = new PDO('mysql:host=localhost;dbname=pos_coffee','root','', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        //echo "connection Successfully";
    }catch(PDOException $f){
        echo $f->getMessage();
    }
?>