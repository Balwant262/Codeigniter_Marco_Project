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
          
		   <h3 class="box-title" id="heading">Products</h3>
		 
		    <h3 class="box-title" id="heading1" style="display:none">Category</h3>
		
            <div class="box-tools">
          
<button type="button" class="btn-sm  btn btn-success categoryModalButton" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Products Category</button>
               <!-- <button type="button" class="btn-sm  btn btn-success"  onclick="location.href='<?php echo base_url(); ?>assets/document/Book1.xlsx'" target="_blank" download data-toggle="modal"> Download Sample Format</button> -->
			<!-- <button type="button" class="btn-sm  btn btn-success importModalButton" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Import Excel File</button> -->
              <?php if(CheckPermission("users", "own_create")){ ?>
                <button type="button" id="incoming" class="btn-sm  btn btn-success " onclick="showCategory()"style="display:block;float:left;margin-right:10px">Categories</button>
                 <button type="button" id="outgoing" class="btn-sm  btn btn-success " onclick="showService()"style="display:none;float:left;margin-right:10px">Products
                 </button>
				 
              

              <button type="button" class="btn-sm  btn btn-success productsModalButton" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Products</button>
             
             
              <?php } ?>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body" name="visible" id="qwer">  
              
      <div class="row">      
        <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'products/productsTable' ?>" class="form-label-left">
                      
             <div class="col-sm-3">
                Vendor <select name="vendor" class="form-control" >
                    <option value="">Select Vendor</option>
                    <?php foreach ($vendorData as  $assemble) { ?>
                     <option value="<?php echo $assemble->supplier_id; ?>" <?php if($assemble->supplier_id==$vendor) {echo "selected";}  ?>><?php echo $assemble->supplier_name; ?></option>
                   <?php   } ?>    
             </select>
             </div>
                           
              <div class="col-sm-3" style=""> 
          Action :<br/><input type="submit" name="submit" id="" class="btn-sm  btn btn-success " value="Submit" >
          </div>
             </form>
                  </div>
              <br/>
  
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th><input type="checkbox" class="selAll"></th>
                  <th>Equipment Type</th>
                  <th>Marco Code</th>
                  <th>Part No</th>
                  <th>Description</th>
          
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  <?php foreach($ordersData as $value) {
                ?>
                <tr>
                    <td><?php  echo $value->equipment_type; ?></td>
                    <td><?php  echo $value->marco_code; ?></td>
                    <td><?php  echo $value->part_no; ?></td>
                    <td><?php  echo $value->oem_drawing_no; ?></td>
                    <td><?php  echo $value->item_description; ?></td>
                    
                   
                
                <td>
                    <a id="btnEditRow" class="productsModalButton mClass"  href="javascript:;" type="button" data-src="<?php echo $value->product_id?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>

                  <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId('<?php echo $value->product_id?>', 'products')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>
                </td>
              </tr>
                <?php } ?>
              </tbody> 
            </table>
          </div>
		  <div class="box-body" name="visi" style="display:none" id="category">
		  
			 <table id="example2"  class="cell-border example2 table table-striped table2 delSelTable">
              <thead>
                <tr>
                  <th><input type="checkbox" class="selAll"></th>
                  <th>Products Categories</th>
				  <th>Action</th>
                </tr>
              </thead>
              <tbody>
			
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
<div class="modal fade" id="nameModal_products" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <!-- <h3 class="box-title"> Product </h3> -->
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="nameModal_category" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <h3 class="box-title"> Category </h3>
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
    var table = $('#example1').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          // "processing": true,
          // "serverSide": true,
          //"ajax": url+"products/dataTable",
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
          "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]],
        //   "fnDrawCallback": function(){
        //    var rows =document.getElementsByTagName("tbody")[0].rows;
        //    // alert(rows);
        //   for(var i=0;i<rows.length;i++){
        //   var td = rows[i].getElementsByTagName("td")[4].innerHTML;
        //   // alert(td);
        //    $.ajax({
        //       url : $('body').attr('data-base-url') + 'products/get_parent_cats',
        //       method: 'post', 
        //       data : {mainid: i,iddata:td}
        //     }).done(function(data) {

        //     //console.log(data);
        //     var newdata = JSON.parse(data);
        //     rows[newdata.mainid].getElementsByTagName("td")[4].innerHTML = newdata.data;
            
        //     })

        //   }
        // }
      });
	  
	  var table = $('#example2').DataTable({ 
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "processing": true,
          "serverSide": true,
          "ajax": url+"products/dataTable2",
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

        $('.dataTables_info').before('<button data-base-url="<?php echo base_url().'products/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});
  });
    function showCategory(){

    document.getElementById("category").style.display="block";
     document.getElementById("qwer").style.display="none";
     document.getElementById("outgoing").style.display="block";
     document.getElementById("incoming").style.display="none";
	 document.getElementById("heading").innerHTML="Categories";
	 document.getElementById("heading1").style.display="none"
  }
  function showService(){

    document.getElementById("category").style.display="none";
       document.getElementById("qwer").style.display="block";
     document.getElementById("outgoing").style.display="none";
     document.getElementById("incoming").style.display="block";
   document.getElementById("heading").innerHTML="Products";
    document.getElementById("heading1").style.display="none";
  }

</script>            