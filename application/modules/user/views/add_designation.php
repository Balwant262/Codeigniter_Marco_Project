<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'user/add_edit_designation'?>" method="post">
<input type="hidden" name="ud_id" value="<?php echo $userData->ud_id ?>" />
  <div class="box-body">
    <div class="row">
	<div class="box-form user_color">
	<h5>Add Designation</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-12">
	<div class="form-group">
						<label for="work_no" class="col-sm-5 control-label">Title:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="ud_name" class="form-control" id="ud_name" placeholder="" value="<?php echo $userData->ud_name ?>">
						</div>
					</div>
					
						
		  </div>
		  
		
		  </div>
		  </div>
		  
		  &nbsp;
		  
		  
		  
		  
		    
		   <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="Save" class="btn btn-success wdt-bg">Save</button>
        </div>
		
		  
		  </div>
		  
		 
       
      </form>

 