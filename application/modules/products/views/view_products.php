<style>
	td{
		padding-top:10px;
	}
	.popup{
		width: 800px;
	}
</style>
<h3 class="box-title">View Product Details</h3>
			<input type="hidden" name="id" value="<?php echo $productsData->product_id ?>" />
			<div class="box-form2">
			<table padding="5px" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer">
		<tr>
			<td width="150">Part No: &nbsp;</td>
			<td width="160"><?php echo $productsData->part_no; ?>
			<td width="50"></td>
			<td width="150">Price:&nbsp;</td>
			<td width="160"><?php echo $productsData->price; ?></td>	
			
		</tr>
		<tr>
			<td width="150">Marco Code: &nbsp;</td>
			<td width="160"><?php echo $productsData->marco_code; ?>
			<td width="50"></td>
		<td width="150">Manufacturer code: &nbsp;</td>
			<td width="160"><?php echo $productsData->m_code; ?></td>	
		</tr>
		<tr>
			<td width="150">Supplier  Price:&nbsp;</td>
			<td width="160"><?php echo $productsData->supplier_price; ?></td>
			
			<td width="50"></td>
			<td width="150">Category</td>
			<td width="160"><?php echo $this->Products_model->get_category($productsData->category)?></td>
		</tr>
		

		<tr>
			<td width="150">Supplier: &nbsp;</td>
			<td width="160"><?php 
			 $a = explode(',',$productsData->supplier_id);
			foreach($supplierData as $supplier){
			 if (in_array($supplier->supplier_id,$a)){ 
			 	echo $supplier->supplier_name.",";  } 
			 } ?></td>
			 <td></td>
			 <td width="150">VIdeo </td>
				<td> <a href="<?=base_url()?>assets/images/<?php echo $productsData->video; ?>" target="_blank">Watch Video</a></td>
		</tr>
		<tr>
			<td width="150"> Profile Pic&nbsp;</td>
	<td> <a href="<?=base_url()?>assets/images/<?php echo $productsData->profile_pic; ?>" target="_blank">See Profile Pic</a></td>
	<td></td>
	<td></td><td></td>
</tr>

		
		<tr>
			
			<td width="150">Parts Used: &nbsp;</td>
			<td width="160"><?php echo $productsData->parts_used; ?></td>	
			<td width="50"></td>
			<td  width="150">Tags: </td>
			<td  width="160"><?php $product_tagsData = $this->Products_model->get_data_by('product_tags',$productsData->product_id ,'product_id');
					$tags='';
					foreach ($product_tagsData as $object) { 
						$tags .= $this->Products_model->get_tag_name($object->tag_id).", "; 
						} echo rtrim($tags,', ') ?></td>


		</tr>
		
		<tr>
			<td width="150">Pictures: &nbsp;</td>
		
			<td>
				<?php $product_picData = $this->Products_model->get_data_by('products_media',$productsData->product_id ,'product_id');
					foreach ($product_picData as $object) {  ?>
						<img src="<?=base_url()?>/assets/images/<?php echo $object->media; ?>" style="width:200px">
				<?php } ?>
			</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		</div>
      
   