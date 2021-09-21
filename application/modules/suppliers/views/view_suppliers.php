<style>
td{
	padding-top:10px;
}
</style>

<h4 class="box-title">View Supplier</h4>
			<div class="box-form2" style="overflow-x:auto;">
			<table id="example">
		
		<tr>
			<td width="150">Name:&nbsp;</td>
			<td width="160"><?php echo $supplierData->supplier_name; ?></td>
			<td width="50">&nbsp;</td>
			<td width="150">Price:&nbsp;</td>
			<td width="150"><?php echo $supplierData->supplier_price; ?></td>
		</tr>
		
		</table>	
			</div>
			<script type="text/javascript">
  $(document).ready(function() {  
    var url = '<?php echo base_url();?>';//$('.content-header').attr('rel');
    var table = $('#example').DataTable({ 
          responsive: true
          
      });
    
  });
</script>            