<?php
    include_once('../connectdb.php');
    session_start();
     
    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }
    
    $view_proid = $_POST['view_proid'];
    $select = $pdo->prepare( "SELECT pro_id,cate_id,cate_name,pro_name,qty,purchase_price,des,sale_price,photo,date,status FROM view_product_list WHERE pro_id=$view_proid" );
    $select->execute();
    while( $row = $select->fetch(PDO::FETCH_OBJ)) {
        $pro_id = $row->pro_id;
        $pro_name = $row->pro_name;
        $cate_name = $row->cate_name;
        $qty = $row->qty;
        $purchase_price = $row->purchase_price;
        $sale_price = $row->sale_price;
        $des = $row->des;
        $date = $row->date;
        $photo = $row->photo;
        $status = $row->status;
    ?>
    <table class="table table-striped" style="margin-bottom:0px;width:100%">
        <tr>
            <td><span>លេខកូដ: </span><?php echo $pro_id;?></td>
        </tr>
        <tr>
            <td><span>ផលិតផល: </span><?php echo $pro_name;?></td>
        </tr>
        <tr>
            <td><span>ក្រុមផលិតផល: </span><?php echo $cate_name;?></td>
        </tr>
        <tr>
            <td><span>បរិមាណ: </span><?php echo $qty;?></td>
        </tr>
        
        <tr>
            <td><span>តម្លៃទិញចូល: </span><?php echo $purchase_price?> $</td>
        </tr>
        <tr>
            <td><span>តម្លៃលក់ចេញ: </span><?php echo $sale_price;?> $</td>
        </tr>
        <tr>
            <td><span>បរិយាយ: </span><?php echo $des;?></td>
        </tr>
        <tr>
            <td><span>កាលបរិច្ឆេទ: </span><?php echo $date;?></td>
        </tr>
        <tr>
            <td><span>ស្ថានភាព: </span><?php echo $status;?></td>
        </tr>
        <tr>
            <td>
                <span>រូបភាព:</span>
                <div style="margin-left:70%;">
                    <img src = "images/<?php echo $photo;?>" class="img-rounded" width="110px" height="110px"/>
                </div>
                
            </td>
        </tr>
    </table>
     
    <?php 
    } 
    
?>
