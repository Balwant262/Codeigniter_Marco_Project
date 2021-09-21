<style> 
td{ 
	padding-top:5Px; 
	padding-bottom:5px;
}
.popup{
	width: 800px;
}
 </style>


			<div class="box-form2">
			<table id="vtable" class="tpad cell-border example1 table 
			table-striped table1 delSelTable">

		<tr>
			<td width="150">Inquiry Reference No</td>
			<td width="150"><?php echo $inquiryData->inqrefno; ?></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

			<?php if($inquiryData->exist_cust!=0) { ?>
			
				<tr>
			<td width="150"> Customer :  &nbsp;</td>
			<td width="160"><?php 
			$cust=  $this->Inquiry_model->get_client_name($inquiryData->exist_cust); 
			echo $cust->co_name; ?></td>
			<td> </td>
			<td> Company Email</td>
			<td> <?php echo $cust->email; ?>	
			</tr>
				<tr> 
				<td> Company Phone </td>
				<td><?php echo $cust->phone;?> </td>
				<td> </td>
			<td> ALternate Phone</td>
			<td> <?php echo $cust->alternate_phone; ?></td>
			</tr>

			<tr> 
				<td> PAN </td>
				<td><?php echo $cust->pan; ?> </td>		
				<tD></tD>
				<td> </td>
				<Td></Td>	
			</tr>
		<?php } else {?>
			<tr> 
				<td> Company Name </td>
				<td><?php echo $inquiryData->inq_coname;?> </td>
				<td> </td>
			<td> Company Email</td>
			<td> <?php echo $inquiryData->inq_coemail; ?></td>
			</tr>
			<tr> 
				<td> Contact Person </td>
				<td><?php echo $inquiryData->inq_coperson;?> </td>
				<td> </td>
			<td> Company Person Email</td>
			<td> <?php echo $inquiryData->inq_copersemail; ?></td>
			</tr>
			<tr> 
				<td> Company Phone </td>
				<td><?php echo $inquiryData->inq_phone;?> </td>
				<td> </td>
			<td> Company Address</td>
			<td> <?php echo $inquiryData->inq_address; ?></td>
			</tr>
			<?php } ?>
			<tr> 
				<td> Status </td>
				<td><?php echo $inquiryData->inqstatus;?> </td>
				<td> </td>
				<?php if($inquiryData->inqstatus=='4'){ ?>
			<td> Lost Reason </td>
			<td> <?php echo $inquiryData->lostreason; ?></td>
			<?php }else{
				echo "<td></td><Td></td>";
			} ?>
			</tr>
		</table>	
		<table id="vtable" class="tpad cell-border example1 table 
			table-striped table1 delSelTable">
			<tr> 
				<th>Products</th>
				<th>Assembly</th>
				<th>Quantity</th>
				<th>Price</th>
			</tr>
			<?php foreach ($inquiry_follow_up as $key => $value) { ?>
				<tr>
					<td><?php echo $this->Inquiry_model->get_product_name($value->products); ?></td>
					<td><?php echo $this->Inquiry_model->get_assproduct_name($value->assemblyprod); ?></td>
					<td><?php echo $value->qty; ?></td>
					<td><?php echo $value->price; ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>