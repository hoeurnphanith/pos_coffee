<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');

    error_reporting(0);

    $key_id = $_GET['customer_id'];
    $select = $pdo->prepare("SELECT * FROM tbl_customer WHERE customer_id = $key_id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);

    $cust_id_db = $row['customer_id'];
    $cust_name_db = $row['customer_name'];
    $gender_db = $row['gender'];
    $phone_db = $row['phone'];
    $des_db = $row['des'];

    if(isset($_POST['btnupdate'])){
        $cust_name = trim($_POST['txt-customername']);
        $gender = $_POST['txt-gender'];
        $phone =  $_POST['txt-phone'];
        $des = $_POST['txt-des'];
        

      
           
        $update=$pdo->prepare("UPDATE tbl_customer SET customer_name=:customer_name,gender=:gender,phone=:phone, des=:des where customer_id = $key_id");   
        $update->bindParam(':customer_name',$cust_name);
        $update->bindParam(':gender',$gender);
        $update->bindParam(':phone',$phone);
        $update->bindParam(':des',$des);
        if($update->execute()){
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                        title:"ជោគជ័យ!",
                        text:"អតិថិជនគឺត្រូវបានកែប្រែដោយជោគជ័យ!",
                        icon:"success",
                        button:"OK",
                        timer:1000,
                    });
                });
            </script>';

            echo '<script type="text/javascript">
                        jQuery(function validation(){
                            window.location.replace("customer-admin-list.php");
                        });
                    </script>';
        }else{
            echo '<script type="text/javascript">jQuery(function validation(){
                    swal({
                        title:"កំហុស!",
                        text:"អតិថិជនគឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
                        icon:"error",
                        button:"OK",
                    });
                });
            </script>';
        }   
    } 
?>
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">កែប្រែអតិថិជន</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                    <li class="active text-right">ទំព័រដើម</li>
                </ol>
            </section>
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title title">សូមបញ្ចូលព័ត៍មានខាងក្រោម</h5>
                    </div>
                    <form role="form" action="" method="post" name="formcategory" style="width:50%;margin-left:0;">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="">អតិថិជន</label>
                                <input type="text" class="form-control" value="<?php echo $cust_name_db;?>" name="txt-customername" required>
                            </div>
                            <div class="form-group">
                                <label for="">ស្ថានភាព</label>
                                <select  class="form-control" name="txt-gender">
                                    <?php
                                        $option=$_POST['txt-gender'];
                                        echo $option;
                                    ?>
                                    <option value="Female" <?php if($gender_db == 'Female'){ echo "selected";}?>>Female</option>
                                    <option value="Male" <?php if($gender_db == 'Male'){ echo "selected";}?>>Male</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">លេខទូស័ព្ទ</label>
                                <input type="text" class="form-control" value="<?php echo $phone_db;?>" name="txt-phone">
                            </div>
            

                            <div class="form-group">
                                <label for="">បរិយាយ</label>
                                <textarea name="txt-des" id="" cols="30" rows="5" class="form-control"><?php echo $des_db;?>  </textarea>
                            </div>
                            
                        </div>
                        <div class="box-footer">
                            <a href="customer-admin-list.php" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ </a>
                            <button type="submit" name="btnupdate" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> កែប្រែអតិថិជន</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
<?php
    include_once('action/footer.php');
?>