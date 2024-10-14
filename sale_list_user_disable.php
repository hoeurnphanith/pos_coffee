<?php
    include_once('connectdb.php');
    session_start();

    if($_SESSION['username'] == "" OR $_SESSION['role']=="Admin"){
        header('location:index.php');
    }
    include_once('action/headeruser.php');

    error_reporting(0);

    $key_id = $_GET['key_id'];
    $select = $pdo->prepare("SELECT sale_id,s_status FROM tbl_sale WHERE sale_id = $key_id");
    $select->execute();
    $row = $select->fetch(PDO::FETCH_ASSOC);
    $status_db = $row['s_status'];

    if(isset($_POST['btn-update'])){
        $status = $_POST['txt-status'];

        $update=$pdo->prepare("UPDATE tbl_sale SET s_status=:status where sale_id = $key_id");   
        $update->bindParam(':status',$status);
        if($update->execute()){
            
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    window.location.replace("sale-user-list.php");
                });
            </script>';
        }
    } 
?>
    
        <div class="content-wrapper">
            <section class="content-header">
                <h1 class="dashboard-h1">លុបបញ្ជីការលក់</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa-solid fa-gauge"></i>  ទំព័រដើម</a></li>
                    <li class="active">ទំព័រដើម</li>
                </ol>
            </section>
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title title">សូមបញ្ចូលព័ត៍មានខាងក្រោម</h5>
                    </div>
                    <form role="form" action="" method="post">
                        <div class="box-body">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">ស្ថានភាព</label>
                                    <select  class="form-control" name="txt-status">
                                        <?php
                                            $option=$_POST['txt-status'];
                                            echo $option;
                                        ?>
                                        <option value="Enable" <?php if($status_db == 'Enable'){ echo "selected";}?>>Enable</option>
                                        <option value="Disable" <?php if($status_db == 'Disable'){ echo "selected";}?>>Disable</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="box-footer">
                            <a href="sale-user-list.php" class="btn" style="background-color: #ff4757;color:white;"><i class="fa-solid fa-circle-left"></i> ចាកចេញ</a>
                            <button type="submit" name="btn-update" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> ស្ថានភាព</button>
                        </div>
                    </form>

                </div>
            </section>
        </div>

<script>
    document.querySelector('#password').addEventListener('keydown', (e) => {
        console.log(e.which);
        if (e.which === 32) {
            e.preventDefault();
        }
    });
</script>

<?php
    include_once('action/footer.php');
?>
