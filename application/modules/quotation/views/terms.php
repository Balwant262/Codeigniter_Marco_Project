<div class="box-form2">
<form method="post" enctype="multipart/form-data" action="<?php echo base_url().'quotation/terms' ?>" class="form-label-left">
<input type="hidden" name="terms_id" value="<?php echo $termsData->terms_id ?>" />

			<table>
		<tr class="mar10">
			<td width="150">Add Terms:&nbsp;</td>
			<td width="160">
				<textarea style="width: 400px;height: 150px;" name="terms_descr" class="form-control"><?php echo $termsData->terms_descr; ?> </textarea>
			</td>
			
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