<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']== "Admin"){
        header('location:index.php');
    }
    include_once('action/headeruser.php');
    error_reporting(0);

    $user = $_SESSION['role'];
    $username = $_SESSION['username'];
    $dateByuser = date("Y-m-d");


    $select = $pdo->prepare("SELECT count(sale_id) AS sale_id FROM view_sales WHERE sale_date='$dateByuser' AND s_status='Enable' AND  role='$user' AND username ='$username'");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_OBJ);
    $total_sale = $row->sale_id;

    $select = $pdo->prepare("SELECT sale_date,total FROM view_sales WHERE role='$user'  AND s_status='Enable' AND username ='$username' GROUP BY sale_date LIMIT 30");
    $select->execute();
    $ttl = [];
    $date = [];

    while($row = $select->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $ttl[] = $total;
        $date[] = $sale_date;
    }
    // echo json_encode($total)

?>

<div class="content-wrapper">
    <section class="content container-fluid">
        
            <form action="" method="post" name="">           
                <div class="row">

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="sale-user-list.php">
                            <span class="info-box-icon" style="background-color:#45aaf2;color:white;"><i class="fa fa-shopping-cart"></i></span>
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text" style="font-weight:bold; color:#485460;">ចំនួនវិក័យប័ត្រ</span>
                                    <span class="info-box-number" style="font-size:25px;float:right;color:#45aaf2;"><?php echo $total_sale;?></span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <?php
                        $select = $pdo->prepare("SELECT COUNT(customer_id) AS count_id FROM tbl_customer");
                        $select->execute();
                        $row = $select->fetch(PDO::FETCH_OBJ);
                        $count_id = $row->count_id;
                    ?>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="customer-user-list.php">
                            <span class="info-box-icon" style="background-color: #32ff7e;color:white;"><i class="fa-solid fa-users"></i></span>
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text" style="font-weight:bold; color:#485460;">ចំនួនអតិថិជន</span>
                                    <span class="info-box-number" style="font-size:25px;float:right;color:#32ff7e;"><?php echo $count_id;?></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <?php
                        $select = $pdo->prepare("SELECT COUNT(pro_name) AS pro FROM tbl_product");
                        $select->execute();
                        $row = $select->fetch(PDO::FETCH_OBJ);
                        $total_product = $row->pro;
                    ?>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="user-product-list.php">
                            <span class="info-box-icon" style="background-color: #ef5777;color:white;"><i class="fa fa-inbox"></i></span>
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text" style="font-weight:bold;color:#485460;">ចំនួនផលិតផល</span>
                                    <span class="info-box-number" style="font-size:25px;float:right;color:#00d8d6;"><?php echo $total_product;?></span>
                                </div>
                            </div>
                        </a>
                    </div>
  

                    <?php
                        
                        $select = $pdo->prepare("SELECT 
                            sale_id,customer_name,sale_date,payment_type,pro_id,pro_name,qty,price,userid,username,useremail,role 
                            FROM  view_sale_byuser WHERE sale_date='$dateByuser' AND  role='$user' AND username ='$username' AND s_status='Enable'");
                        $select->execute();
                        $sub_total = 0;
                        while ($row = $select->fetch(PDO::FETCH_OBJ)){
                            $qty = $row->qty;
                            $price = $row->price;
                            $total = $qty * $price;
                            $sub_total = $total + $sub_total;
                        }
                    ?>
                    
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="#">
                            <span class="info-box-icon" style="background-color: #575fcf;color:white;"><i class="fa fa-usd"></i></span>
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text" style="font-weight:bold;color:#485460;"> ប្រាក់សរុបលក់បានថ្ងៃនេះ</span>
                                    <span class="info-box-number" style="font-size:25px;float:right;color:#575fcf;"><?php echo "$".number_format($sub_total,2);?></span>
                                </div>
                            </div>
                        </a>
                    </div>

                </div> 

                <br>

                <div class="row">
                    <div class="col-md-8">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title title">ប្រាក់ចំណូល​តាមកាលបរិច្ឆេទ</h3>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="myChart" style="height:378px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>  

                    <div class="col-md-4">
                        <div class="box box-info">
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="myChart1"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- <div class="row">

                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title title">ការបញ្ជាទិញថ្មីៗ</h3>
                            </div>
                            <div class="box-body">
                                <table id="orderlisttable" class="table" >
                                    <thead>
                                        <tr>
                                            <th>លេខកូដ</th>
                                            <th>អតិថិជន</th>
                                            <th>កាលបរិច្ឆេទ</th>
                                            <th>តម្លៃសរុបរួម</th>
                                            <th>បង់ដោយ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $select=$pdo->prepare("SELECT * FROM view_sales order by sale_id desc LIMIT 5");
                                            $select->execute();
                                            while($row=$select->fetch(PDO::FETCH_OBJ)){
                                                echo'
                                                <tr>
                                                    <td>'.$row->sale_id.'</td>
                                                    <td>'.$row->customer_name.'</td>
                                                    <td>'.$row->sale_date.'</td>
                                                    <td>'."$".$row->total.'</td> ';

                                                    if($row->payment_type=="Cash"){
                                                        echo'<td><span class="label" style="background-color:#ffd32a;color:white;">'.$row->payment_type.'</span></td>';
                                                    }elseif($row->payment_type=="Card"){
                                                        echo'<td><span class="label" style="background-color:#9c88ff;color:white;">'.$row->payment_type.'</span></td>';
                                                    }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title title">
                                    ផលិតផលលក់ដាច់បំផុត
                                </h3>
                            </div>

                            <div class="box-body">
                                <table id="bestsellingproduct" class="table">
                                    <thead>
                                        <tr>
                                            <th>លេខកូដ</th>
                                            <th>ឈ្មោះផលិតផល</th>
                                            <th>បរិមាណ</th>
                                            <th>តម្លៃលក់ចេញ</th>
                                            <th>តម្លៃសរុប</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $select=$pdo->prepare("SELECT pro_id,pro_name,price,SUM(q) AS q, SUM(q*price) AS total FROM view_sale_detail GROUP BY pro_id ORDER BY SUM(q) DESC LIMIT 10");
                                        $select->execute();
                                        while($row=$select->fetch(PDO::FETCH_OBJ)){
                                            $total = $row->total;
                                            echo'
                                                <tr>
                                                <td>'.$row->pro_id.'</td>
                                                <td>'.$row->pro_name.'</td>
                                                <td>'.$row->q.'</td>
                                                <td>'."$".$row->price.'</td>
                                                <td>'."$".number_format($total,2).'</td>
                                                </tr>
                                
                                            ';
                                        }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> 
                    
                    
                </div>                            -->
            </form>
    </section>


</div>

<script>
  const ctx = document.getElementById('myChart');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($date);?>,
      datasets: [{
        label: '# តម្លៃសរុប',
        data: <?php echo json_encode($ttl);?>,
        // backgroundColor: [
        //     '#45aaf2',
        // ],
    
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

<script>
  const ctx1 = document.getElementById('myChart1');

  new Chart(ctx1, {
    type: 'pie',
    data: {
        labels:[
            'Red',
            'Blue',
            'Yellow'
        ],
        datasets: [{
            label: '# តម្លៃសរុប',
            data: [11, 16,17,<?php echo json_encode($ttl);?>],
            backgroundColor: [
                'rgb(255, 99, 132)',
                '#45aaf2',
                'rgb(255, 205, 86)'
            ],
        hoverOffset: 4      
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
  });

</script>

<?php
    include_once('action/footer.php');
?>
</body>
</html>
