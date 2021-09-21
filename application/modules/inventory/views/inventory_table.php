<div class="content-wrapper">
<style type="text/css">
  .d-none{
    display:none;
  }
</style>
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
          
		   <h3 class="box-title" id="heading">Inventory</h3>
		 
		  
            <div class="box-tools">
              <!--  -->

               <button type="button" class="btn-sm  btn btn-success inventoryModalButtonadd" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Inventory</button> 
             
             
           
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body" name="visible" id="qwer">  
  
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <!-- <th><input type="checkbox" class="selAll"></th> -->
              <!--  -->
				          <th>Products</th> 
                  <th>Pieces</th>
                  
                </tr>
                </thead>

              <tbody>
                <?php $query=$this->db->Select('*')->from('inventory')->get();
                  $result = $query->result();
                 // print_r($result);
                ?>
               
                  <?php
                  foreach ($result as $key => $value) { ?>
                   <tr>
                     <!-- <td> <?php echo $value->invenyory_id; ?></td> -->

                    <td> <?php
                    if($value->product != 0 ){
                      echo $this->Inventory_model->getprodname($value->product);
                    }else{
                      echo $this->Inventory_model->getassemblyname($value->assembleproduct);
                    }
                      ?></td>
                      
                      <td> <?php echo $value->pieces; ?></td>
                    
                      
                      
                      
                   </tr>

                  <?php }
                   ?>
                
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
<div class="modal fade" id="nameModal_inventory" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup">
      <div class="box-header with-border formsize">
        <h3 class="box-title"> Inventory Details </h3>
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
          //  "order": [[1, "asc" ]],
         // "ajax": url+"inventory/dataTable",
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

        $('.dataTables_info').before('<button data-base-url="<?php echo base_url().'inventory/delete/'; ?>" rel="delSelTable" class="btn d-none btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    
    $("button.closeTest, button.close").on("click", function (){});
	  });
	 
    
    
   

</script>            