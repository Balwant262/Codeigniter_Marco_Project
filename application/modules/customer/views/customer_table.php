<?php $usertype =$this->session->get_userdata()['user_details'][0]->user_type; ?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<!-- Main content -->
  <section class="content">
  <?php if($this->session->flashdata("messagePr")){?>
    <div class="alert alert-info">      
      <?php echo $this->session->flashdata("messagePr")?>
    </div>
  <?php } ?>
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
           <center> <h3 class="box-title">Customers</h3></center>
            <div class="box-tools">
              <?php //if(CheckPermission("offices", "own_create")){ ?>
              <button type="button" class="btn-sm  btn btn-success modalButtonCustomer btnlarge" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Customer</button>
              <?php //} ?>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">      
          <div style="padding-bottom: 45px;">
            <?php if($usertype=='Super admin'){ ?>
          <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'customer/customerTable' ?>" class="form-label-left">
             <label for="to" class="col-sm-1 control-label" >Office</label>
            <div class="col-sm-2" >
              <select class="form-control" name="office_id" id="office_id">
                <option value="">Select</option>
                <?php 
                $query2 = $this->db->select('*')->from('offices')->get();
                $result2 = $query2->result();
                foreach ($result2 as $key => $value) {
                  ?>
                  <option value="<?php echo $value->office_id ?>" <?php if($office_id == $value->office_id){ echo 'selected'; } ?>><?php echo $value->office_title; ?></option>
                  <?php
                }
                ?>
              </select>
            </div>

             <div class="col-sm-1" style=""> 
          <input type="submit" name="submit" id="" class="btn-sm  btn btn-success " value="Submit" >
          </div>

            </form> 
 <?php } ?>
 </div>     
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th><input type="checkbox" class="selAll"></th>
                  <th>Organization Name</th>
                  <th>Contact Name</th>
                  <th>Contact Email</th>
                  <th>Contact Cellphone</th>
                  <th>Location</th>
                  <th>Category Of Client</th>
                  <th>Industry Type</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $query = $this->db->select('*')->from('customers')->get(); 
            
              $result=$query->result();
              foreach ($result as $key => $value) { ?>
               <tr>
                <td><input type="checkbox" name="selData" value="<?php echo $value->customer_id ?>"></td>
                <td><?php echo $value->co_name; ?></td>
                
                <?php
                $query1 = $this->db->select('*')->from('customer_contactperson')->where('custom_id',$value->customer_id)->limit(1)->get(); 
                $result1=$query1->result();
                foreach ($result1 as $key1 => $value1) { ?>
                <td><?php echo $value1->person_name; ?></td>
                <td><?php echo $value1->person_email; ?></td>
                <td><?php echo $value1->person_phone; ?></td>
                <?php }
              ?>
                <td><?php echo $value->location; ?></td>
                <td><?php echo $value->category_of_client; ?></td>
                <td><?php echo $value->industry_type; ?></td>
            
                  <td><a id="btnEditRow" class="modalButtonCustomer mClass"  type="button" data-src="<?php echo $value->customer_id ?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>
<!--                  <a id="btnViewRow" class="modalButtonCustomerView mClass view_btn"  href="javascript:;" type="button" data-src="<?php echo $value->customer_id ?>" title="View"><i class="fa fa-eye" data-id=""></i></a>-->
                  <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(<?php echo $value->customer_id ?>, 'customer')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>
                </td>
             </tr>
              <?php }
              ?>
              </tbody> 
            </table>
             <button data-base-url="customer/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button>
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
<div class="modal fade" id="nameModal_customer" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud --> 
<script type="text/javascript">
  $(document).ready(function() {  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    var table = $('#example1').DataTable({ 
      responsive: true,
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          // "processing": true,
          // "serverSide": true,
         // "ajax": url+"customer/dataTable",
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
          "iDisplayLength": 25,
          "aLengthMenu": [[10, 25, 50, 100,500,-1], [10, 25, 50,100,500,"All"]],
          // "paging":false,
          "bInfo" : false
          // "scrollX": true
      });
    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');

      //  $('.dataTables_info').before('');  
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});



  });
</script>            