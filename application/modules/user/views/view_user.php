<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'user/add_edit'?>" method="post">
<input type="hidden" name="users_id" value="<?php echo $userData->users_id ?>" />
  <div class="box-body">
    <div class="row">
	<div class="box-form user_color">
	<h5>EMPLOYEE DETAILS</h5>
	</div>
           <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="150">First Name:&nbsp;</td>
			<td width="160"><?php echo $userData->fname ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Gender:&nbsp;</td>
			<td width="150"><?php echo $userData->gender; ?></td>
		</tr>
		<tr>
			<td width="150">Middle Name:&nbsp;</td>
			<td width="160"><?php echo $userData->mname; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Company:&nbsp;</td>
			<td width="150"><?php echo $userData->company ; ?></td>
		</tr>
		<tr>
			<td width="150">Last Name:&nbsp;</td>
			<td width="160"><?php echo $userData->lname; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Designation:&nbsp;</td>
			<td width="150"><?php 
			$query3 = $this->db->query('SELECT ud_name from user_designation where ud_id = '.$userData->designation.'');
		$result3 = $query3->row();
			echo $result3->ud_name ; ?></td>
		</tr>
		
		<tr>
			<td width="150">Date of Birth:&nbsp;</td>
			<td width="160"><?php echo $userData->dob; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Personal Email ID:&nbsp;</td>
			<td width="150"><?php echo $userData->pemail  ; ?></td>
		</tr>
			<tr>
			<td width="150">Date of Joining:&nbsp;</td>
			<td width="160"><?php echo $userData->doj  ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Office Email ID:&nbsp;</td>
			<td width="150"><?php echo  $userData->oemail ; ?></td>
		</tr>
		
	
			<tr>
			<td width="150">Date of Leaving:&nbsp;</td>
			<td width="160"><?php echo $userData->dol ; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">PAN:&nbsp;</td>
			<td width="150"><?php echo $userData->pan ; ?></td>
		</tr>
		
		</table>
		  </div>
		  
		  &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>JOINING REQUISITE</h5>
	</div>
          <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="250"><?php echo $userData->jrequisite ;?></td>
			<td width="60"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Remarks if any/other Docs given by alliance:&nbsp;</td>
			<td width="150"><?php echo $userData->jremarks; ?></td>
		</tr>
		</table>

		  </div>
		  
		   &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>LEAVING REQUISITE</h5>
	</div>
          <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width=""><?php echo $userData->lrequisite ;?></td>
		</tr>
		</table>
		  </div>
		    &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>ASSIGN ROLE/ONLINE ACCESS</h5>
	</div>
           <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="250"><?php echo $userData->roles ;?></td>
			<td width="60"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Username:</td>
			<td width="150"><?php echo $userData->name ?></td>
		</tr>
	
		</table>
		 	    

		  </div>
		  
		   &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>PRODUCT ACCESS</h5>
	</div>
            <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="150">Products:</td>
			<td width="260"><?php echo $userData->products ?></td>
			
		</tr>
		
		</table>
		  </div>
		  
		   &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>RESIDENTIAL ADDRESS</h5>
	</div>
           <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="150">Address:&nbsp;</td>
			<td width="160"><?php echo $userData->raddress ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">City:&nbsp;</td>
			<td width="150"><?php echo $userData->rcity; ?></td>
		</tr>
		
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">State:&nbsp;</td>
			<td width="150"><?php echo $userData->rstate ; ?></td>
		</tr>
		
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Pincode:&nbsp;</td>
			<td width="150"><?php echo $userData->rpincode ; ?></td>
		</tr>
		
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Country:&nbsp;</td>
			<td width="150"><?php echo $userData->rcountry ; ?></td>
		</tr>
		</table>
		  </div>
	     &nbsp;
		  
		  
		  
		  <div class="box-form user_color">
	<h5>RESIDENTIAL PHONE NUMBER</h5>
	</div>
         <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="150">Phone Number:&nbsp;</td>
			<td width="160"><?php echo $userData->rphone ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Alternative No in case of emergency:&nbsp;</td>
			<td width="150"><?php echo $userData->rphoneemergency; ?></td>
		</tr>
		
		<tr>
			<td width="150">Personal Number:</td>
			<td width="160"><?php echo $userData->mobile ?></td>
			<td width="50">&nbsp;</td>
			
		</tr>
		
		
		</table>
		 	    

		  </div>
	  
		   &nbsp;
		  
		  <div class="box-form user_color">
	<h5>Training Evaluation</h5>
	</div>
	 <div class="box-form2">
		<?php $query = $this->db->select('*')->from('users_training')->where('user_id',$userData->users_id)->get();
		if($query->num_rows()>0)
		{
		$result = $query->result();
		$idata = 0;
		foreach ($result as $key => $tr_data) {

		$add_by = $tr_data->tr_doneby;
		//echo $add_by;

		$query2 = $this->db->query('SELECT name from users where users_id = '.$add_by.'');
		$result2 = $query2->row();
		//print_r($result2);
		
		if($idata != 0)
		{
			echo '<hr>';
		}
		$idata++;
		 ?>
		    <table>
			
		<tr>
			<td width="150">Training Topics:&nbsp;</td>
			<td width="160"><?php echo $tr_data->tr_topic ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Training Peroid:&nbsp;</td>
			<td width="150"><?php echo $tr_data->tr_period; ?></td>
		</tr>

		<tr>
			<td width="150">Based On:&nbsp;</td>
			<td width="160"><?php echo $tr_data->tr_basedon ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Date:&nbsp;</td>
			<td width="150"><?php echo date('d/m/Y',strtotime($tr_data->tr_date)); ?></td>
		</tr>
		
		<tr>
			<td width="150">Evl. Done By:&nbsp;</td>
			<td width="160"><?php  echo $result2->name;
			// print_r($this->db->last_query());
			 ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Status:&nbsp;</td>
			<td width="150"><?php echo $tr_data->tr_status; ?></td>
		</tr>

		<tr>
			<td width="150">Comments:&nbsp;</td>
			<td width="160"><?php echo $tr_data->tr_comments ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Other Trainings:&nbsp;</td>
			<td width="150"><?php echo $tr_data->tr_other; ?></td>
		</tr>
		
		
		
		</table>
		 <?php } }  ?>	    

		  </div>
		  
		  
		 <!--  <div class="box-form">
	<h5>OFFICE ADDRESS</h5>
	</div>
          <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="150">Address:&nbsp;</td>
			<td width="160"><?php echo $userData->oaddress ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">City:&nbsp;</td>
			<td width="150"><?php echo $userData->ocity; ?></td>
		</tr>
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">State:&nbsp;</td>
			<td width="150"><?php echo $userData->ostate ; ?></td>
		</tr>
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Pincode:&nbsp;</td>
			<td width="150"><?php echo $userData->opincode ; ?></td>
		</tr>
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Country:&nbsp;</td>
			<td width="150"><?php echo $userData->ocountry ; ?></td>
		</tr>
		
		
		</table>
		 	    

		  </div>
		   -->
		  
		  
		  
	<!-- 	   &nbsp;
		  
		  
		  
		  <div class="box-form">
	<h5>OFFICE PHONE NUMBERS </h5>
	</div>
         <div class="box-form2">
	
		    <table>
			
		<tr>
			<td width="150">ISD No 1:&nbsp;</td>
			<td width="160"><?php echo $userData->ophoneisd1 ;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Mobile No:&nbsp;</td>
			<td width="150"><?php echo $userData->omobile; ?></td>
		</tr>
		<tr>
			<td width="150">STD No 1:</td>
			<td width="160"><?php echo $userData->ophonestd1?></td>
			<td width="50">&nbsp;</td>
			<td width="150">ISD No 2:&nbsp;</td>
			<td width="150"><?php echo $userData->ophoneisd2 ; ?></td>
		</tr>
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">STD No 2:&nbsp;</td>
			<td width="150"><?php echo $userData->ophonestd2 ; ?></td>
		</tr>
		
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Fax No:&nbsp;</td>
			<td width="150"><?php echo $userData->fax ; ?></td>
		</tr>
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Fax STD No:&nbsp;</td>
			<td width="150"><?php echo $userData->faxstd ; ?></td>
		</tr>	
		<tr>
			<td width="150"></td>
			<td width="160"></td>
			<td width="50">&nbsp;</td>
			<td width="150">Fax ISD No:&nbsp;</td>
			<td width="150"><?php echo $userData->faxisd ; ?></td>
		</tr>
		
		
		</table>
		 	    

		  </div> -->
		  
		
		  
		  </div>
		  
		 
       
      </form>