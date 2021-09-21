<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->

  <section class="content">
  <!--<?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>-->
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
          
		   <h3 class="box-title" id="heading">Order</h3>
		 
		  
            <div class="box-tools">
              <!--  -->

              <!-- <button type="button" class="btn-sm  btn btn-success orderModalButtonadd" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Order</button> -->
             

             
           
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body" name="visible" id="qwer">  
    <div class="box-body col-xs-12"> 
      <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'order/orderTable' ?>" class="form-label-left">
        <div class="row">
      
            <div class="col-sm-2 col-xs-2 filterbox" >
              From:<?php if($fromData==''){ ?>
              <input type="date"  name="from_date"   class="form-control wid_119" id="from_date" value="" >
              <?php }else{ ?>
              <input type="date"  name="from_date"  class="form-control wid_119" id="from_date" value="<?php echo $fromData ?>" >
              <?php } ?>
            </div>
        
       
            
            <div class="col-sm-2 col-xs-2 filterbox" >
            To:<?php if($toData==''){ ?>
              <input type="date"  name="to_date"  class="form-control wid_119"  id="to_date" value="" >
               <?php }else{ ?>
               <input type="date"  name="to_date" class="form-control wid_119"  id="to_date" value="<?php echo $toData;?>" >
                <?php } ?>
            </div>
            
            <div class="col-sm-2">
                 
                 Product
                 <?php if($toData==''){ ?>
                 <select name="products" class="form-control">
                    <option value="">Select Product</option>
                            <?php foreach ($productsData as  $products) { ?>
                            <option value="<?php echo $products->product_id; ?>"><?php echo $products->part_no; ?></option>
                          <?php   } ?>
                 </select>
                 <?php }else{ ?>
                    <select name="products" class="form-control">
                    <option value="">Select Product</option>
                            <?php foreach ($productsData as  $products) { ?>
                            <option value="<?php echo $products->product_id; ?>" <?php if($products->product_id==$proData) {echo "selected";}  ?>><?php echo $products->part_no; ?></option>
                          <?php   } ?>
                 </select>
                 <?php } ?>
             </div>
             
             <div class="col-sm-2">
                 
                Assembly Product 
                <?php if($toData==''){ ?>
                <select name="assemblyprod" class="form-control" >
                <option value="">Select Assembly Product</option>
                <?php foreach ($assembleData as  $assemble) { ?>
                         <option value="<?php echo $assemble->assemble_id; ?>"><?php echo $assemble->part_name; ?></option>
                       <?php   } ?>
                 </select>
                <?php }else{ ?>
                <select name="assemblyprod" class="form-control" >
                <option value="">Select Assembly Product</option>
                <?php foreach ($assembleData as  $assemble) { ?>
                         <option value="<?php echo $assemble->assemble_id; ?>" <?php if($assemble->assemble_id==$assemblyprodData) {echo "selected";}  ?>><?php echo $assemble->part_name; ?></option>
                       <?php   } ?>
                 </select>
                <?php } ?>
             </div>
            
            <div class="col-sm-2">
                 
                Customer:
                <?php if($toData==''){ ?>
                <select name="customer" class="form-control" >
                <option value="">Select Customer</option>
                <?php foreach ($userdatas as  $usr) { ?>
                         <option value="<?php echo $usr->customer_id; ?>"><?php echo $usr->co_name; ?></option>
                       <?php   } ?>
                 </select>
                <?php }else{ ?>
                <select name="customer" class="form-control" >
                <option value="">Select Customer</option>
                <?php foreach ($userdatas as  $usr) { ?>
                         <option value="<?php echo $usr->customer_id; ?>" <?php if($usr->customer_id==$customerData) {echo "selected";}  ?>><?php echo $usr->co_name; ?></option>
                       <?php   } ?>
                 </select>
                <?php } ?>
             </div>
      
     
     
          <div class="col-sm-2" >
            Status:<select name="status" id="status" class="form-control">
            <option value="">Select</option>
            <option value="1" <?php if($status=='1'){ echo "selected";} ?>>Pending</option>
            <option value="2"  <?php if($status=='2'){ echo "selected";} ?>>Processing</option>
            <option value="3" <?php if($status=='3'){ echo "selected";} ?>>Completed</option>
            <option value="4"  <?php if($status=='4'){ echo "selected";} ?>>Delivered</option>
            </select>
            </div>
            
            
            <div class="col-xs-2">
               Make <select class="form-control select2"  id="make" name="make"> 
                        <option value="">Select Make</option>    
                        <?php foreach($makes as $m){?>
                            <option value="<?php echo $m->make_id; ?>" <?php if($make == $m->make_id){ echo "selected"; } ?>><?php echo $m->make_name; ?></option>
                                <?php } ?>
                        </select>
            </div>
            
             <div class="col-xs-2">
                Model <select class="form-control select2"  id="model" name="model"> 
                        <option value="">Select Model</option>    
                        <?php foreach($models as $city){?>
                            <option value="<?php echo $city->model_id; ?>" <?php if($model == $city->model_id){ echo "selected"; } ?>><?php echo $city->model_name; ?></option>
                                <?php } ?>
                        </select>
            </div>
            
            <div class="col-xs-2">
                Payment Status <select class="form-control select2"  id="payment" name="payment"> 
                        <option value="">Select Payment Status</option> 
                        <option value="1" <?php if($payment=='1'){ echo "selected";} ?>>Pending Payment</option> 
                        </select>
            </div>
            
      
      
      
      <div class="col-xs-2">
      Action:<br/><input type="submit" name="submit" class="btn-sm  btn btn-success " value="Show" >
      </div>
      </div>
       </form>
      </div>
     
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th><input type="checkbox" class="selAll"></th>
              <!--  -->
				        
                  <th>Marco Reference No </th> 
                  <th> Customer Name </th>
                  <th> Order Date</th>
                  <th>Order Status  </th>
                  <th>Pending Amount</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach($ordersData as $value) {
                ?>
                <tr>
                <td class="sorting_1" tabindex="0"><input type="checkbox" name="selData" value="<?php echo $value->order_id; ?>"> </td>
                <?php $details= getDataByid('inquiry',$value->inq,'inquiry_id'); ?>
                <td><?php  echo $details->marco_inqrefno; ?> </td>
                 <td><?php $co = $details->exist_cust;
                 if($co=='0'){
                  echo $details->inq_coname;
                    }else{
                 
                   $customerdata = getDataByid('customers',$co,'customer_id');
                  echo $customerdata->co_name;
                   } ?> </td>
                 
                 <td><?php $date=date_create($value->ord_date);
                   echo date_format($date,"d/m/Y");
                //  echo $value->ord_date; ?> </td>
                <td><?php  if($value->ord_status==1){
                  echo "Pending";
                }elseif($value->order_status==2){
                  echo "Completed";
                } ?> </td>
                <td><?php echo $value->pending_amount; ?></td>
                <td>
                  <a id="btnEditRow" class="orderModalButtonadd mClass"  href="javascript:;" type="button" data-src="<?php echo $value->order_id; ?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>

                  <?php if(isset($this->session->userdata('user_details')[0]->user_type) && $this->session->userdata('user_details')[0]->user_type == 'admin'){ ?>
                    <!-- <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(<?php echo $value->order_id; ?>, \'order\')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a> -->
                  <?php } ?>
                </td>
              </tr>
                <?php } ?>
              </tbody> 
            </table>
          </div>
		
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>  
<!-- Modal Crud Start-->
<div class="modal fade" id="nameModal_order" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" style="width:1000px;left:-25%">
      <div class="box-header with-border formsize">
        <h3 class="box-title"> Order Bookings </h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div>

<!--End Modal Crud --> 
<script type="text/javascript">
  $(document).ready(function() {  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();
    //var client = $('#client').val();
    var status = $('#status').val();
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          // "processing": true,
          // "serverSide": true,
           "order": [[1, "asc" ]],
          // "ajax": url+"order/dataTable/"+from_date+"/"+to_date+"/"+client+"/"+status,
          "sPaginationType": "full_numbers",
          "language": {
            "search": "_INPUT_", 
            "searchPlaceholder": "Search",
            "paginate": {
                "next": '<i class="fa fa-angle-right"></i>',
                "previous": '<i class="fa fa-angle-left"></i>',
                "first": '<i class="fa fa-angle-double-left"></i>',
                "last": '<i class="fa fa-angle-double-right"></i>'
            }
          }, 
          "iDisplayLength": 10,
          "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]]
      });
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');

        $('.dataTables_info').before('<button data-base-url="<?php echo base_url().'order/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    
    $("button.closeTest, button.close").on("click", function (){});
	  });
	 
    
    
   

</script>            