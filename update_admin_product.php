<?php
    include_once('connectdb.php');
    session_start();
    
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }
    include_once('action/header.php');
    
    error_reporting(0);

    $id = $_GET['id'];
    $select=$pdo->prepare("SELECT * FROM tbl_product WHERE pro_id = $id");
    $select->execute();
    $row=$select->fetch(PDO::FETCH_ASSOC);
    $pro_id_db = $row['pro_id'];

    $cate_id_db = $row['cate_id'];
    $pro_name_db = $row['pro_name'];
    $purchase_price_db = $row['purchase_price'];
    $qty_db = $row['qty'];
    $sale_price_db = $row['sale_price'];
    $des_db = $row['des'];
    $date_db = date("Y/m/d");
    $status_db = $row['status'];
    $photo_db = $row['photo'];
    
    if(isset($_POST['btnupdateproduct'])){
        $pro_name = trim($_POST['txt-pro']);
        $cate_id = $_POST['txt-cate'];
        $purchase_price = $_POST['txt-purchase-price'];
        $qty = $_POST['txt-qty'];
        $sale_price = $_POST['txt-sale-price'];
        $des = $_POST['txt-des'];
        $date = date("Y/m/d");
        $status = $_POST['txt-status'];

        $f_name = $_FILES['myfile']['name'];
        if(!empty($f_name)){
            $f_tmp = $_FILES['myfile']['tmp_name'];
            $f_size = $_FILES['myfile']['size'];
    
            $f_extension = explode('.',$f_name);
            $f_extension = strtolower(end($f_extension));
            $f_newfile = uniqid().'.'.$f_extension;
            $store = "images/".$f_newfile;
           
            if($f_extension == 'jpg' || $f_extension=='jpeg' || $f_extension=='png' || $f_extension=='gif'){
                if($f_size>=1000000){
                    $error= '<script type="text/javascript">
                                jQuery(function validation(){
                                    swal({
                                        title: "កំហុស!",
                                        text: "រូបភាព​អាចបញ្ចុលបានធំបំផុតត្រឹម 1MB!",
                                        icon: "warning",
                                        button: "Ok",
                                    });
                                });
                            </script>';
                    echo $error;
                }else{
                    if(move_uploaded_file($f_tmp,$store)){
                        $f_newfile;
                    }  
                }   
            }else{
                $error = '<script type="text/javascript">
                            jQuery(function validation(){
                                swal({
                                    title: "ព្រមាន!",
                                    text: "សូមអភ័យទោស! លោកអ្នកអាចបញ្ចូលត្រឺមតែ​ file jpg ,jpeg,png, ហើយ gif តែប៉ុណ្ណោះ!",
                                    icon: "error",
                                    button: "Ok",
                                });
                            });
                        </script>';
                echo $error;
            }
    
            if(!isset($error)){
                $update = $pdo->prepare("UPDATE tbl_product SET cate_id=:cate_id, pro_name=:pro_name, qty=:qty, purchase_price=:purchase_price, sale_price=:sale_price, des=:des, photo=:photo, date=:date, status=:status WHERE pro_id = $id");
                $update->bindParam(':cate_id',$cate_id,PDO::PARAM_INT);
                $update->bindParam(':pro_name',$pro_name,PDO::PARAM_STR, 120);
                $update->bindParam(':qty',$qty,PDO::PARAM_INT);
                $update->bindParam(':purchase_price',$purchase_price,PDO::PARAM_STR, 120);
                $update->bindParam(':sale_price',$sale_price,PDO::PARAM_STR, 120);
                $update->bindParam(':des',$des,PDO::PARAM_STR, 320);
                $update->bindParam(':photo',$f_newfile,PDO::PARAM_STR, 120);
                $update->bindParam(':date',$date,PDO::PARAM_STR, 120);
                $update->bindParam(':status',$status,PDO::PARAM_STR, 12);

                if($update->execute()){
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            swal({
                                title: "ជោគជ័យ!",
                                text: "ផលិតផលគឺត្រូវបានកែប្រែដោយជោគជ័យ!",
                                icon: "success",
                                button: "Ok",
                                timer:1000,
                            });
                        });
                    </script>';
                    
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            window.location.replace("admin-product-list.php");
                        });
                    </script>';

                }else{
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            swal({
                                title: "កំហុស!",
                                text: "ផលិតផលគឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
                                icon: "error",
                                button: "Ok",
                            });
                        });
                    </script>';
                }
            }
        }else{
            if(isset($_POST['txt-pro'])){
                $select = $pdo->prepare( " SELECT pro_name FROM tbl_product WHERE pro_name = '$pro_name' && pro_id != $pro_id_db" );
                $select->execute();
                if( $select->rowCount() > 0 ) {
                    echo '<script type="text/javascript">
                        jQuery(function validation(){
                            swal({
                                title: "ព្រមាន!",
                                text: "សូមអភ័យទោស! ផលិតផលគឺមានរួចរាល់ម្តងហើយ!",
                                icon: "warning",
                                button: "Ok",
                            });
                        });
                    </script>';
                }else{
                    $update = $pdo->prepare("UPDATE tbl_product SET cate_id=:cate_id, pro_name=:pro_name, qty=:qty, purchase_price=:purchase_price, sale_price=:sale_price, des=:des, photo=:photo, date=:date, status=:status WHERE pro_id = $id");

                    $update->bindParam(':cate_id',$cate_id,PDO::PARAM_INT);
                    $update->bindParam(':pro_name',$pro_name,PDO::PARAM_STR, 120);
                    $update->bindParam(':qty',$qty,PDO::PARAM_INT);
                    $update->bindParam(':purchase_price',$purchase_price,PDO::PARAM_STR, 120);
                    $update->bindParam(':sale_price',$sale_price,PDO::PARAM_STR, 120);
                    $update->bindParam(':des',$des,PDO::PARAM_STR, 320);
                    $update->bindParam(':photo',$photo_db,PDO::PARAM_STR, 120);
                    $update->bindParam(':date',$date,PDO::PARAM_STR, 120);
                    $update->bindParam(':status',$status,PDO::PARAM_STR, 12);

                    if($update->execute()){
                        $error = '<script type="text/javascript">
                            jQuery(function validation(){
                                swal({
                                    title: "ជោគជ័យ",
                                    text: "ផលិតផលគឺត្រូវបានកែប្រែដោយជោគជ័យ!",
                                    icon: "success",
                                    button: "Ok",
                                    timer:1000,
                                });
                            });
                        </script>';
                    echo $error;

                    echo '<script type="text/javascript">
                            jQuery(function validation(){
                                window.location.replace("admin-product-list.php");
                            });
                        </script>';

                    }else{
                        $error = '<script type="text/javascript">
                                jQuery(function validation(){
                                swal({
                                    title: "កំហុស!",
                                    text: "ផលិតផលគឺមិនត្រូវបានកែប្រែក្នុងប្រព័ន្ធទេ!",
                                    icon: "error",
                                    button: "Ok",
                                });
                            });
                        </script>';
                        echo $error;
                    }
                }  
            }
        }
    }
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 class="dashboard-h1">កែប្រែផលិតផល</h1>
            <small></small>
            <ol class="breadcrumb">
                <li><a href="#" class="text-right"><i class="fa-solid fa-gauge"></i> ទំព័រដើម</a></li>
                <li class="active text-right">ទំព័រដើម</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat Box) -->
            <div class="box box-info">
                <div class="box-header with-border">
                    <h5 class="box-title title">សូមបញ្ចូលព័ត៍មានខាងក្រោម</h5>
                </div>
                <!-- form start  -->
                <form action="" role="form" method="post" name="formproduct" enctype="multipart/form-data">
                    <div class="box-body">      
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="" class="form-label">ឈ្មោះផលិតផល</label>
                                    <input type="text" name="txt-pro" value="<?php echo $pro_name_db; ?>" class="form-control" placeholder="Enter Product Name" id="">
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">ក្រុមផលិតផល</label>
                                    <select class="form-control" name="txt-cate" required>
                                        <option value="" disabled selected> Select Category </option>
                                        <?php
                                            $select = $pdo->prepare("SELECT cate_id,cate_name FROM tbl_category WHERE status='Enable'");
                                            $select->execute();
                                            while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                                $cate_id = $row['cate_id'];
                                            // extract($row);
                                            ?>
                                                <option <?php if($cate_id==$cate_id_db) {?> selected = "selected" <?php } ?> value="<?php echo $row['cate_id'];?>">
                                                    <?php echo $row['cate_name']; ?>
                                                </option>

                                            <?php
                                            }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">តម្លៃទិញចូល</label>
                                    <input type="number" 
                                        value="<?php echo $purchase_price_db; ?>" 
                                        min="1" step="1" 
                                        name="txt-purchase-price" 
                                        class="form-control" 
                                        placeholder="Enter Purchase Price" 
                                        id=""

                                        pattern="(^[0-9]{0,2}$)|(^[0-9]{0,2}\.[0-9]{0,5}$)"
                                        step="any"
                                        maxlength="7"
                                        validate="true"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">តម្លៃលក់ចេញ</label>
                                    <input type="text" 
                                        value="<?php echo $sale_price_db; ?>" 
                                        min="1" 
                                        step="1" 
                                        name="txt-sale-price" 
                                        class="form-control" 
                                        placeholder="Enter Sale Price" 
                                        id=""

                                        pattern="(^[0-9]{0,2}$)|(^[0-9]{0,2}\.[0-9]{0,5}$)"
                                        step="any"
                                        maxlength="7"
                                        validate="true"
                                    >
                                </div>

                                <div class="form-group">
                                    <label for="" class="form-label">ស្ថានភាព</label>
                                    <select  class="form-control" name="txt-status">
                                        <?php
                                            $option=$_POST['txt-status'];
                                            echo $option;
                                        ?>
                                        <option value="Enable"
                                            <?php
                                                if($status_db == 'Enable')
                                                {
                                                    echo "selected";
                                                }
                                            ?>
                                            >Enable</option>
                                        <option value="Disable"
                                            <?php
                                                if($status_db == 'Disable')
                                                {
                                                    echo "selected";
                                                }
                                            ?>
                                            >Disable</option>
                                    </select>
                                </div>

                            </div>
                            
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="" class="form-label">បរិមាណ</label>
                                    <input type="number" 
                                        value="<?php echo $qty_db; ?>" 
                                        min="0" 
                                        step="1" 
                                        name="txt-qty" 
                                        class="form-control" 
                                        placeholder="Enter Quantity" 
                                        id=""
                                    >

                                </div>
                                
                                <div class="form-group">
                                    <label for="" class="form-label">បរិយាយទំនិញ</label>
                                    <textarea name="txt-des" value="" id="" class="form-control" cols="30" rows="4" placeholder="Enter..."><?php echo $des_db; ?></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="" class="">រូបភាព</label>
                                    <input type="file" name="myfile" class="input-group form-control" id="" onchange="readURL(this);">
                                    <p>សូមបញ្ចូលរូបភាព</p>
                                    <img style="padding-top: 10px;" src = "images/<?php echo $photo_db;?>" id="img_preview" class="img-responsive" width="100" height="100"/>
                                    
                                </div>

                            </div>
                    </div>

                    <div class="box-footer">
                        <a href="admin-product-list.php" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                        <button type="submit" class="btn" style="background-color:#45aaf2;color:white;" name="btnupdateproduct"><i class="fa-solid fa-floppy-disk"></i> កែប្រែផលិតផល</button>
                    </div>

                </form>
            </div>
        </section>
    </div>  

    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img_preview').attr('src', e.target.result)
                    .width(100)
                    .height(100);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
<?php
    include_once('action/footer.php');
?>