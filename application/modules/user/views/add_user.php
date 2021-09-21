<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'user/add_edit'?>" method="post">
<input type="hidden" name="users_id" value="<?php echo $userData->users_id ?>" />
  <div class="box-body">
    <div class="row print_data" id="print_data">
	<div class="box-form user_color">
	<h5>EMPLOYEE DETAILS</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-6">
	<div class="form-group">
						<label for="work_no" class="col-sm-5 control-label">First Name:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="fname" class="form-control" id="work_no" placeholder="" value="<?php echo $userData->fname ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Middle Name:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="mname" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->mname ?>">
						</div>
					</div>
					
						<div class="form-group">
						<label for="work_no" class="col-sm-5 control-label">Last Name:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="lname" class="form-control" id="work_no" placeholder="" value="<?php echo $userData->lname ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Date of Birth:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="date" name="dob" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->dob ?>">
						</div>
					</div>
					
						<div class="form-group">
						<label for="work_no" class="col-sm-5 control-label">Date of Joining:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="date" name="doj" class="form-control" id="work_no" placeholder="" value="<?php echo $userData->doj ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Date of Leaving:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="date" name="dol" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->dol ?>">
						</div>
					</div>
						
		  </div>
		  
		  <div class="col-md-6">
		  
		  	<!--<div class="col-sm-9">
				<label for="work_no" class="col-sm-4">Gender</label>
					<label class="checkbox-inline col-sm-6">
						<input type="checkbox"  name="documents[]" value="Training Evaluation">Training Evaluation
						</label>
						<label class="checkbox-inline col-sm-6">
						<input type="checkbox"  name="documents[]" value="Training Evaluation">Training Evaluation
						</label>
						</div>--->
		  
		  
		  
		  
		  	<div class="form-group">
			<?php $genderarray = explode(",",$userData->gender) ?>
						<label for="work_no" class="col-sm-4 checkbox-inline">Gender</label>
						 <input type="radio" class="checkbox-inline" name="gender" value="Female"<?php if(in_array("Female", $genderarray)) { echo "checked"; } ?>/> Female
						<div class="col-sm-4 checkbox-inline">
					  <input type="radio" name="gender" value="Male" <?php if(in_array("Male", $genderarray)) { echo "checked"; } ?>/>Male
					  
						  <!--<input type="text" name="gender" class="form-control" id="work_no" placeholder="" value="<?php// echo $userData->gender ?>">-->
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Company:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <select name="company" class="form-control">
							<option value="">Select</option>
							<option <?php if($userData->company == 'All Reg'){ echo "Selected"; } ?>>All Reg</option>
							<option <?php if($userData->company == 'All Cont'){ echo "Selected"; } ?>>All Cont</option>
							<option <?php if($userData->company == 'BCP Reg'){ echo "Selected"; } ?>>BCP Reg</option>
							<option <?php if($userData->company == 'BCP Cont'){ echo "Selected"; } ?>>BCP Cont</option>
							</select>
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_no" class="col-sm-5 control-label">Designation:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <select name="designation" class="form-control">
							<option value="">Select</option>
							<?php $query_des = $this->db->select('*')->from('user_designation')->get();
							$result_des = $query_des->result();
							foreach ($result_des as $key => $des_data) {
							?>
							<option value="<?php echo $des_data->ud_id; ?>" <?php if($userData->designation == $des_data->ud_id){ echo 'Selected'; } ?> ><?php echo $des_data->ud_name; ?></option>

							<?php
							}
							 ?>
						</select>
						  
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Personal Email ID:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="pemail" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->pemail ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="work_no" class="col-sm-5 control-label">Office Email ID:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="oemail" class="form-control" id="work_no" placeholder="" value="<?php echo $userData->oemail ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">PAN:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="pan" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->pan ?>">
						</div>
					</div>
					
					
					
		  </div>
		  </div>
		  </div>
		  
		  
		  
		  
		<!--   
		  <div class="box-form user_color">
	<h5>JOINING REQUISITE</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-6">
	<?php $jrequisitearray = explode(",",$userData->jrequisite) ?>
	
					
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Resume" <?php if(in_array("Resume", $jrequisitearray)) { echo "checked"; } ?>/> Resume
						</div>
					</div>
					
						
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Photo Identity"  <?php if(in_array("Photo Identity", $jrequisitearray)) { echo "checked"; } ?>/> Photo Identity
						</div>
					</div>
					
					
							
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Passport Photo" <?php if(in_array(" Passport Photo", $jrequisitearray)) { echo "checked"; } ?>/> Passport Photo
						</div>
					</div>
					
					
							
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Education Certificate" <?php if(in_array("Education Certificate", $jrequisitearray)) { echo "checked"; } ?>/> Education Certificate
						</div>
					</div>
					
					
							
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Experience Certificate"  <?php if(in_array("Experience Certificate", $jrequisitearray)) { echo "checked"; } ?>/> Experience Certificate
						</div>
					</div>
					
					
							
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Appointment Letter"
						<?php if(in_array("Appointment Letter", $jrequisitearray)) { echo "checked"; } ?>> Appointment Letter
						</div>
					</div>

						
		  </div>
		  
		  <div class="col-md-6">
		  
					<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Thumb Regn" <?php if(in_array("Thumb Regn", $jrequisitearray)) { echo "checked"; } ?>/> Thumb Regn 
						</div>
					</div>
					
						
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline">
					
						   <input type="checkbox" name="jrequisite[]" value="Induction Training" <?php if(in_array(" Induction Training", $jrequisitearray)) { echo "checked"; } ?>/> Induction Training
						</div>
					</div>
					
					
							
				<div class="form-group">
						<label for="work_no" class="control-label"></label>
						<div class="col-sm-9 checkbox-inline" >
					
						   <input type="checkbox" name="jrequisite[]" value="Training Evaluation" <?php if(in_array("Training Evaluation", $jrequisitearray)) { echo "checked"; } ?>> Training Evaluation
						</div>
					</div>
					
					
							
				<div class="form-group">
						<div class="col-sm-9 checkbox-inline">
					
						Remarks if any/other Docs given by alliance:<textarea name= "jremarks" rows="4" cols="30" value=""><?php echo $userData->jremarks ?>

                             </textarea>
						</div>
					</div>
						
		  </div>
		  </div>
		   </div>
		   -->
		  
		   &nbsp;
		  
		  
		 <!--  
		  <div class="box-form user_color">
	<h5>LEAVING REQUISITE</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-12">
	
						<div class="checkbox-inline">
						<?php $lrequisitearray = explode(",",$userData->lrequisite) ?>
					  <input type="checkbox" name="lrequisite[]" value="Inform Different Personnel" <?php if(in_array("Inform Different Personnel", $lrequisitearray)) { echo "checked"; } ?>/> Inform Different Personnel &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					   <input type="checkbox" name="lrequisite[]" value="Experience Certificate" <?php if(in_array("Experience", $lrequisitearray)) { echo "checked"; } ?>/>Experience Certificate &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					      <input type="checkbox" name="lrequisite[]" value="Job Profile" <?php if(in_array("Job Profile", $lrequisitearray)) { echo "checked"; } ?>/>Job Profile &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						     <input type="checkbox" name="lrequisite[]" value="Password" <?php if(in_array("Password", $lrequisitearray)) { echo "checked"; } ?> >Password &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</div>
					

						
		  </div>
		  </div>
		  </div>
		   -->
		  
		  
		    &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>ASSIGN ROLE/ONLINE ACCESS</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-6">
	
					
	<div class="form-group">
						<label for="work_no" class="col-sm-3 control-label" style="padding-left:0px;">Username:</label>
						<div class="col-sm-9" style="padding-top:2px;">
					
						  <input type="text" name="name" class="form-control" id="work_no" placeholder="" value="<?php echo $userData->name ?>">
						</div>
					</div>

						<div class="form-group">
						<label for="work_no" class="col-sm-3 control-label">User Type:</label>
						<div class="col-sm-9" style="padding-top:2px;">
					
						  <select name="user_type" class="form-control">
							<option value="">Select</option>
							<?php $query_per = $this->db->select('*')->from('permission')->get();
							$result_per = $query_per->result();
							foreach ($result_per as $key => $per_data) {
								if($per_data->user_type != 'admin')
								{
							?>
							<option value="<?php echo $per_data->user_type; ?>" <?php if($userData->user_type == $per_data->user_type){ echo 'Selected'; } ?> ><?php echo $per_data->user_type; ?></option>

							<?php
							}
						}
							 ?>
						</select>
						  
						</div>
					</div>

						
		  </div>
		  
		  <div class="col-md-6">
		  
		  				
		
					
	<div class="form-group">
						<label for="work_no" class="col-sm-3 control-label">Password:</label>
						<div class="col-sm-9" style="padding-top:2px;">
					
						  <input type="password" name="password" class="form-control" id="work_no" placeholder="" value="">
						</div>
					</div>
		  </div>
		  </div>
		   </div>
		  
		   &nbsp;
		  
		  
		<!--   
		  <div class="box-form user_color">
	<h5>PRODUCT ACCESS</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-6">
	<label for="work_no" class="control-label" >Products:</label>
						<div class="">
						
					 	
					  <textarea name="products" rows="4" cols="30">
						<?php echo $userData->products ?>
                      </textarea>
						</div>
					

						
		  </div>
		  	<div class="col-md-6">
	
						<div class="" style="padding-top:27px;">
						
					  <textarea rows="4" cols="30" name="products" value="">
                          <?php echo $userData->products ?>
                      </textarea>
						</div>
					

						
		  </div>
		  </div>
		  </div> -->
		  
		   &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>RESIDENTIAL ADDRESS</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-6">
	<label for="work_no" class="control-label" >Address:</label>
						<div class="">
						
					  <textarea name="raddress" rows="4" cols="30">
					  <?php echo $userData->raddress ?>
                      </textarea>
						</div>
					

						
		  </div>
		  
			<div class="col-md-6">		
<div class="form-group">
						<label for="work_no" class="col-sm-4 control-label">City:</label>
						<div class="col-sm-8" style="padding-top:2px;">
					
						  <input type="text" name="rcity" class="form-control" id="work_no" placeholder="" value="<?php echo $userData->rcity ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-4 control-label">State:</label>
						<div class="col-sm-8" style="padding-top:2px;">
					
						  <input type="text" name="rstate" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->rstate ?>">
						</div>
					</div>
					
					<div class="form-group">
						<label for="work_text" class="col-sm-4 control-label">Pincode:</label>
						<div class="col-sm-8" style="padding-top:2px;">
					
						  <input type="text" name="rpincode" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->rpincode ?>">
						</div>
					</div>
					
					
					<div class="form-group">
						<label for="work_text" class="col-sm-4 control-label">Country:</label>
						<div class="col-sm-8" style="padding-top:2px;">
					
						  <input type="text" name="rcountry" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->rcountry ?>">
						</div>
					</div>
					
				</div>		
		  </div>
		  </div>
		  
		  
		     &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>RESIDENTIAL PHONE NUMBER</h5>
	</div>
          <div class="box-form2">
	<div class="row">
	<div class="col-md-6">
	
					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Phone Number:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="rphone" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->rphone ?>">
						</div>
					</div>	

					
					<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label">Personal Number:</label>
						<div class="col-sm-7" style="padding-top:2px;">
					
						  <input type="text" name="mobile" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->mobile ?>">
						</div>
					</div>




					
		  </div>
		   <div class="col-md-6">
		   	<div class="form-group">
						<label for="work_text" class="col-sm-5 control-label"  style="padding-left:0px;">Alternative No in case of emergency:</label>
						<div class="col-sm-7">
					
						  <input type="text" name="rphoneemergency" class="form-control" id="work_text" placeholder="" value="<?php echo $userData->rphoneemergency ?>">
						</div>
					</div>
		   </div>
		  
		  
		  </div>
		  </div>
		  
		  
		  
		  
		  
		   &nbsp;
	
		   <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="Save" class="btn btn-success wdt-bg" style="margin-bottom: 17px;">Save</button>
          <button onclick="printDiv('print_data')" class="btn btn-success wdt-bg">Print</button>
        </div>
		
		  
		  </div>
		  
		 
       
      </form>

      <script type="text/javascript">
      	$(document).ready(function(){
      		l=1;

      	$(document).unbind().on('click','.add_new_train',function(e){
      		
      		
      		e.preventDefault();
      	//	debugger;
      		$('.add_new_data_here').append('	<div class="row"><hr class="new_hr"><button  name="closebutton" data-trid="" class="btn btn-danger wdt-bg remove_train" style="width: 5%;float: right;margin-right: 11px;margin-bottom: 1px;"><i class="fa fa-times-circle" aria-hidden="true"></i></button><div class="col-md-6" style="margin-top: 33px"><div class="form-group"><label for="work_no" class="col-sm-5 control-label">Training Topics:</label><div class="col-sm-7" style="padding-top:2px;"><input type="text" name="tr_topics[]" class="form-control" id="" placeholder="" value=""></div></div><div class="form-group"><label for="work_text" class="col-sm-5 control-label">Training Period:</label><div class="col-sm-7" style="padding-top:2px;"><input type="text" name="tr_period[]" class="form-control" id="work_text" placeholder="" value=""></div></div><div class="form-group"><label for="work_no" class="col-sm-5 control-label">Based On:</label><div class="col-sm-7" style="padding-top:2px;"><input type="text" name="tr_basedon[]" class="form-control"  placeholder="" value=""></div></div><div class="form-group"><label for="work_text" class="col-sm-5 control-label">Date:</label><div class="col-sm-7" style="padding-top:2px;"> <input type="date" name="tr_date[]" class="form-control"  placeholder="" value=""></div></div></div><div class="col-md-6"><div class="form-group"><label for="work_text" class="col-sm-5 control-label">Eval. Done By:</label><div class="col-sm-7 sel_data'+l+'" style="padding-top:2px;"></div></div><div class="form-group"><label for="work_no" class="col-sm-5 control-label">Evaluation Status:</label><div class="col-sm-7" style="padding-top:2px;"><select name="tr_Status[]" class="form-control"><option value="">Select</option><option value="Done">Done</option><option value="Pending">Pending</option></select></div></div><div class="form-group"><label for="work_text" class="col-sm-5 control-label">Comments:</label><div class="col-sm-7" style="padding-top:2px;"><input type="text" name="tr_comments[]" class="form-control" placeholder="" value=""></div></div><div class="form-group"><label for="work_no" class="col-sm-5 control-label">Other Trainings:</label><div class="col-sm-7" style="padding-top:2px;"><input type="text" name="tr_other[]" class="form-control"  placeholder="If Any" value=""></div></div></div><input type="hidden" name="tr_id[]"></div>');
      		$('#tr_doneby').clone().attr('id', '').attr('name', 'tr_doneby[]').appendTo($('.sel_data'+l+''));
      		l++;
      	});

      	$(document).on('click','.remove_train',function(e){
      		e.preventDefault();
      		var tr_id = $(this).attr('data-trid');
      		if(tr_id != '')
      		{
      			var close_row =	$(this).closest('.row');
      			var result = confirm("Want to delete?");
				if (result) {
				    //Logic to delete the item
				     $.ajax({
      url : $('body').attr('data-base-url') + 'user/del_user_training',
      method: 'post', 
      data : {id: tr_id}
    }).done(function(data) {

    //console.log(data);
    if(data == '1')
    {
    $(close_row).remove();
}
else
{
	alert('something went wrong!');
}
    });
				}
      			// alert('call ajaz');
      		}
      		else
      		{
      			// alert('remove');
      		var close_row =	$(this).closest('.row');
      		// var closet_hr = $(close_row).closest('.new_hr');
      		// $(closet_hr).remove();
      		$(close_row).remove();


      		}
      	});


      	});
      </script>


<script type="text/javascript">
      	
      	 function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     document.getElementsByTagName("body")[0].style.marginLeft = '15px';
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     location.reload();
     document.getElementsByTagName("body")[0].style.marginLeft = '0px';
 }
      </script>