
			<input type="hidden" name="inventory_id" value="<?php echo $inventoryData->inventory_id ?>" />
			<div class="box-form2">
				<?php // print_r($productsData); ?>
				<?php // $inventoryData->inventory_id ?>
			<table>
		<tr>

			<td width="150">Part No  &nbsp;</td>
			<td width="160"><?php
			if($inventoryData->part_type == 1  ){
				echo $this->Inventory_model->getprodname($inventoryData->part_names);
				} else{
				echo $this->Inventory_model->getassemblyname($inventoryData->part_names);
				}
			  ?> </td>
			<td width="50">
			<td width="150">Hold Pieces   &nbsp;</td>
			<td width="160">
			<?php
			if($inventoryData->part_type == 1  ){
				$pcs = $this->Inventory_model->getprodhold($inventoryData->part_names);
				$tot_pcs=0;
				foreach ($pcs as $key => $value) {

					$tot_pcs = $value->prod_pcs + $tot_pcs;
					
				}
				echo $tot_pcs;
				} else{
				$pcs1 = $this->Inventory_model->getassemblyprodhold($inventoryData->part_names);
				$tot_asspcs=0;
				foreach ($pcs1 as $key => $value) {

					$tot_asspcs = $value->prod_pcs + $tot_asspcs;
					
				}
				echo $tot_asspcs;
				}
			  ?>

			</td>
				
			
		</tr><br>
		
		</div>
		</table>
		