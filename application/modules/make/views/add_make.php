<?php 
if(!empty($makeData->make_id)){?>
  <h4 class="box-title">Edit Make</h4>
<?php }else{ ?>
  <h4 class="box-title">Add Make</h4>
<?php } ?>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'make/add_edit'?>" method="post" onsubmit="return validateForm()">

  <div class="box-body">
    <div class="row">
        
						<div class="col-md-6">
						  <div class="form-group">
						    <label for="">Name</label>
						    <input type="text" name="make_name" id="make_name" value="<?php echo isset($makeData->make_name)?$makeData->make_name:'';?>" class="form-control" placeholder="Make Name" required autocomplete="off">
                <span id="checkex" style="color: red; display: none;" >Make Already Exist...</span>
						  </div>
						</div>
            <input type="hidden" id="extst" value="0">
    </div>
        <?php if(!empty($makeData->make_id)){?>
        <input type="hidden"  name="make_id" value="<?php echo isset($makeData->make_id)?$makeData->make_id:'';?>">

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

  $('#make_name').change(function () {  
    var make_name = $(this).val();
    //alert(item_name);
    $.ajax({
        url:'<?php echo base_url();?>make/checkmakename',
        method: 'post',
        data: {make_name: make_name},
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
    alert("make Already Exist..");
    return false;
  }
}
</script>