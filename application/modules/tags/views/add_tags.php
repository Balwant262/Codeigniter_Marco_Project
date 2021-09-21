<?php 
if(!empty($tagsData->tag_id)){?>
  <h4 class="box-title">Edit Tag</h4>
<?php }else{ ?>
  <h4 class="box-title">Add Tag</h4>
<?php } ?>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'tags/add_edit'?>" method="post" onsubmit="return validateForm()">

  <div class="box-body">
    <div class="row">
        
						<div class="col-md-4">
						  <div class="form-group">
						    <label for="">First Name</label>
						    <input type="text" name="tag_name" id="tag_name" value="<?php echo isset($tagsData->tag_name)?$tagsData->tag_name:'';?>" class="form-control" placeholder="Tag Name" required autocomplete="off">
                <span id="checkex" style="color: red; display: none;" >Tag Already Exist...</span>
						  </div>
						</div>
            <input type="hidden" id="extst" value="0">
    </div>
        <?php if(!empty($tagsData->tag_id)){?>
        <input type="hidden"  name="tag_id" value="<?php echo isset($tagsData->tag_id)?$tagsData->tag_id:'';?>">

        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
        </div>
              <!-- /.box-body -->
        <?php }else{?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit"  value="add" class="btn btn-success wdt-bg">Add</button>
        </div>
        <?php } ?>
      </form>

<script type="text/javascript">
  $(document).ready(function() {  

  $('#tag_name').change(function () {  
    var tag_name = $(this).val();
    //alert(item_name);
    $.ajax({
        url:'<?php echo base_url();?>tags/checktagname',
        method: 'post',
        data: {tag_name: tag_name},
        dataType: 'text',
        success: function(data){
           // console.log(data);
            document.getElementById("checkex").style.display = data;
            if(data=='block'){
              $('#extst').val(1);
              $('#submit').hide();
            }else{
              $('#extst').val(0);
               $('#submit').show();
            }
        }
     });

  });
});

function validateForm() {
  if ($('#extst').val() == 1) {
    alert("Tag Already Exist..");
    return false;
  }
}
</script>