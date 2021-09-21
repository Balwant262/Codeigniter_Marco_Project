<style>
td{
	padding-top:10px;
}
.popup{
	width:800px;
}
</style>
<div class="box-tools">
            </div>
<h4 class="box-title">View Leads</h4>
			<input type="hidden" name="lead_id" value="<?php echo $leadData->lead_id ?>" />
			<div class="box-form2" style="overflow-x:auto;">
			<table class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer">
		<tr>
			<td width="150">Company Name :&nbsp;</td>
			<td width="160"><?php echo $leadData->lead_coname; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Contact Person:&nbsp;</td>
			<td width="150"><?php echo $leadData->lead_coperson; ?></td> 
		</tr>
		<tr>
			<td width="150">Contact Person Email :&nbsp;</td>
			<td width="160"><?php echo $leadData->lead_copersemail; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">ALternate Phone:&nbsp;</td>
			<td width="150"><?php echo $leadData->alternate_phone; ?></td> 
		</tr>
		<tr>
			<td width="150">Phone :&nbsp;</td>
			<td width="160"><?php echo $leadData->lead_phone; ?></td>
			<td></td>
			<Td></Td>
			<td></td>
		</tr>
		<tr>
			<td width="150">Email :&nbsp;</td>
			<td width="160"><?php echo $leadData->email; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Address :&nbsp;</td>
			<td width="150"><?php echo $leadData->address1.'<br>'.$leadData->address2; ?></td>
		</tr>
		<tr>
			<td width="150">Landmark :&nbsp;</td>
			<td width="160"><?php echo $leadData->landmark; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Country :&nbsp;</td>
			<td width="150"><?php echo $leadData->lead_country; ?></td>
		</tr>
		<tr>
			<td width="150">State :&nbsp;</td>
			<td width="160"><?php echo $leadData->lead_state; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">City :&nbsp;</td>
			<td width="150"><?php echo $leadData->lead_city; ?></td>
		</tr>

		
		<tr>
			<td width="150">Status :&nbsp;</td>
			<td width="160"><?php if($leadData->status=='1'){echo "Active";}else{echo "Inactive";} ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Notes:&nbsp;</td>
			<td width="150"><?php echo $leadData->notes; ?></td>
		</tr>
		
		
		</table>	
			</div>
			