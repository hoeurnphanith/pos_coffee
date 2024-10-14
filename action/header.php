<?php
  include_once('connectdb.php');
  date_default_timezone_set("Asia/Phnom_Penh");
  $date = date("Y-m-d");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>កន្រ្តេ-កន្រ្តក</title>
  <link rel="stylesheet" href="icon/css/all.min.css">
  <link rel="icon" href="dist/img/logo.png">
  <link rel="stylesheet" href="css/css.css">
  <script src="bower_components/sweetalert/sweetalert.js"></script>
  <script src="bower_components/jquery/dist/jquery.min.js"></script>

  <!-- using chartjs -->
  <script src="chartjs/dist/chart.umd.js"></script>

 
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Hanuman&display=swap" rel="stylesheet">


  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

   <!-- Select2 -->
   <link rel="stylesheet" href="bower_components/select2/dist/css/select2.min.css">
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/iCheck/all.css">
  

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue fixed sidebar-mini" onload="initClock()">
<div class="wrapper">
  
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo" style="background-color: #45aaf2;">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>POS</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="dist/img/logo.png" width="40"><b class="menu-title"> កន្រ្តេ-កន្រ្តក</b></span>  
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color:#45aaf2;">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <img src="dist/img/kh.png" class="user-image" style="margin-top:19px;" alt="User Image">
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <!-- date time  -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span id="dayname">Day</span>
                <span id="daynum">00</span>
                <span id="month">Month</span>
                <span id="year">Year</span>
            </a>
          </li>

          <li class="dropdown messages-menu" style="width:130px;text-align:center;margin:0px;padding:0px;">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <span id="hour">00</span>
                <span id="minutes">00</span>
                <span id="seconds" style="width: 20px;">00</span>
                <span id="period">AM</span>
            </a>
          </li>

          <li class="dropdown messages-menu">
            <a href="#" class="viewTodaySale" data-toggle="modal" data-target="#view-sale-user">
              លក់បានក្នុងថ្ងៃនេះ
            </a>
          </li>

           <!-- backup database -->
           <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa-solid fa-gears"></i>
            </a>
            <ul class="dropdown-menu">
              <li class="header">ការកំណត់</li>
              <li>
                <ul class="menu">

                  <li>
                    <a href="backup.php">
                      <i class="fa-solid fa-database text-aqua icon"></i> ទិន្នន័យបម្រុង
                    </a>
                  </li>

                  <!-- <li>
                    <a href="restore.php">
                      <i class="fa-solid fa-window-restore text-green icon"></i> Restore Database
                    </a>
                  </li> -->
                  
                </ul>
              </li>

              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>


          <!-- Notivication-->
          <?php
            $query = "SELECT COUNT(qty) as qty FROM tbl_product WHERE qty=0 AND status='Enable'";
            $sql = $pdo->prepare($query);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $count_rows = $row['qty'];
          ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa-solid fa-bell"></i>
              <span class="label label-danger"><?php echo $count_rows;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">ទំនិញអស់ពីស្តុក</li>
              <li>
                <ul class="menu">
                    <?php
                      $select = $pdo->prepare("SELECT pro_id,pro_name,qty FROM tbl_product WHERE qty=0 AND status='Enable'");
                      $select->execute();
                      while($row = $select->fetch(PDO::FETCH_OBJ)){
                    ?>
                      <li>
                        <a>
                          <i class="fa-brands fa-product-hunt text-red icon"></i>
                          <?php echo $row->pro_name;?>
                        </a>
                      </li>
                    <?php
                      }
                    ?>
                  
                </ul>
              </li>

              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>

          <!-- Notivication1-->
          <?php
            $query = "SELECT COUNT(qty) as qty FROM tbl_product WHERE qty<=2 AND qty>0 AND status='Enable'";
            $sql = $pdo->prepare($query);
            $sql->execute();
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $count_rows = $row['qty'];
          ?>
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa-solid fa-bullhorn"></i>
              <span class="label label-warning"><?php echo $count_rows;?></span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">ទំនិញជិតអស់ពីស្តុក</li>
              <li>
                <ul class="menu">
                    <?php
                      $select = $pdo->prepare("SELECT pro_id,pro_name,qty FROM tbl_product WHERE qty<=2 AND qty>0 AND status='Enable'");
                      $select->execute();
                      while($row = $select->fetch(PDO::FETCH_OBJ)){
                    ?>
                      <li>
                        <a>
                          <i class="fa-brands fa-product-hunt text-orange icon"></i>
                          <?php echo $row->pro_name;?>
                        </a>
                      </li>
                    <?php
                      }
                    ?>
                  
                </ul>
              </li>

              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>

          <!-- User Account: -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa-solid fa-envelope"></i>
              <?php echo $_SESSION['useremail'];?>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">
                      <li>
                        <a href="change-password-admin.php">
                          <i class="fa-solid fa-unlock-keyhole icon text-orange"></i> 
                            ផ្លាស់ប្ដូរលេខសម្ងាត់
                        </a>
                      </li>

                      <li>
                        <a href="logout.php">
                          <i class="fa-solid fa-power-off icon text-red"></i>
                            ចេញពីប្រព័ន្ធ
                        </a>
                      </li>

                </ul>
              </li>

            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>

  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/profile.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['username'];?></p>
          <a href="#"><i class="fa fa-circle" style="color:#0be881;"></i> <?php echo $_SESSION['role'];?></a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu icon" data-widget="tree">

        <li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i><span>ទំព័រដើម</span></a></li>

        <li class="treeview">
          <a href="#"><i class="fa-solid fa-gear"></i><span>ការកំណត់</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="add-user-registration.php"><i class="fa-solid fa-plus"></i>បន្ថែមអ្នកប្រើប្រាស់</a></li>
            <li><a href="user-registration.php"><i class="fa-solid fa-users nav-icon"></i>បញ្ចីអ្នកប្រើប្រាស់</a></li>
            <li><a href="change-password-admin.php"><i class="fa-solid fa-user"></i>ផ្លាស់ប្ដូរលេខសម្ងាត់</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fas fa-list-alt"></i><span>ក្រុមផលិតផល</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="add-admin-category.php"><i class="fa-solid fa-plus"></i>បន្ថែមក្រុមផលិតផល</a></li>
            <li><a href="category-admin.php"><i class="fa-solid fa-list"></i>បញ្ចីក្រុមផលិតផល</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa-brands fa-product-hunt"></i><span>ផលិតផល</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="add-admin-product.php"><i class="fa-solid fa-plus"></i>បន្ថែមផលិតផល</a></li>
            <li><a href="admin-product-list.php"><i class="fa-solid fa-list"></i>បញ្ចីផលិតផល</a></li>
          </ul>
        </li>
        
        <li><a href="sale-detail-admin.php"><i class="fa-solid fa-cart-plus"></i><span>ការលក់</span></a></li>
        <li><a href="sale-admin-list.php"><i class="fas fa-list-ul"></i><span>បញ្ចីការលក់</span></a></li>
        
        <li class="treeview">
          <a href="#"><i class="fa-solid fa-rectangle-list"></i><span>បញ្ចីការលក់សរុប</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="sale-admin-list-all.php"> <i class="fa-solid fa-rectangle-list"></i>បញ្ចីការលក់សរុប</a></li>
            <li><a href="sale-admin-list-all-disable.php"> <i class="fa-solid fa-rectangle-list"></i>បញ្ចីការលក់សរុបខូច</a></li>
            <li><a href="sale_order.php"> <i class="fa-solid fa-rectangle-list"></i>POS</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa-solid fa-user-group"></i><span>អតិថិជន</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="customer-admin-list.php"> <i class="fa-solid fa-user-large"></i>អតិថិជន</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa-solid fa-file-pdf"></i><span>របាយការណ៍</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="sale_detail_report_today.php"><i class="fas fa-table"></i>របាយការណ៍ លក់ក្នុងថ្ងៃនេះ</a></li>
            <li><a href="sale_detail_report.php"><i class="fas fa-table"></i>របាយការណ៍ ការលក់សរុប</a></li>
            <li><a href="product_list_admin_report.php"><i class="fas fa-table"></i>របាយការណ៍ ផលិតផលក្នុងស្តុក​ </a></li>
            <li><a href="product_device_admin_report.php"><i class="fas fa-table"></i>របាយការណ៍ ផលិតផលអស់ស្តុក </a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#"><i class="fa-solid fa-right-from-bracket"></i><span>ចាកចេញ</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="logout.php"> <i class="fa-solid fa-power-off"></i>ចេញពីប្រព័ន្ធ</a></li>
          </ul>
        </li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

<div class="modal fade" id="view-sale-user">
    <div class="modal-dialog modal-lg" style="width:50%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title title">លក់បានក្នុងថ្ងៃនេះ (<?php echo date("d M Y");?>)</h4>
            </div>
            <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn pull-left" data-dismiss="modal" style="background-color:#ff4757;color:white;padding:7px 18px;">ចាកចេញ</button>
                </div>
            </div>
            
        </div>
    </div>
</div>

<script type='text/javascript'>
        $(document).ready(function(){
            $('.viewTodaySale').click(function(){
                $.ajax({
                    url: 'action/ajax-viewTodaySale-Admin-json.php',
                    type: 'post',
                    data: {},
                    success: function(response){ 
                        $('.modal-body').html(response); 
                        $('#view-sale-user').modal('show'); 
                    }
                });
            
            });
        });
</script>

<script type="text/javascript">
  function updateClock(){
    var now = new Date();
    var dname = now.getDay(),
        mo = now.getMonth(),
        dnum = now.getDate(),
        yr = now.getFullYear(),
        hou = now.getHours(),
        min = now.getMinutes(),
        sec = now.getSeconds(),
        pe = "AM";

        if(hou==0){
          hou = 12;
        }

        if(hou > 12){
          hou = hou - 12;
          pe = "PM";
        }

        Number.prototype.pad = function(digits){
          for(var n = this.toString(); n.length < digits; n = 0 + n);
          return n;
        }

        var months = ["មករា","កុម្ភះ","មិនា","មេសា","ឧសភា","មិថុនា","កក្ដដា","សីហា","កញ្ញា","តុលា","វិច្ឆិកា","ធ្នូ"];
        var week = ["អាទិត្យ","ចន្ទ","អង្គារ","ពុធ","ព្រហស្បតិ៍","សុក្រ","សៅរ៍"];
        var ids = ["dayname","month","daynum","year","hour","minutes","seconds","period"];

        var values = ["ថ្ងៃ"+week[dname],"ខែ"+months[mo],"ទី"+dnum.pad(2),"ឆ្នាំ​"+yr,hou.pad(2)+":",min.pad(2)+":",sec.pad(2),pe];
        for(var i=0;i < ids.length;i++){
          document.getElementById(ids[i]).firstChild.nodeValue = values[i];
        }
  }

  function initClock(){
    updateClock();
    window.setInterval("updateClock()",1);
  } 

</script>