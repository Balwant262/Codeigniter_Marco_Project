<style>
td{
	padding-top:10px;
}
.popup{
	width:870px;
}
</style>

<h4 class="box-title">View Customer</h4>
			<input type="hidden" name="customer_id" value="<?php echo $customerData->customer_id ?>" />
			<div class="box-form2" style="overflow-x:auto;">
			<table id="example" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer">
		<tr>
			<td width="150">Company Name:&nbsp;</td>
			<td width="160"><?php echo $customerData->co_name;?></td>
			<td width="50">&nbsp;</td>
			<td width="150">PAN:&nbsp;</td>
			<td width="150"><?php echo $customerData->pan; ?></td>
		</tr>
	</table>
		<table id="example" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer">
			<tr> 
				<th width="220"> Contact Person Name </th>
				<th width="220"> Contact Person Email </th>
				<th width="220"> Contact Person Phone </th>
			</tr>
			<?php 
			foreach ($customer_follow_up as $key => $value) { ?>
				<tr>
					<td><?php echo $value->person_name; ?></td>
					<td><?php echo $value->person_email; ?></td>
					<td><?php echo $value->person_phone; ?></td>
				</tr>
			<?php } ?>
		</table>
			<table id="example" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer">
		<tr>
			<td width="150">Phone:&nbsp;</td>
			<td width="160"><?php echo $customerData->cust_phone; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Alternate Phone:&nbsp;</td>
			<td width="150"><?php echo $customerData->alternate_phone; ?></td>
		</tr>
		<tr>
			<td width="150">Email:&nbsp;</td>
			<td width="160"><?php echo $customerData->email; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Address:&nbsp;</td>
			<td width="150"><?php echo $customerData->cust_address1.'<br>'.$customerData->address2; ?></td>
		</tr>
		<tr>
			<td width="150">Landmark:&nbsp;</td>
			<td width="160"><?php echo $customerData->landmark; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Country:&nbsp;</td>
			<td width="150"><?php echo $customerData->cust_country; ?></td>
		</tr>
		<tr>
			<td width="150">State:&nbsp;</td>
			<td width="160"><?php echo $customerData->cust_state; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">City:&nbsp;</td>
			<td width="150"><?php echo $customerData->cust_city; ?></td>
		</tr>

		<tr>
			<td width="150">Status:&nbsp;</td>
			<td width="160"><?php if($customerData->status=='1'){echo "Active";}else{echo "Inactive";} ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Notes:&nbsp;</td>
			<td width="160"><?php echo $customerData->notes; ?></td>
		</tr>

		<tr>
			<td width="150">Current File :&nbsp;</td>
			<td width="160">
		<?php if(isset($customerData->file_data) && $customerData->file_data != ''){
              ?>
             
              <a href="<?=base_url()?>/assets/images/cust_images/<?php echo $customerData->file_data; ?>" target="_blank"><img src="<?=base_url()?>/assets/images/cust_images/<?php echo $customerData->file_data; ?>" style="width:100px"></a>
           <?php } ?>
           </td>
			<td width="50">&nbsp;</td>
			<td width="150">Shipping Details :&nbsp;</td>
			<td width="160"> <?php echo $customerData->cust_address1_ship.$customerData->address2_ship.$customerData->landmark_ship.$customerData->cust_city_ship.$customerData->cust_state_ship.$customerData->cust_country_ship.$customerData->cust_pin_ship; ?> </td>
		</tr>

		
		
		</table>	
			</div>
			<script type="text/javascript">
  $(document).ready(function() {  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    var table = $('#example').DataTable({ 
          responsive: true
          
      });
    
  });
</script>            