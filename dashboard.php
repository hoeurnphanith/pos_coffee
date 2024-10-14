<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']== "User"){
        header('location:index.php');
    }
    include_once('action/header.php');
    error_reporting(0);

    $select = $pdo->prepare("SELECT sum(total) AS t_pro , count(sale_id) AS s_pro,s_status FROM tbl_sale WHERE s_status='Enable'");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_OBJ);
    $total_sale=$row->s_pro;
    $sum_total=$row->t_pro;

    $select = $pdo->prepare("SELECT sale_date,total FROM tbl_sale WHERE s_status='Enable' GROUP BY sale_date LIMIT 30");
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
                        <a href="sale-admin-list-all.php">
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
                        <a href="customer-admin-list.php">
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
                        <a href="admin-product-list.php">
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
                        $select = $pdo->prepare("SELECT (q*purchase_price) AS total_purchase ,(q*price) AS total_sale,s_status FROM  view_sale_detail WHERE s_status='Enable'");
                        $select->execute();
                        $total_income = 0;
                        while ($row = $select->fetch(PDO::FETCH_OBJ)){
                            $total_purchase = $row->total_purchase;
                            $total_sale = $row->total_sale;
                            $income = $total_sale - $total_purchase;
                            $total_income = $total_income + $income;
                        }
                    ?>
                    
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <a href="#">
                            <span class="info-box-icon" style="background-color: #575fcf;color:white;"><i class="fa fa-usd"></i></span>
                            <div class="info-box">
                                <div class="info-box-content">
                                    <span class="info-box-text" style="font-weight:bold;color:#485460;"> ប្រាក់ចំណូលសរុប</span>
                                    <span class="info-box-number" style="font-size:25px;float:right;color:#575fcf;"><?php echo "$".number_format($total_income,2);?></span>
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
                                    <canvas id="myChart" style="height:343px"></canvas>
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

                <div class="row">

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
                                            $select=$pdo->prepare("SELECT * FROM view_sales WHERE s_status='Enable' order by sale_id desc LIMIT 6");
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
                                        $select=$pdo->prepare("SELECT pro_id,pro_name,price,SUM(q) AS q, SUM(q*price) AS total,s_status FROM view_sale_detail WHERE s_status='Enable' GROUP BY pro_id ORDER BY SUM(q) DESC LIMIT 6");
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
                    
                    
                </div>                           
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
