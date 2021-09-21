 <style>
	td, th {
    padding: 5px;
}
.pop{
	width:800px;
}
</style>
<h3 class="box-title">View assemble Details</h3>
			
			<div class="box-form2"> 
			<table class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer"	>
		<tr>
			<td  width="150">Part No</td>
			<td width="160"><?php

			 echo $assembleData->part_name; ?></td>
			<td width="50"></td>
			<td width="150">Price:&nbsp;</td>
			<td width="160"><?php echo $assembleData->price; ?></td>
			
			
		</tr>

		<br>
		<tr>
			<td width="150">Manufacturer code: &nbsp;</td>
			<td width="160"><?php echo $assembleData->m_code; ?></td>
			<td width="50"></td>
			<td  width="150">Tags: </td>
			<td  width="160"><?php $product_tagsData = $this->Assemble_model->get_data_by('asseble_product_tags',$assembleData->assemble_id ,'assemble_id');
					$tags='';
					foreach ($product_tagsData as $object) { 
						$tags .= $this->Assemble_model->get_tag_name($object->tag_id).", "; 
						} echo rtrim($tags,', ') ?></td>
		</tr>

		<tr>
			<td width="150">Supplier: &nbsp;</td>
			<td width="160"><?php foreach($supplierData as $supplier){ 
			 if(($assembleData->supplier_id) == ($supplier->supplier_id)){  echo $supplier->supplier_name; } 
			 } ?></td>
			 <td></td>
			 <td width="150">VIdeo </td>
				<td> <a href="<?=base_url()?>assets/images/<?php echo $assembleData->video; ?>" target="_blank">Watch Video</a></td>
		</tr>
	<tr>
			<td width="150"> Profile Pic&nbsp;</td>
	<td> <a href="<?=base_url()?>assets/images/<?php echo $assembleData->profile_pic; ?>" target="_blank">See Profile Pic</a></td>
	<td></td>
	<td></td>
	<td></td>
</tr>
	</table><br>
		  </div>
		  
		    <div class="box-form2">
	
		   <table  class="table table-bordered" style="width:50%" >
			<tr>
			<td align="left" style="width:24%" >Products </td>
			<td align="right" style="width:13%">Weight </td>
			
			</tr>
			<tr>
			
			<td style="padding-left:10px" align="left"><?php 
			
			foreach ($assemble_followupData as $object) {
						echo $this->Assemble_model->get_pro2_name($object->product_name);
						echo '<br>';
					}?>
			</td>
			
			<td style="padding-right:10px" align="right"><?php 
			foreach ($assemble_followupData as $object) {
						echo $object->product_wght;
						echo '<br>';
					}?>
			</td>
		</tr>
		
		</table>
		<table class="table table-bordered">
		<tr>
			<td width="150">Pictures: &nbsp;</td>
		
			<td>
				<?php $product_picData = $this->Assemble_model->get_data_by('assemble_media',$assembleData->assemble_id ,'assemble_id');
					foreach ($product_picData as $object) {  ?>
						<img src="<?=base_url()?>/assets/images/<?php echo $object->media; ?>" style="width:200px">
				<?php } ?>
			</td>
		</tr>
		
		
</table>
	</div>
	
		</div>
      
   
      
   