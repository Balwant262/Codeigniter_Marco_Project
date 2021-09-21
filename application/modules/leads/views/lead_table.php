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
            <center><h3 class="box-title">Leads</h3></center>
            <div class="box-tools">
              <?php if(CheckPermission("leads", "own_create")){ ?>
              <button type="button" class="btn-sm  btn btn-success modalButtonLead btnlarge" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Lead</button>
              <?php } ?>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
              <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'leads/leadsTable' ?>" class="form-label-left">
             <div class="row">
                  <div class="col-sm-2" >
              From:<input type="date" name="from_date" class="form-control" id="from_date" value="<?php echo $fromData;?>" >
            </div>

            
            <div class="col-sm-2" >
              To:<input type="date" name="to_date" class="form-control" id="to_date" value="<?php echo $toData;?>" >
            </div>
             
             <div class="col-sm-2">
                 
                 User<select name="user_id" class="form-control">
      <option value="">Select User</option>
              <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($user_id == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
    
      </select>
             </div>
        <div class="col-sm-1" style=""> 
          Action :<input type="submit" name="submit" id="" class="btn-sm  btn btn-success " value="Submit" >
          </div>
                  </div>
               </form>
            <br/>
            <table id="example1" class="cell-border example1 table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th><input type="checkbox" class="selAll"></th>
                  <th>Date</th>
                  <th>Reference / Lead Source</th>
                  <th>Prospect Name</th>
                  <th>Organization Name</th>
                  <th>Location</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
             <?php
              
              foreach ($leadData as $key => $value) { ?>
                 <tr>
                <td><input type="checkbox" name="selData" value="<?php echo $value->lead_id ?>"></td>
               <td><?php 
                $date=date_create($value->date_created);
            echo date_format($date,"d/m/Y");
          //     echo $value->date_created; ?></td>
               <td><?php echo $value->lead_source; ?></td> 
               <td><?php echo $value->lead_coperson; ?></td>
                 <td><?php echo $value->organization_name; ?></td>
                <td><?php echo $value->location; ?></td>
                
                <td><a id="btnEditRow" class="modalButtonLead mClass"  href="javascript:;" type="button" data-src="<?php echo $value->lead_id ?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>
<!--                  <a id="btnViewRow" class="modalButtonLeadView mClass view_btn"  href="javascript:;" type="button" data-src="<?php echo $value->lead_id ?>" title="View"><i class="fa fa-eye" data-id=""></i></a>-->
                  <a style="cursor:pointer;" data-toggle="modal" class="mClass" onclick="setId(<?php echo $value->lead_id ?>, 'leads')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>
                </td>
              </tr>
              <?php } ?>
              </tbody> 
            </table>
            <button data-base-url="leads/delete/" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button>
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
<div class="modal fade" id="nameModal_lead" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <!-- <h3 class="box-title">Office Form</h3> -->
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
          // "ajax": url+"leads/dataTable",
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
          
      });

    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');

       // $('.dataTables_info').before('<button data-base-url="<?php echo base_url().'leads/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});


  
  });
</script>            