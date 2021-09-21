div class="box-form2">
<form method="post" enctype="multipart/form-data" action="<?php echo base_url().'products/category' ?>" class="form-label-left">
<input type="hidden" name="id" value="<?php echo $categoryData->id ?>" />


			<table>
		<tr>
			<td width="150">Add Category:&nbsp;</td>
			<td width="160"><input type="text" name="category_name" value="<?php echo $categoryData->category_name; ?>" class="form-control" placeholder=""></td>
</tr>
<tr>
	<td width="50"><br><input type="submit" name="submit" class="form-control btn btn-primary" value="Save" >
	
		</td>
		</tr>
		
		
		
		
			</table> 	
			
			</form>
				</div>