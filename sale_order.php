<?php
    include_once('connectdb.php');
    session_start();
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }

    include_once('action/header.php');
?>


<div class="content-wrapper">
    <section class="content">
    	<div class="box">
            <!-- ----------------------Start tabla multi data----------------------------- -->

            <div style="height:647px; box-shadow:1px 1px 2px 0 #fff; background-color:#eee"  class="col-md-4">
                <!-- <div><center><h3>Card <div class="badge bg-blue">3</div></h3></center></div> -->
                <div class="input-group" style="padding:10px 0px 5px 0px; width:100%;">
                    <input type="text" class="form-control mb-2" value="ទូទៅ">
                    <div class="input-group-addon"><i class="fa-solid fa-pencil text-primary"></i></div>
                    <div class="input-group-addon"><i class="fa-solid fa-eye text-primary"></i></div>
                    <div class="input-group-addon"><i class="fa-solid fa-circle-plus text-primary"></i></div>
                </div>

                <div class="input-group" style="padding:0px 0px 5px 0px; width:100%;">
                    <input type="text" class="form-control mb-2" placeholder="ស្វែងរកផលិតផលតាម​​ លេខកូដ​ ឈ្មោះ​ ឬ Barcode">
                    <div class="input-group-addon"><i class="fa-solid fa-circle-plus text-primary"></i></div>
                </div>

                <div class="">
                    <table class="table multi-tr" style="padding:0px 0px 5px 0px; width:100%;margin-bottom:0px;">
                        <tr>
                            <th>ផលិតផល</th> 
                            <th style="text-align:center;width:130px;">ចំនួន</th>
                            <th style="text-align:center;width:90px;">តម្លៃ</th>
                        </tr>
                    </table>
                </div>
                
                <div class="table-responsive scroll" style="height: 370px;overflow-y:scroll;">
                    <table class="table table-straped table-hover">

                        <tbody class="js-items">
                            <tr>
                                <td class="text-primary">
                                    <h2 style="margin-top:10px;font-size: 15px;font-family: 'Hanuman' serif !important;">Coffee Soft Drink</h2>
                                </td> 
                                <td>
                                    <div class="input-group" style="text-align:center; width: 120px;">
                                        <div class="input-group-addon" style="cursor: pointer;"><i class="fa-solid fa-minus text-primary"></i></div>
                                        <input type="text" name="" class="form-control text-center" placeholder="1" value="1" min="1">
                                        <div class="input-group-addon" style="cursor: pointer;"><i class="fa-solid fa-plus text-primary"></i></div>
                                    </div> 
                                </td>
                                <td>
                                    <h2 style="margin-top:10px;font-size: 15px;font-family: 'Hanuman', serif !important;">$5.00</h2>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
               
                <div style="font-size: 15px;border-radius: 0px;background-color:#add1fa;padding:10px;margin-bottom:2px;">
                    ទឹកប្រាក់សរុប: <b style="font-size: 15px;float:right;">20.00$</b>
                </div>

                <div>
                    <button class="btn" style="height:50px;width:100%;border-radius: 0px;background-color:#2ed573;color:white;margin-bottom:2px;" data-toggle="modal" data-target="#modal-default">ការទូទាត់</button>
                    <button class="btn" style="height:50px;width:50%;border-radius:0px;float:left;background-color:#ff4757;color:white;">បោះបង់</button>
                    <button class="btn" style="height:50px;width:50%;border-radius:0px;float:left;background-color:#f9ca24;color:white;"><i class="fa-solid fa-print"></i> វិក័យបត្រ</button>       
                </div>
        
            </div>

            <!-- ----------------------End tabla multi data----------------------------- -->


            <!-- -------------------------Start items box card -------------------------------->

            <div style="height:647px;box-shadow:1px 1px 2px 0 #fff; background-color:white;"  class="col-md-8">

                <div class="row" style="padding-left:10px;margin-top: 12px;width:830px;"> 

                    <div class="col-md-10">
                        <div class="input-group">
                            <input type="text" name="" class="form-control" placeholder="ស្វែងរកផលិតផលតាម លេខកូដ​ ឈ្មោះ ឬ Barcode">
                            <div class="input-group-addon"><i class="fa-solid fa-magnifying-glass text-blue"></i></div>
                        </div>
                    </div>

                    <div style="padding-right:17px;margin-left:0px;">
                        <div class="input-group">
                            <select name="" id="" class="form-control" style="margin-left:0px;padding-left:8px;">
                                <option>ក្រុមផលិតផល</option>
                                <?php
                                    $select = $pdo->prepare("SELECT * FROM tbl_category");
                                    $select->execute();
                                    
                                    while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                        ?>   
                                            <option value="<?php echo $row['cate_id'];?>"><?php echo $row['cate_name'];?></option>
                                        <?php
                                    }
                                ?>  
                            </select>
                        </div>
                    </div>
         
                </div>
                
                <div class="js-products scroll" style="height:90%;overflow-y:scroll;padding-top:0;">
               
                    <?php
                        $select = $pdo->prepare( "SELECT pro_id,pro_name,sale_price,photo,status FROM view_product_list WHERE status='Enable' ORDER BY pro_id DESC" );
                        $select->execute();
                        while( $row = $select->fetch(PDO::FETCH_OBJ)) {
                            $pro_id = $row->pro_id;
                            $pro_name = $row->pro_name;
                            $sale_price = $row->sale_price;
                            $photo = $row->photo;
                    ?>
                    <div class="col-md-2" style="padding:0px;">
                        <!-- card -->
                        <a href="#" class="card-box" data-action="add-to-cart">
                            <div class="card">
                                <div class="card-body">
                                    <img src="images/<?php echo $photo;?>" alt="">
                                </div>
                                <div class="p-2 card-font">
                                    <div class="text-muted"><?php echo mb_substr(strip_tags($pro_name),0,12,'utf8');?></div>
                                    
                                    <div class="text-muted"><b><?php echo $sale_price;?> $</b></div>
                                </div>
                            </div>
                        </a>
                        <!--end card -->
                    </div>
                    <?php
                        }
                    ?>
                    


                </div> 
            </div>


            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title title">ការទូទាត់</h4>
                    </div>
                    <div class="modal-body">
                        
                        <div class="input-group" style="float:left;width:100%;">
                            <label for="">តម្លៃសរុប</label>
                            <input type="text" class="form-control" value="" style="margin-bottom:10px;border-radius: 4px;" disabled>
                        </div>
                        <div style="width:100%;">
                            <div class="input-group" style="float:left;width:50%;">
                                <label for="">ប្រាក់ទទួល</label>
                                <input type="text" class="form-control" value="" style="margin-bottom:10px;border-radius: 4px;">
                            </div> 
                            <div class="input-group" style="float:left;width:50%;padding-left:5px;">
                                <label for="">ប្រាក់អាប់</label>
                                <input type="text" class="form-control" value="" style="margin-bottom:10px;border-radius: 4px;" disabled>
                            </div> 
                        </div>
                            
                        <div class="input-group" style="width: 100%;">
                            <label for="">បង់ដោយ</label>
                            <select name="" id="" class="form-control" style="margin-bottom:10px;border-radius: 4px;">
                                <option value="">ជ្រើសរើសប្រភេទ</option>
                                <option value="">Cash</option>
                                <option value="">Card</option>
                            </select>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn pull-left" data-dismiss="modal" style="background-color:#ff4757;color:white;padding:7px 18px;">ចាកចេញ</button>
                        <button type="button" class="btn៉" style="background-color:#9980FA;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> ការទូទាត់</button>
                    </div>
                    </div>
                </div>
            </div>
           

        </div>     
    </section>
</div>


<?php
    include_once('action/footer-sale.php');
?>


