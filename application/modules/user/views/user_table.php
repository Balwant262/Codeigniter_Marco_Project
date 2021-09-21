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
            <h3 class="box-title">User</h3>
            <div class="box-tools">
              <?php if(CheckPermission("user", "own_create")){ ?>
                <!-- <button type="button" class="btn-sm  btn btn-success showdestable" >Show Designation Table</button> -->

                <!-- <button type="button" class="btn-sm  btn btn-success modalButtonDesignation" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Designation</button> -->

              <button type="button" class="btn-sm   btn btn-success add_btn modalButtonUser" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Add Employee</button>


              <?php }?>
            </div>
          </div>

            <!-- <div class="box-body col-xs-12">  -->
     <!--  <form method="post" enctype="multipart/form-data" action="<?php echo base_url().'user/userTable' ?>" class="form-label-left">
        <div class="row" style="margin-bottom: 12px">
      <div class="col-xs-2"><h5>User Designation:</h5></div>
      <div class="col-xs-2">
        <select name="designation" id="designation" class="form-control">
              <option value="">Select</option>
              <?php $query_des = $this->db->select('*')->from('user_designation')->get();
              $result_des = $query_des->result();
              foreach ($result_des as $key => $des_data) {
              ?>
              <option value="<?php echo $des_data->ud_id; ?>" <?php if($designation == $des_data->ud_id){ echo 'Selected'; } ?> ><?php echo $des_data->ud_name; ?></option>

              <?php
              }
               ?>
            </select>
      </div>
         <div class="col-xs-1"><h5>User Name:</h5></div>
  <div class="col-xs-2">
      <input type="text" name="user_name" id="user_name" class="form-control" value="<?php echo $user_name; ?>">
      </div>
      <div class="col-xs-1">Evaluation Status</div>
      <div class="col-xs-2">
         <select name="tr_status" id="tr_status" class="form-control">
              <option value="">Select</option>
              <option value="Done" <?php if($tr_status == 'Done'){ echo 'Selected'; } ?>>Done</option>
              <option value="Pending" <?php if($tr_status == 'Pending'){ echo 'Selected'; } ?>>Pending</option>
            </select>
              
      </div>
      <div class="col-xs-2">
      <input type="submit" name="submit" class="btn-sm  btn btn-success " value="Show" >
      </div>
       
  
      </div>

      </form> -->
      <!-- </div> -->
     
          <!-- /.box-header -->
          <div class="box-body">           
            <table id="example1" class="cell-border example1 user_table table table-striped table1 delSelTable">
              <thead>
                <tr>
                  <th><input type="checkbox" class="selAll"></th>
                  <th>First Name</th>
                   <th>Last Name</th>
                  <th>Designation</th>
                  <th>Phone Number</th>
                  <!-- <th>Evaluation Status</th> -->
                  <th>Is Active</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody> 
            </table>
          </div>


          <!-- /.box-body -->
        </div>


                <div class="box box-success des_table" style="display: none" id="des_table" tabindex="1">
          <div class="box-header with-border">
            <h3 class="box-title">Designation</h3>
            <div class="box-tools">
             
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">           
            <table id="example2" class="cell-border example1 user_table table table-striped table1 delSelTable">
              <thead>
                <tr>
              
                  <th>Title</th>
                  <th>Action</th>
                
                </tr>
              </thead>
              <tbody>
                <?php $query = $this->db->select('*')->from('user_designation')->get();
                $res = $query->result();
                foreach ($res as $key => $value) {
               
                 ?>
                 <tr>
                <td><?php echo $value->ud_name; ?></td>
                 <td>
                   <a id="btnEditRow" class="modalButtonDesignation editdes mClass"  href="javascript:;" type="button" data-src="<?php echo $value->ud_id; ?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a>

                   <a style="cursor:pointer;color: red" data-toggle="modal" class="mClass" onclick="setId2('<?php echo $value->ud_id; ?>', 'user')" data-target="#cnfrm_delete" title="delete"><i class="fa fa-trash-o" ></i></a>

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
<div class="modal fade" id="nameModal_user" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup small_width" style="width: 747px; ">
      <div class="box-header with-border formsize">
        <h3 class="box-title mod_title">Add Employee</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div><!--End Modal Crud --> 

<div class="modal fade" id="nameModal_des" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup small_width" style="width: 747px; ">
      <div class="box-header with-border formsize">
        <h3 class="box-title destit">Add Designation</h3>
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
    var designation = $('#designation').val();
    if(designation == '')
    {
      designation = 'designation';
    }
    var user_name = $('#user_name').val();
    if(user_name == '')
    {
      user_name = 'user_name';
    }

     var tr_status = $('#tr_status').val();
    if(tr_status == '')
    {
      tr_status = 'tr_status';
    }
    var table = $('#example1').DataTable({ 
      responsive: true,
          dom: 'lfBrtip',
          buttons: [
              'copy', 'excel', 'pdf', 'print'
          ],
          "processing": true,
          "bSort": false,
          "serverSide": true,
          "ajax": url+"user/dataTable/"+designation+"/"+user_name+"/"+tr_status,
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
                      "fnDrawCallback": function(){
            //EDIT OFFICE FORM
            var rowCount = $('#example1 tr').length;
            //alert(rowCount);
           var rows =document.getElementsByTagName("tbody")[0].rows;
// for(var i=0;i<rows.length;i++){


//   var t_data2 = rows[i].getElementsByTagName("td")[5];
// var td2 = rows[i].getElementsByTagName("td")[5].innerHTML;

//  //alert(td2);
//  $.ajax({
//       url : $('body').attr('data-base-url') + 'user/get_user_eval',
//       method: 'post', 
//       data : {main_data: td2,mainid:i}
//     }).done(function(data) {

//     console.log(data);
//     var newdata = JSON.parse(data);
  
//     // rows[newdata.mainid].getElementsByTagName("td")[5].innerHTML = newdata.data;

//     });

// }
        },
      });
    
    setTimeout(function() {
      var add_width = $('.dataTables_filter').width()+$('.box-body .dt-buttons').width()+10;
      $('.table-date-range').css('right',add_width+'px');

        $('.dataTables_info').before('<button data-base-url="<?php echo base_url().'user/delete/'; ?>" rel="delSelTable" class="btn btn-default btn-sm delSelected pull-left btn-blk-del"> <i class="fa fa-trash"></i> </button><br><br>');  
    }, 300);
    $("button.closeTest, button.close").on("click", function (){});


    $(document).on('click','.showdestable',function(){
var x = document.getElementById("des_table");
      if (x.style.display === "none") {
    x.style.display = "block";
    $('#des_table').focus();
    $('.showdestable').text('Hide Designation Table');
  } else {
    x.style.display = "none";
    $('.showdestable').text('Show Designation Table');
  }

    });

    $(document).on('click','.editdes',function(){
      $('.destit').text('Edit Designation');
      });

     $(document).on('click','.modalButtonDesignation',function(){
      $('.destit').text('Add Designation');
    });


     $(document).on('change','.user_act',function(){
     var user_id = this.value;
      $.ajax({
      url : $('body').attr('data-base-url') + 'user/user_act',
      method: 'post', 
      data : {id: user_id}
    }).done(function(data) {

    console.log(data);

  if(data == 'deactive')
  {
    alert('User Deactivated');
  }else
  {
    alert('User Activated');
  }


    });
     //$('#checkbox1').change(function() {

     });
  });

 $(document).on('click','.add_btn',function(){
    $('.mod_title').text('Add Users');
  });

   $(document).on('click','.edt_btn',function(){
    $('.mod_title').text('');
    $('.mod_title').text('Edit Users');
  });

    $(document).on('click','.view_btn',function(){
    $('.mod_title').text('');
    $('.mod_title').text('View Users');
  });


</script>            