<?php
    include_once('connectdb.php');
    session_start();
    $_SESSION['opt'] = array(0);
    if($_SESSION['username'] == "" OR $_SESSION['role']=="User"){
        header('location:index.php');
    }

    include_once('action/header.php');
    
    error_reporting(0);

    function fill_product($pdo){
        $output = '';
        $max = sizeof($_SESSION['opt']);
        $sql_select = "SELECT * FROM tbl_product WHERE status='Enable' AND pro_name NOT IN('";
        for($i=0; $i<$max; $i++){
            $sql_select .= $_SESSION['opt'][$i];
            if($i<$max-1){
                $sql_select .= "','";
            }else{
                $sql_select .= "') ORDER BY pro_name ASC";
            }
        }
        
        $select = $pdo->prepare($sql_select);
        $select->execute();
        $result = $select->fetchAll();
        foreach ($result as $row){
            if($row['qty'] != 0){
                $output.= '<option value="'.$row['pro_id'].'"> '.$row['pro_name'].' </option>';
            }else{
                continue;
            }
        }
        return $output;
    }

    // get input
    if(isset($_POST['btnsaveorder'])){
        $user_id = $_SESSION['userid'];
        $customer_name = $_POST['txt-customer'];
        $sale_date = date("Y-m-d",strtotime($_POST['orderdate']));
        $subtotal = $_POST['txtsubtotal'];
        $discount = $_POST['txtdiscount'];
        $total = $_POST['txttotal'];
        $paid = $_POST['txtpaid'];
        $due = $_POST['txtdue'];
        $payment_type = $_POST['rb'];
        $s_status = "Enable";

        //get array input 
        $arr_productid = $_POST['productid'];
        $arr_stock = $_POST["stock"];
        $arr_qty = $_POST['qty'];
        $arr_price = $_POST['price'];
        $arr_total = $_POST['total'];

        if($paid >= $subtotal){
            $insert = $pdo->prepare("INSERT INTO tbl_sale (userid,customer_id,sale_date,sub_total,discount,total,paid,due,payment_type,s_status)
                                    VALUES (:userid,:cust,:sale_date,:stotal,:disc,:total,:paid,:due,:ptype,:s_status)");
            $insert->bindParam(":userid",$user_id);
            $insert->bindParam(":cust",$customer_name);
            $insert->bindParam(":sale_date",$sale_date);
            $insert->bindParam(":stotal",$subtotal);
            $insert->bindParam(":disc",$discount);
            $insert->bindParam(":total",$total);
            $insert->bindParam(":paid",$paid);
            $insert->bindParam(":due",$due);
            $insert->bindParam(":ptype",$payment_type);
            $insert->bindParam(":s_status",$s_status);
            $insert->execute();

            // 2nd insert query for tbl_sale_detail
            $sale_id = $pdo->lastInsertId();
            if($sale_id != 0){
                for($i=0; $i<count($arr_productid); $i++){
                    $insert = $pdo->prepare("INSERT INTO tbl_sale_detail (sale_id,pro_id,qty,price)
                                            VALUES (:sale_id,:pro_id,:qty,:price)");
                    $insert->bindParam(':sale_id',$sale_id);
                    $insert->bindParam(':pro_id',$arr_productid[$i]);
                    $insert->bindParam(':qty',$arr_qty[$i]);
                    $insert->bindParam(':price',$arr_price[$i]);
                    $insert->execute();
                }
            
                echo '<script>
                        window.location.replace("sale-admin-list.php");
                    </script>';
            }
        }
    }

?>

<div class="content-wrapper">
    <section class="content">

        <form action="" role="form" method="post" name="formproduct" enctype="multipart/form-data"> 
            <div class="col-md-8">
                <div class="box">
                    <div class="box-body">      
                        <div class="form-group">
                            <div class="input-group">
                               
                                <select name="txt-customer" id="" class="form-control">
                                    <?php
                                        $select = $pdo->prepare("SELECT * FROM tbl_customer");
                                        $select->execute();
                                        while($row = $select->fetch(PDO::FETCH_ASSOC)){
                                            ?>
                                                <option value="<?php echo $row['customer_id'];?>"><?php echo $row['customer_name'];?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                              
                                <div class="input-group-addon">
                                    <i class="fa-solid fa-pencil text-blue"></i>
                                </div>
                                <div class="input-group-addon">
                                    <i class="fa-solid fa-eye text-blue"></i>
                                </div>
                                <div class="input-group-addon">
                                    <i class="fa-solid fa-circle-plus text-blue" data-toggle="modal" data-target="#add-customer"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="col-md-10">  
                            <div style="overflow-x:auto;">
                                <table class="table table-striped" id="producttable">
                                    <thead>
                                        <tr>
                                            <th width="0"></th>
                                            <th>ជ្រើសរើសផលិតផល</th>
                                            <th>ស្តុក</th>
                                            <th>តម្លៃ</th>
                                            <th>បរិមាណ</th>
                                            <th>តម្លៃសរុប</th>
                                            <th></th>
                                        </tr>
                                        
                                    </thead>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" name="add" style="border-radius: 4px;background-color:#0be881;color:white;margin-bottom:10px;padding:6px;" class="btn  btn-sm btnadd"><i class="fa-solid fa-plus"></i> បន្ថែមផលិតផល</button>
                        </div>
                        

                    </div>
                </div>

            </div>

            <div class="col-md-4">
                <div class="box">
                    <div class="box-body">

                        <div class="col-md-12">       
                            <div class="form-group">
                                <div class="input-group date">
                                    <div class="input-group-addon text-blue">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </div>
                                    <input type="text" name="orderdate" class="form-control pull-right" value="<?php echo date("Y-m-d");?>" data-date-format="yyyy-mm-dd" readonly>
                                </div>
                            </div> 

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> -->
                                        <!-- <label for="">តម្លៃសរុប</label> -->
                                        <!-- <div class="input-group"> -->
                                            <!-- <div class="input-group-addon">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                            </div> -->
                                            <input type="hidden" class="form-control" name="txtsubtotal" id="txtsubtotal" readonly>
                                        <!-- </div>
                                    </div>
                                </div>
                            </div> -->

                            <!-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group"> -->
                                        <!-- <label for="">បញ្ចុះតម្លៃ</label> -->
                                        <!-- <div class="input-group"> -->
                                            <!-- <div class="input-group-addon">
                                                <i class="fa-solid fa-dollar-sign"></i>
                                            </div> -->
                                            <input type="hidden" class="form-control" name="txtdiscount" id="txtdiscount" required>
                                        <!-- </div>
                                    </div>
                                </div>
                            </div> -->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">តម្លៃសរុបរួម</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa-solid fa-dollar-sign text-blue"></i>
                                            </div>
                                            <input type="text" class="form-control" name="txttotal" id="txttotal" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ប្រាក់ទទួល</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa-solid fa-dollar-sign text-blue"></i>
                                            </div>
                                            <input 
                                                type="number" 
                                                class="form-control" 
                                                name="txtpaid" 
                                                id="txtpaid" 
                                                
                                                pattern="(^[0-9]{0,2}$)|(^[0-9]{0,2}\.[0-9]{0,5}$)"
                                                step="any"
                                                maxlength="7"
                                                validate="true"
                                                required
                                            >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ប្រាក់អាប់</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa-solid fa-dollar-sign text-blue"></i>
                                            </div>
                                            <input type="text" class="form-control" name="txtdue" id="txtdue" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <label for="">Payment Method</label>
                            <div class="form-group">
                                <label for="">
                                <input type="radio" name="rb" class="minimal-red" value="Card" checked>Card
                                </label>
                                <label for="">
                                    <input type="radio" name="rb" class="minimal-red" value="Cash" checked>Cash
                                </label>
                            </div>

                            <div>
                                <input type="submit" name="btnsaveorder" value="បន្ថែមការលក់" class="btn" style="background-color:#45aaf2;color:white;padding:7px 18px;border:none;border-radius: 4px;margin-bottom:200px;">
                            </div>
                        </div>

                    </div>
                </div>   
            </div>
        </form>
        
    </section>

    <div class="modal fade" id="add-customer">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title title">បន្ថែមអតិថិជន</h4>
                </div>

                <form action="action/add-customer-admin.php" method="POST">
                    <div class="modal-body"> 
                        <div class="input-group" style="float:left;width:100%;">
                            <label for="">ឈ្មោះអតិថិជន</label>
                            <input type="text" class="form-control" name="txt-name" placeholder="Enter Name" id="txt-name" value="" style="margin-bottom:10px;border-radius: 4px;" required>
                        </div>
                        <div style="width:100%;">
                            <div class="input-group" style="float:left;width:100%;">
                                <label for="">ភេទ</label>
                                <select name="txt-gender" id="txt-gender" class="form-control"style="margin-bottom:10px;border-radius: 4px;">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                </select>
                            </div> 
                        </div>

                        <div style="width:100%;">
                            <div class="input-group" style="float:left;width:100%;">
                                <label for="">លេខទូរស័ព្ធ</label>
                                <input type="text" name="txt-phone" placeholder="Optional" id="txt-phone" class="form-control" value="" style="margin-bottom:10px;border-radius: 4px;">
                            </div> 
                        </div>
                        <div style="width:100%;">
                            <div class="input-group" style="float:left;width:100%;">
                                <label for="">បរិយាយ</label>
                                <textarea name="txt-des" id="txt-des" cols="30" placeholder="Optional" class="form-control" rows="4" style="margin-bottom:10px;border-radius: 4px;"></textarea>
                            </div> 
                        </div>
                            
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn pull-left" data-dismiss="modal" style="background-color:#ff4757;color:white;padding:7px 18px;">ចាកចេញ</button>
                        <button type="submit" name="add-save-customer" class="btn៉" style="background-color:#9980FA;color:white;padding:7px 18px;border:none;border-radius: 4px;"><i class="fa-solid fa-floppy-disk"></i> បន្ថែមអតិថិជន</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>


<?php
    include_once('action/footer.php');
?>

<script>
    // Date picker
    $('#datepicker').datepicker({
        autoclose:true
    });

    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })

    // multi insert sale detail
    $('document').ready(function(){
        $('body').on('click','.btnadd',function(){
            var html = '';
            html += '<tr class="table-color">';
            html += '<td> <input type="hidden" class="form-control pname" name="productname[]" readonly> </td>';

            html += '<td>   <select class="form-control productid" name="productid[]" style="width:250px;" required>'+
                                ' <option value=""> ជ្រើសរើសផលិតផល </option><?php echo fill_product($pdo);?>'+
                            '</select> '+
                    '</td>';

            html += '<td> <input type="text" class="form-control stock" name="stock[]" readonly> </td>';
            html += '<td> <input type="text" class="form-control price" name="price[]" readonly> </td>';
            html += '<td> '+
                        '<input type="number" min="1" step="1" class="form-control qty" name="qty[]" required>'+
                    '</td>';

            html += '<td> <input type="text" class="form-control total" name="total[]" readonly> </td>';

            html += '<td>'+
                        '<center>'+
                            ' <button type="button" name="remove" class="btn btn-sm btnremove" style="background-color:#ff4757;color:white;padding:6px 10px; border-radius: 4px;margin-bottom:1px;"><i class="fa-regular fa-trash-can"></i></button>'+
                        '</center>'+
                    '</td>';
                    
            $('#producttable').append(html);

            // Initialize Select2 Element
            $('.productid').select2();

            $('.productid').on('change',function(e){
                var productid = this.value;
                var tr = $(this).parent().parent();

                $.ajax({
                    url:"action/get-product-admin-json.php",
                    method:"get",
                    data:{key_id:productid},
                    success:function(data){
                        //console.log(data);
                        tr.find('.pname').val(data["pro_name"]);
                        tr.find('.stock').val(data["qty"]);
                        tr.find('.price').val(data["sale_price"]);
                        tr.find('.qty').val(1);
                        tr.find('.total').val(tr.find(".qty").val() * tr.find(".price").val());
                        calculate(0,0);
                    }
                })
            });

            // remove multi row
            $('body').on('click','.btnremove',function(){
                $(this).closest('tr').remove();
                calculate(0,0);
                $("#txtpaid").val(0);
            });

            $('#producttable').delegate(".qty","keyup change",function(){
                var quantity = $(this);
                var tr = $(this).parent().parent();
                if((quantity.val()-0) > (tr.find(".stock").val()- 0 )){
                    swal("WARNING!","សូមអភ័យទោស! ផលិតផលគឺត្រូវបាន​អស់ពីស្តុក","warning");
                    quantity.val(1);
                    tr.find(".total").val(quantity.val() * tr.find(".price").val());
                    calculate(0,0);

                }else{
                    tr.find('.total').val(quantity.val() * tr.find(".price").val());
                    calculate(0,0);
                }
            });
        });

        function calculate(dis,paid){
            var subtotal = 0;
            var discount = dis;
            var net_total = 0;
            var paid_amt = paid;
            var due = 0;
            $(".total").each(function(){
                subtotal = subtotal + ( $(this).val() * 1);
            });

            net_total = subtotal;

            net_total = net_total - discount;
            due = net_total - paid_amt;

            //sub total
            $("#txtsubtotal").val(subtotal.toFixed(2));

            // net_total
            $("#txttotal").val(net_total.toFixed(2));

            // Discount
            $("#txtdiscount").val(discount);
            $("#txtdue").val(due.toFixed(2));
        }

        $("#txtdiscount").keyup(function(){
            var discount = $(this).val();
            calculate(discount,0);
        });

        $("#txtpaid").keyup(function(){
            var paid = $(this).val();
            var discount = $("#txtdiscount").val();

            // calling function
            calculate(discount,paid);
        });

    });

</script>


