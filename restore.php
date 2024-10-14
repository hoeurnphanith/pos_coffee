<?php
    $conn = mysqli_connect("localhost", "root", "", "pos_coffee");
    $conn->set_charset("utf8");
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=='User'){
        header('location:index.php');
    }
    include_once('action/header.php');
?>
<?php
    if (! empty($_FILES)) {
        // Validating SQL file type by extensions
        if (! in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
            "sql"
        ))) {
            echo '<script type="text/javascript">
                jQuery(function validation(){
                    swal({
                        title: "Warning!!",
                        text: "Invalid File Type!",
                        icon: "warning",
                        button: "Ok!",
                    });
                });
            </script>';
        } else {
            if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
                move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);
                restoreMysqlDB($_FILES["backup_file"]["name"], $conn);
            }
        }
    }

    function restoreMysqlDB($filePath, $conn){
        $sql = '';
        $success = '';
        
        if (file_exists($filePath)) {
            $lines = file($filePath);
            
            foreach ($lines as $line) {
                
                // Ignoring comments from the SQL script
                if (substr($line, 0, 2) == '--' || $line == '') {
                    continue;
                }
                
                $sql .= $line;
                
                if (substr(trim($line), - 1, 1) == ';') {
                    $result = mysqli_query($conn, $sql);
                    if (! $result) {
                        $success .= mysqli_error($conn) . "\n";
                    }
                    $sql = '';
                    
                }
            } // end foreach
            
            if($success) {
                echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                            title: "Successfully!",
                            text: "Database restore Successfully!",
                            icon: "success",
                            button: "Ok!",
                        });
                    });
                </script>';
            }else{
                echo '<script type="text/javascript">
                    jQuery(function validation(){
                        swal({
                            title: "Error!",
                            text: "Database is not restored!",
                            icon: "warning",
                            button: "Ok!",
                        });
                    });
                </script>';
            }
        } // end if file exists
    }
?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Restore Database</h1>
                <small></small>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa-solid fa-gauge"></i> Level</a></li>
                    <li class="active">Here</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h5 class="box-title ">Restore Database Form</h5>
                    </div>
                    <form method="post" action="" enctype="multipart/form-data" id="frm-restore" style="width:50%;margin-left:0;">
                        <div class="form-row box-body">
                            <div class="form-group">
                                <input type="file" name="backup_file" class="input-file input-group" />
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="restore" value="Restore" class="btn-action btn" style="background-color: #45aaf2;color:white;"><i class="fa-solid fa-floppy-disk"></i> Restore</button>
                        </div>
                    </form>
                </div>
            </section>
        </div> 
    <?php
    include_once('action/footer.php');
?>

