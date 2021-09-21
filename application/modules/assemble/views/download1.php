<h3 class="box-title" align="center">Delivery Challan </h3>
			
			<div class="box-form2">
			<table style="width:100%" >
		<tr> 
			<td width="150">M/s. &nbsp;</td>
			<td width="160"><?php echo $this->Challan_model->get_pro11_name($challanData->coname); ?></td>
			<td width="50"></td>
			<td width="150">Date&nbsp;</td>
			<td width="160"><?php
			 //echo $inquiryData->idate ;
				if(($challanData->date)!='0000-00-00'){
				$dat= $challanData->date; 
				$date=date_create($dat);
						echo date_format($date, "d/m/Y");
				}
				?></td>	
			
		</tr>
		<tr>
			<td width="150"> &nbsp;</td>
			<td width="160"></td>
			<td width="50"></td>
			<td width="150">Challan No.</td>
			<td width="160"><?php echo $challanData->chl_id ?></td>
		</tr>
	</table><br>
		  </div>
		  <table border="1"  style="width:100%" >
			<tr>
			<td align="left" style="width:20%" >Products &nbsp; </td>
			<td align="right" style="width:10%">Quantity &nbsp;</td>
			<td align="right" style="width:10%">Price &nbsp;</td>
			<td align="right" style="width:10%">Hsn &nbsp;</td>
			<td align="right" style="width:10%">Tax &nbsp;</td>
			<td align="right" style="width:10%">Total &nbsp;</td>
			<td align="right" style="width:10%">Discount &nbsp;</td>
			<td align="right" style="width:20%"> Amount &nbsp;</td>
			</tr>
			<tr>
			
			<td style="padding-left:10px" align="left"><?php 
			
			foreach ($challan_followupData as $object) {
						echo $this->Challan_model->get_pro2_name($object->product);
						echo '<br>';
					}?>
			</td>
			
			<td style="padding-right:10px" align="right"><?php 
			foreach ($challan_followupData as $object) {
						echo $object->qty;
						echo '<br>';
					}?>
			</td>
			<td style="padding-right:10px" align="right"><?php 
		foreach	 ($challan_followupData as $object) {
						echo $object->price;
						echo '<br>';
					}?>
			</td>
			<td style="padding-right:10px" align="right"><?php 
			foreach ($challan_followupData as $object) {
						echo $object->hsn;
						echo '<br>';
					}?>
			</td>
			<td style="padding-right:10px" align="right"><?php 
			foreach ($challan_followupData as $object) {
						echo $object->tax;
						echo '<br>';
					}?>
			</td>
			<td style="padding-right:10px" align="right"><?php 
			foreach ($challan_followupData as $object) {
						echo $object->total;
						echo '<br>';

						
					}?>
			</td>
			<td style="padding-right:10px" align="right"><?php 
			foreach ($challan_followupData as $object) {
						echo $object->discount;
						echo '<br>';
					}?>

			</td>
			<td style="padding-right:10px" align="right"><?php 
			foreach ($challan_followupData as $object) {
						echo $object->totalamt;
						echo '<br>';
					}?>
			</td>
		</tr>
		
		
		
</table>
	</div>
	
		</div>
      <table border="1" style="width:100%" style="padding:10px ">
	<tr border="1">
				<td width="350" align="right"  > Select Courier &nbsp; </td>
				 <td width="100" align="right"  style="padding:5px">  <?php echo $this->Challan_model->get_pro22_name($challanData->cr_nm); ?></td>
			</tr><tr>
				<td width="150" align="right"  >Packaging/ Forwarding /Transportation </td>
				<td width="150" align="right" style="padding:5px"><?php echo $challanData->trnsptchrg ?></td>
			</tr>
				<tr>

	<td align="right"  width="150"> &nbsp; &nbsp; Grand Total </td>
	<td align="right" style="padding:5px"><?php echo $challanData->gdtot ?> </td> 
</tr>
<tr>
				<td width="150" align="right"  >Payable</td>
				<td align="right" width="160" style="padding:5px"><?php echo $challanData->payable ?></td>
			</tr></table>
   