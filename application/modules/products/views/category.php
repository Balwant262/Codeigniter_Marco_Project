<div class="box-form2">
<form method="post" enctype="multipart/form-data" action="<?php echo base_url().'products/category' ?>" class="form-label-left">
<input type="hidden" name="category_id" value="<?php echo $categoryData->category_id ?>" />

			<table>
		<tr class="mar10">
			<td width="150">Add Category:&nbsp;</td>
			<td width="160"><input type="text" name="category_name" value="<?php echo $categoryData->category_name; ?>" class="form-control" placeholder=""></td>
			<td width="50"></td>
			<td width="150">Parent Category:&nbsp;</td>
			<td width="160"><select name="parent_id" class="form-control">
			<option value="">Select</option>
			<?php foreach($category1Data as $category){ ?>
			<option value="<?php echo $category->category_id; ?>" <?php if(($categoryData->parent_id) == ($category->category_id)){ echo "selected"; } ?>><?php echo $category->category_name; ?></option>
			<?php } ?>
			</select></td>
		
<tr>
	<td width="50"><br><input type="submit" name="submit" class="form-control btn btn-primary" value="Save" >
	
		</td>
		</tr>
		
		
		
		
			</table> 	
			
			</form>
				</div>
<style type="text/css">
	.mar10{
		margin:20px;
	}
	td{
		padding: 10px;
	}
</style>