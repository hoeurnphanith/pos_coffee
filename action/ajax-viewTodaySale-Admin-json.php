<?php
    include_once('../connectdb.php');
    session_start();
    date_default_timezone_set("Asia/Phnom_Penh");

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    $user = $_SESSION['role'];
    $username = $_SESSION['username'];
    $date = date("Y-m-d");

    ?>
   
<body>
    <table class="table view-SaleByUser table-striped" style="margin-bottom:0px;width:100%">
            <tr>
                <th width="50">លេខ</th>
                <th>អតិថិជន</th>
                <th>ផលិតផល</th>
                <th>ចំនួន</th>
                <th>តម្លៃ</th>
                <th>តម្លៃសរុម</th>
                <th>បង់ដោយ</th>
                <th>អ្នកគិតលុយ</th>
            </tr>
            <?php
                 $select = $pdo->prepare("SELECT 
                                sale_id,customer_name,sale_date,payment_type,pro_id,pro_name,qty,price,userid,username,useremail,role 
                                FROM  view_sale_byuser WHERE sale_date='$date' AND  role='$user' AND username ='$username'");
                    
                    $select->execute();
                    $sub_total = 0;
                    $id = 0;
                    while($row =$select->fetch(PDO::FETCH_OBJ)){
                        $id = $id + 1;
                        $sub_price = $row->qty * $row->price; 
                        $sub_total = $sub_price + $sub_total;
            ?>
        
                <tr>
                    <td><?php echo $id;?></td>
                    <td><?php echo $row->customer_name;?></td>
                    <td><?php echo $row->pro_name;?></td>
                    <td><?php echo $row->qty;?></td>
                    <td><?php echo $row->price;?> $</td>
                    <td><?php echo $sub_price;?> $</td>
                    <td><?php echo $row->payment_type;?></td>
                    <td><?php echo $row->username;?></td>
                </tr>
            <?php 
            } 
        ?>

      <td colspan="6"></td>
      <td style="font-weight: bold;">តម្លៃសរុបរួម​:</td> 
      <td style="font-weight: bold;"><?php echo $sub_total;?> $</td>
    </table>
</body>
    
     
    


     
 

