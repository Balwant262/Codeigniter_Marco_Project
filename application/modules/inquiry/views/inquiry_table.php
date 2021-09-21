<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<style type="text/css">
  /*@media (min-width: 768px){
  .modal-dialog {
    width: 1000px;
  }
}*/
</style>


<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
  <?php if($this->session->flashdata("messagePr")) { ?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
          
		   <h3 class="box-title" id="heading">Inquiry</h3>
		 
		  
            <div class="box-tools">
              <button type="button" class="btn-sm  btn btn-success inquiryModalButton" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Inquiry</button>
             
           
            </div>
          </div>
          <!-- /.box-header -->

          <div class="box-body" name="visible" id="qwer">  
         <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'inquiry/inquiryTable' ?>" class="form-label-left">

            
            <div class="col-sm-2" >
              From:<input type="date" name="from_date" class="form-control" id="from_date" value="<?php echo $fromData;?>" >
            </div>

            
            <div class="col-sm-2" >
              To:<input type="date" name="to_date" class="form-control" id="to_date" value="<?php echo $toData;?>" >
            </div>
             
             <div class="col-sm-2">
                 
                 Product<select name="products" class="form-control">
      <option value="">Select Product</option>
              <?php foreach ($productData as  $products) { ?>
              <option value="<?php echo $products->product_id; ?>" <?php if($products->product_id==$prod) {echo "selected";}  ?>><?php echo $products->part_no; ?></option>
            <?php   } ?>
    
      </select>
             </div>
             
             <div class="col-sm-3">
                 
                Assembly Product <select name="assemblyprod" class="form-control" >
     <option value="">Select Assembly Product</option>

     <?php foreach ($assembleData as  $assemble) { ?>
              <option value="<?php echo $assemble->assemble_id; ?>" <?php if($assemble->assemble_id==$assemblyprod) {echo "selected";}  ?>><?php echo $assemble->part_name; ?></option>
            <?php   } ?>
    
      </select>
             </div>

            
            <div class="col-sm-2">
                Status Inquiry<select name="inqstatuss" id="inqstatuss" class="form-control">
                  <option value="">Select</option>
                  <option value="1" <?php if($inqstatuss==1) {echo "selected";}  ?>>Inquiry Recieved </option>
                  <option value="2" <?php if($inqstatuss==2) {echo "selected";}  ?>>Quotation Sent</option>
                  <option value="3" <?php if($inqstatuss==3) {echo "selected";}  ?>>Quotation Approved</option>
                  <option value="4" <?php if($inqstatuss==4) {echo "selected";}  ?>>Lost</option>
                </select></div>
                
             <div class="col-sm-2 showonlosta" style="display: none">
                
                	
                Reason For Lost<select name="lostreasont" id="lostreasont" class="col-sm-2  form-control" >
                  <option value="">Select</option>
                  <option value="1"<?php if($reason==1) {echo "selected";}  ?>>Product Not Available </option>
                  <option value="2"<?php if($reason==2) {echo "selected";}  ?>>Quotation Too High</option>
                  <option value="3"<?php if($reason==3) {echo "selected";}  ?>>Customer did not Respond</option>
                 
                </select>
           
            
                	 </div>
             <div class="col-sm-2">
                 User<select name="user_id" class="form-control" required>
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($user_id == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
             </div>
             
              <div class="col-sm-2" style=""> 
          Action :<br/><input type="submit" name="submit" id="" class="btn-sm  btn btn-success " value="Submit" >
          </div>
             </form>
              
              
              
              
              
              
              
        </div>
          
          <div class="box-body" name="visible" >  
          <div class="col-sm-12" >
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th>Reference No</th>
                  <th>Marco Reference No</th>
                  <th>Contact Name</th>
                  <th>Contact Email</th>
                  <th>Contact Number</th>
                  <th>Address</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>

                
              </thead>
              <tbody>
                  <?php foreach($ordersData as $value) {
                ?>
                <tr>
                    <td><?php  echo $value->inqrefno; ?></td>
                    <td><?php  echo $value->marco_inqrefno; ?></td>
                    
                    <?php $co = $value->exist_cust;
                        if($co=='0'){
                         echo '<td>'.$value->inq_coname.'</td>';
                         echo '<td>'.$value->inq_coemail.'</td>';
                         echo '<td>'.$value->inq_coperson.'</td>';
                         echo '<td>'.$value->inq_address.'</td>';
                           }else{

                          $customerdata = getDataByid('customers',$co,'customer_id');
                         echo '<td>'.$customerdata->co_name.'</td>';
                         echo '<td>'.$customerdata->email.'</td>';
                         echo '<td>'.$customerdata->cust_phone.'</td>';
                         echo '<td>'.$customerdata->location.'</td>';
                          } ?> 
                   
                    <td><?php $date=date_create($value->inq_date_created);
                   echo date_format($date,"d/m/Y");
                //  echo $value->ord_date; ?> </td>
                    
                
                <td>
                    <a id="btnEditRow" class="inquiryModalButton mClass"  href="javascript:;" type="button" data-src="<?php echo $value->inquiry_id; ?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>

                  <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(<?php echo $value->inquiry_id; ?>, '/inquiry/')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>
                </td>
              </tr>
                <?php } ?>
              </tbody> 
            </table>
          </div>
              </div>
             



         
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
<div class="modal fade" id="nameModal_inquiry" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title"> Inquiry </h3>
          <button type="button" class="close" data-dismiss="modal" onclick="removesrc()" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div>

<!--End Modal Crud --> 
<script type="text/javascript">
  $(document).ready(function() {
   $('#inqstatuss').change(function(){
  var status1=document.getElementById('inqstatuss').selectedIndex;
  if(status1==4){
       $('.showonlosta').show();
  }else{
     $('.showonlosta').hide();
  }
  });  
     var from= $("#from_date").val();
    var lost= $("#lostreasont").val();
    var to= $("#to_date").val();
      var status= $("#inqstatuss").val();
      //alert(status);
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
         // "processing": true,
         // "serverSide": true,
          //"ajax": url+"inquiry/dataTable/"+from+"/"+to+"/"+status,
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

        $('.dataTables_info').before('<button data-base-url="<?php echo base_url().'inquiry/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    
    $("button.closeTest, button.close").on("click", function (){});
  });
    
$(document).keydown(function(event) { 
  if (event.keyCode == 27) { 
    // $('#nameModal_client').hide();
          jQuery("#nameModal_inquiry").modal('hide');
           // location.reload();
  }
});

    function removesrc(){
      
      // location.reload();



    }
   
</script>            