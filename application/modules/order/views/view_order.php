<h3 class="box-title">View Product Details</h3>
			<input type="hidden" name="id" value="<?php echo $productsData->id ?>" />
			<div class="box-form2">
			<table >
		<tr>
			<td width="150">Products Name: &nbsp;</td>
			<td width="160"><?php echo $productsData->prod_name; ?>
			<td width="50"></td>
			<td width="150">Price&nbsp;</td>
			<td width="160"><?php echo $productsData->price; ?></td>	
			
		</tr>
		<tr>
			<td width="150">SKU No.: &nbsp;</td>
			<td width="160"><?php echo $productsData->sku; ?></td>
			<td width="50"></td>
			<td width="150">Category</td>
			<td width="160"><?php //echo $this->products_model->get_pro1_name($productsData->category)?></td>
		</tr>
	
		</div>
      
   