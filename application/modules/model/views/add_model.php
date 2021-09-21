<?php 
if(!empty($modelData->model_id)){?>
  <h4 class="box-title">Edit Model</h4>
<?php }else{ ?>
  <h4 class="box-title">Add Model</h4>
<?php } ?>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'model/add_edit'?>" method="post" onsubmit="return validateForm()">

  <div class="box-body">
    <div class="row">
          
       <div class=" col-md-6" >
              <div class="form-group" >
          <label>Make</label>
              <select name="make_id" id="make_id" class="form-control" required="">
              <option value="">Select</option>
              <?php foreach ($makeData as  $make) { ?>
              <option value="<?php echo $make->make_id; ?>" <?php if($modelData->make_id == $make->make_id){ echo "selected";} ?>><?php echo $make->make_name; ?></option>
            <?php   } ?>
            </select>
       </div>
      </div>



						<div class="col-md-6">
						  <div class="form-group">
						    <label for="">Name</label>
						    <input type="text" name="model_name" id="model_name" value="<?php echo isset($modelData->model_name)?$modelData->model_name:'';?>" class="form-control" placeholder="model Name" required autocomplete="off">
                <span id="checkex" style="color: red; display: none;" >Model Already Exist...</span>
						  </div>
						</div>
            <input type="hidden" id="extst" value="0">
    </div>
        <?php if(!empty($modelData->model_id)){?>
        <input type="hidden"  name="model_id" value="<?php echo isset($modelData->model_id)?$modelData->model_id:'';?>">

        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
        </div>
              <!-- /.box-body -->
        <?php }else{?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="add" class="btn btn-success wdt-bg">Add</button>
        </div>
        <?php } ?>
      </form>

<script type="text/javascript">
  $(document).ready(function() {  

  $('#model_name').change(function () {  
    var model_name = $(this).val();
    //alert(item_name);
    $.ajax({
        url:'<?php echo base_url();?>model/checkmodelname',
        method: 'post',
        data: {model_name: model_name},
        dataType: 'text',
        success: function(data){
           // console.log(data);
            document.getElementById("checkex").style.display = data;
            if(data=='block'){
              $('#extst').val(1);
            }else{
              $('#extst').val(0);
            }
        }
     });

  });
});

function validateForm() {
  if ($('#extst').val() == 1) {
    alert("model Already Exist..");
    return false;
  }
}
</script>