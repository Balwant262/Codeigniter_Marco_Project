	<style type="text/css">
	td{
		padding: 5px;
	}
	.borderpad{
		margin:20px 0;
		border-color: grey; 
	}
	.d-none
	{
		display:none;
	}

</style>
<?php $getp = $this->Order_model->getproductlist($orderData->order_id);
$id =$this->Order_model->getlastid();
//print_r($id);
	//print_r($getp);
	?>
	<Select width="150" id="prod" class="d-none" name="prod" >
		<option value="">select</option>
		<?php
	foreach ($getp as $key => $value) {
		if($value->part_nm!='0'){
		echo  "<option value=".$value->part_nm.">".$this->Order_model->getproductname($value->part_nm)."</option>";
	}
	}
?>
</Select>
<Select width="150" id="assem_prod" class="d-none" name="assem_prod">
	<option value="">select</option>
		<?php
	foreach ($getp as $key => $value) {
		if($value->assemble_prod!='0'){
		echo "<option value=".$value->assemble_prod.">".$this->Order_model->getassproductname($value->assemble_prod)."</option>";
	}
	}
?>
</Select>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'order/add'?>" method="post">
<!-- <h3>Add rawmaterial Details</h3> -->
			<input type="hidden" id="order_id" name="order_id" value="<?php echo $orderData->order_id ?>" />
	<table><tr>
					<td width="150px">Customer Name<sup>*</sup>  &nbsp; </td>
			<td width='150px'><select name="client" class="form-control " required>
				<option value=""> Select </option>
				<?php


				foreach ($userdatas as $key => $usere) { 
					?>

					<option value="<?php echo $usere->client_id; ?>"  <?php if(($orderData->client) == ($usere->customer_id)){ echo "selected"; } ?>    ><?php echo $usere->co_name; ?></option>
				<?php }
				 ?>
			</select>
			</td>
			<td width="50"> </td>
			<?php if($orderData->order_id!=''){ ?>
					
			<td width='150px'>Batch No<sup>*</sup>  &nbsp;</td>
			<td width='150px'><input type="text"  name="gadget_id" value="<?php echo $orderData->order_id ?>" size="20" class="form-control " placeholder="" required readonly></td>
		
		<?php } else{ ?>
			<td style="width:100px">Batch No<sup>*</sup>  &nbsp;</td>
			<td style="width:100px"><input type="text"  name="gadget_id" 
				value="<?php echo $id['0']->order_id+1; ?>" size="20" class="form-control " placeholder="" required readonly></td>
		<?php } ?>
			</tr>
			<tr>
				<td style="width:100px">Order Date<sup>*</sup>  &nbsp;</td>
			<td style="width:100px"><input type="date"  name="order_date" 
				value="<?php echo $orderData->order_date; ?>"  class="form-control " placeholder="" required ></td>

				<td width="50"> </td>
				<td style="width:100px">PO Number&nbsp;</td>
				<td style="width:100px"><input type="text"  name="po_no" 
				value="<?php echo $orderData->po_no; ?>"  class="form-control " placeholder=""  ></td>

			</tr>

			<tr>
				<td style="width:100px">Supplier  &nbsp;</td>
			<td style="width:100px">
				<select name="supplier_id" class="form-control " required>
				<option value=""> Select </option>
				<?php foreach ($supplierdata as $key => $supplier) { ?>
					<option value="<?php echo $supplier->supplier_id; ?>"  <?php if(($orderData->supplier_id) == ($supplier->supplier_id)){ echo "selected"; } ?>    ><?php echo $supplier->supplier_name; ?></option>
				<?php } ?>
			</select>
			</td>
			 </table>
		
		<tr>
			<td colspan="3"><br><b>Please Select Products Or Assembly Products<br></b></td>
		</tr>
			 
	
			<div class="box-form2">
				<div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field1">  
                               	<tr>
				<th style="width:100px">Products</th>
				
				<th style="width:80px" >Assembly Products</th>
				<!-- <th style="width:80px" >Raw Material</th>
				<th style="width:80px" >Unit</th>
				<th style="width:100px" >Weight</th>
				 -->
				<th style="width:120px" >Pcs</th>
				
				<th style="width:100px"></th>
			</tr>
                               		<?php 
                               		
								if($orderData->order_id!=''){  
								
						 $j=1; 
						
						  
						   foreach ($order_follow_up as $object) { 	
						  
						  ?>
				
			<tr  id="row" class="">
				<td width="150px"><select name="part_nm<?php echo $j; ?>" class="form-control partnm" id="selectproduct<?php echo $j; ?>" onchange="changeAss(<?php echo $j; ?>)">
			<option value="">Select</option>

			<?php foreach($productsData as $products){ ?>
			<option value="<?php echo $products->product_id; ?>"  <?php if(($object->part_nm) == ($products->product_id)){ echo "selected"; } ?>    ><?php echo $products->part_no; ?></option>
			<?php } ?>
		
			</select>
					</td>
					<td width="150px">
						<select name="assemble_prod<?php echo $j; ?>"   class="form-control assemble" id="assemble_prod<?php echo $j; ?>" onchange="changepro(<?php echo $j; ?>)" >
			<option value="">Select</option>

			<?php foreach($assembleData as $assemble){ ?>
			<option value="<?php echo $assemble->assemble_id; ?>"  <?php if(($object->assemble_prod) == ($assemble->assemble_id)){ echo "selected"; } ?>    ><?php echo $assemble->part_name; ?></option>
			<?php } ?>
		
			</select>

					</td>
				<!-- 	<td width="150"> <select name="raw_name<?php echo $j; ?>"   class="form-control" id="raw_name<?php echo $j; ?>" >
			<option value="">Select</option>

			<?php foreach($rawData as $raw){ ?>
			<option value="<?php echo $raw->rm_id; ?>"  <?php if(($object->raw_name) == ($raw->rm_id)){ echo "selected"; } ?>    ><?php echo $raw->rm_name; ?></option>
			<?php } ?>
		
			</select></td>
			<td style="width: 80px">
					<select name="unit1<?php echo $j ?>" class="form-control" id="unit1<?php echo $j ?>">
				<option value="kg"<?php if($object->unit1=='kg'){echo 'selected';}?>>Kilograms(KG)</option>
				<option value="g" <?php if($object->unit1=='g'){echo 'selected';}?>>Grams(G)</option>
				<!- <option value="pcs" <?php if($object->unit1=='pcs'){echo 'selected';}?>>Pieces(Pcs)</option> ->
			</select>
				</td>
				<td style="width:80px"><input  type="text"  onchange="changePcs(<?php echo $j; ?>)" onkeypress="return isNumberKey(event)" class="form-control whgt" id="prodwght<?php echo $j; ?>" name="product_wght<?php echo $j ?>" value="<?php echo $object->product_wght ?>" /></td> -->
				
				<td style="width: 80px">
					<input type="number" id="prod_pcs<?php echo $j; ?>" onchange="changeWght(<?php echo $j; ?>)"  name="prod_pcs<?php echo $j ?>" value="<?php echo $object->prod_pcs; ?>" class="form-control pcs" placeholder="">
				</td> 

				 <?php  $j++; } 
				if($orderData->order_id){
				 ?>

				<input type="hidden" name="number" id="number" value="<?php echo $j-1 ?>">
				<?php } else { ?>
				<input type="hidden" name="number" id="number" value="1">
				<?php } ?>
				
				<td><button type="button" name="edit" id="edit" class="btn btn-success">Add More</button></td> 
				
				
				</tr>
				
				<?php }else{ ?>	
				




				<tr id="row">
						<td><select name="part_nm1" onchange="changeAss(1)"   class="form-control partnm" id="selectproduct1" >
				<option value="">Select</option>

				<?php foreach($productsData as $products){ ?>
				<option value="<?php echo $products->product_id; ?>"  <?php if(($object->part_nm) == ($products->product_id)){ echo "selected"; } ?>    ><?php echo $products->part_no; ?></option>
				<?php } ?>
			
				</select></td>
				<td width="150px">
						<select name="assemble_prod1" onchange="changepro(1)"  class="form-control assemble" id="assemble_prod1" >
			<option value="">Select</option>

			<?php foreach($assembleData as $assemble){ ?>
			<option value="<?php echo $assemble->assemble_id; ?>"  <?php if(($object->assemble_prod) == ($assemble->assemble_id)){ echo "selected"; } ?>    ><?php echo $assemble->part_name; ?></option>
			<?php } ?>
		
			</select>

					</td>
					<!-- <td width="150"> <select name="raw_name1"   class="form-control" id="raw_name1" >
			<option value="">Select</option>

			<?php foreach($rawData as $raw){ ?>
			<option value="<?php echo $raw->rm_id; ?>"  <?php if(($object->raw_name) == ($raw->rm_id)){ echo "selected"; } ?>    ><?php echo $raw->rm_name; ?></option>
			<?php } ?>
		
			</select></td>
				<td style="width: 80px">
					<select name="unit11" class="form-control" id="unit11">
				<option value="kg"<?php if($object->unit1=='kg'){echo 'selected';}?>>Kilograms(KG)</option>
				<option value="g" <?php if($object->unit1=='g'){echo 'selected';}?>>Grams(G)</option>
				
			</select>
				</td>
			<td><input type="text" onchange="changePcs(1)" onkeypress="return isNumberKey(event)" class="form-control whgt" name="product_wght1" id="prodwght1" value="" /></td> -->

			
				<td style="width: 80px">
					<input type="number" id="prod_pcs1" onchange="changeWght(1)" name="prod_pcs1" value="" class="form-control pcs" placeholder="" required>
				</td>
				
			
				<input type="hidden" name="number" id="number" value="1">
			
						  	<td><button type="button" name="add1" id="add1" class="btn btn-success">Add More</button></td>
						  	
						  	 <?php } ?>

				</tr>  
</div>












			<table id="example1" >
		
			
		

		<tr>
			
			
<?php
			if($orderData->order_id !=''){
				?>
				<td width="150"> <button type="button" id="addblank" name="addblank" class="btn btn-success">Add Blanking</button></td>
				<?php $query=$this->db->Select('*')->from('order_status')->where('ati',1)->where('order_status',1)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}

				?>
			</tr>
				<tr>
				<table class="" id="blank">
				</table>
				</tr>
				<span id="showblank"  style="display: <?php echo $display ?>" > <td><b>Blanking </b></td></span>
				
				
				<table class="borderpad" border="1" >
				<thead  id="newblank">
				<tr id="showw1" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php  
				$dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y");  ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
		
		
			<span id ="showblankbtn" style="display: <?php echo $display ?>">
			<td width="150"> <button type="button" id="addinventory" name="addinventory" class="btn btn-success">Add To Inventory</button></td>
			<td width="150"> <button type="button" id="sendplating" name="sendplating" class="btn btn-success">Send to Plating </button></td>
			<td width="150"> <button type="button" id="addplatingfrominvetory" name="addplatingfrominvetory" class="btn btn-success">Add Plating from Inventory </button></td>
			</span>
			<?php  ?>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',1)->where('order_status',1)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}

				 ?>
				<tr>
				<table class="" id="invento">
				</table>
				</tr>

			<span id="showblankinvent"  style="display: <?php echo $display ?>" ><td> <b> Inventory Table </b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newinvento">
				<tr id="showw2" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180">Scrap </td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				 <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
		
		<?php $query=$this->db->Select('*')->from('order_status')->where('ati',0)->where('order_status',2)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				 ?>
				<tr>

			<table class="" id="platings">
				</table> 
			</tr>
			<span  id="showplati"  style="display: <?php echo $display ?>" ><td> <b> Plating Table </b> </td></span>

				<table class="borderpad" border="1" >
				<thead  id="newplatings">
				<tr id="showw3" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Scrap</td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',2)->where('order_status',2)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				 ?>
				<tr>

			<table class="" id="addplatingfrinve">
				</table> 
			</tr>
			<span  id="showplatingfrive"  style="display: <?php echo $display ?>" ><td> <b> Plating Table inserted From Inventory </b> </td></span>

				<table class="borderpad" border="1" >
				<thead  id="newplatingsfrominvent">
				<tr id="showw31" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Scrap</td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<span id ="showplatebtn" style="display: <?php echo $display ?>">
			<td width="150"> <button type="button" id="addinventoryplating" name="addinventoryplating" class="btn btn-success">Add To Inventory</button></td>
			<td width="150"> <button type="button" id="sendpacking" name="sendpacking" class="btn btn-success">Send to Packing </button></td>
			<td width="150"> <button type="button" id="addpackingfrominvetory" name="addpackingfrominvetory" class="btn btn-success">Add Packing from Inventory </button></td>
			</span>
			<?php 
			$query=$this->db->Select('*')->from('order_status')->where('ati',1)->where('order_status',2)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				} ?>
				<tr>
				<table class="" id="inventoplating">
				</table>
			</tr>
					<span id="showplatiinvent"  style="display: <?php echo $display ?>" ><td> <b> Inventory Table of Plating</b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newinventoplat">
				<tr id="showw4" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Scrap</td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<tr>
			<table class="" id="packings">
				</table>
			</tr>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',0)->where('order_status',3)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}  ?>
			<span id="showpackinvent"  style="display: <?php echo $display ?>" ><td> <b> Packing Table </b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newpackings">
				<tr id="showw5" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180">scrap </td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				 <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',2)->where('order_status',3)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				 ?>
				<tr>

			<table class="" id="addpackingfrinve">
				</table> 
			</tr>
			<span  id="showpackingfrive"  style="display: <?php echo $display ?>" ><td> <b> Packing Table inserted From Inventory </b> </td></span>

				<table class="borderpad" border="1" >
				<thead  id="newpackingsfrominvent">
				<tr id="showw32" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Scrap</td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<span id="showpackinventbtn" style="display: <?php echo $display ?>" >
			<td width="150"> <button type="button" id="addinventorypacking" name="addinventorypacking" class="btn btn-success">Add To Inventory</button></td>
			<td width="150"> <button type="button" id="sendfingd" name="sendfingd" class="btn btn-success">Send to Finished Goods </button></td>
			<td width="150"> <button type="button" id="addfishinfrominvetory" name="addfishinfrominvetory" class="btn btn-success">Add Finished Goods from Inventory </button></td>
		</span>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',1)->where('order_status',3)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result(); 
				if($result){
					$display="block";
				}else{
					$display="none";
				} ?>
				<tr>
					<table class="" id="inventopacking">
				</table>
				</tr>
				<span id="showpackinvent1"  style="display: <?php echo $display ?>"><td> <b> Inventory Table of packing</b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newinventopacking">
				<tr id="showw6" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180">Scrap </td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<?php 
			$query=$this->db->Select('*')->from('order_status')->where('ati',0)->where('order_status',4)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				?>
				<tr>
					<table class="" id="finisgoods">
				</table>
				</tr>
			<span id="showfisin"  style="display: <?php echo $display ?>"><td> <b> Finished Goods Table </b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newfingoods">
				<tr id="showw7" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180">Scrap </td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',4)->where('order_status',2)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				 ?>
				<tr>

			<table class="" id="addfishfrinve">
				</table> 
			</tr>
			<span  id="showfishfrive"  style="display: <?php echo $display ?>" ><td> <b> Finishing Goods Table inserted From Inventory </b> </td></span>

				<table class="borderpad" border="1" >
				<thead  id="newfishfrominvent">
				<tr id="showw33" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Scrap</td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<span id="showfisinbtn"  style="display: <?php echo $display ?>">
			<td width="150"> <button type="button" id="addinventoryfingd" name="addinventoryfingd" class="btn btn-success">Add To Inventory</button></td>
			<td width="150"> <button type="button" id="senddelivery" name="senddelivery" class="btn btn-success">Send to Delivery </button></td>
			<td width="150"> <button type="button" id="addeliveryfrominvetory" name="addeliveryfrominvetory" class="btn btn-success">Add Delivery from Inventory </button></td>
			</span>
			<tr>
				<table class="" id="inventogdfin">
				</table>
			</tr>
			<?php 	$query=$this->db->Select('*')->from('order_status')->where('ati',1)->where('order_status',4)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				?>
				<span id="finishinveo"  style="display: <?php echo $display ?>"><td> <b> Inventory Table of Finished Goods</b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newinventogdfinish">
				<tr id="showw8" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180">Scrap </td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
			
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',0)->where('order_status',5)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				 ?>
				 <tr>
			<table class="" id="deliver">
				</table></tr>
			<span id="deliveatab"  style="display: <?php echo $display ?>"><td> <b> Delivery Table </b> </td></span>
			
				<table class="borderpad" border="1" >
				<thead  id="newdeliv">
				<tr id="showw9" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180">Scrap </td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
			<?php $query=$this->db->Select('*')->from('order_status')->where('ati',5)->where('order_status',2)->where('ord_batch_no',$orderData->order_id)->get();
				$result=$query->result();
				if($result){
					$display="block";
				}else{
					$display="none";
				}
				 ?>
				<tr>

			<table class="" id="adddeliveryfrinve">
				</table> 
			</tr>
			<span  id="showdeliverfrive"  style="display: <?php echo $display ?>" ><td> <b> Delivery Table inserted From Inventory </b> </td></span>

				<table class="borderpad" border="1" >
				<thead  id="newdeliveryfrominvent">
				<tr id="showw35" style="display: none"> 
					<td width="180">Product</td>
					<td width="180">Assembly Product</td>
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Scrap</td>
				</tr>
				
			 </thead>
			 <tfoot>
			 	<?php
				
				
				foreach ($result as $key => $value) { ?>
					<tr>
				<td width="180"><?php echo $this->Order_model->getproductname($value->ord_prodnam); ?> </td>
				<td width="180"><?php echo $this->Order_model->getassproductname($value->ord_asspronam); ?> </td>
				<td width="180"><?php
				 $dates= date_create("$value->date");
				 echo date_format($dates,"d/m/Y"); ?> </td>
				 <td width="180"><?php echo $value->pcs; ?> </td>
				  <td width="180"><?php echo $value->scrap; ?> </td>
					</tr>
				<?php }
				 ?>

			 </tfoot>
			</table>
		<!-- 	<td width="150">Order Status<sup>*</sup>  &nbsp;</td>
			
			<td width="160"><select name="order_status" id="order_status" class="form-control">

				<option value=''>Select</option>
				<option value="Blanking"<?php if($orderData->order_status=='Blanking'){echo 'selected';}?>>Blanking</option>
				<option value="Plating"<?php if($orderData->order_status=='Plating'){echo 'selected';}?>>Plating</option>
				<option value="Packing" <?php if($orderData->order_status=='Packing'){echo 'selected';}?>>Packing</option>
				<option value="Finished Goods" <?php if($orderData->order_status=='Finished Goods'){echo 'selected';}?>>Finished Goods</option>
			</select></td>

 -->
 			
		<?php } else { ?>
			<!-- <td width="150">Order Status<sup>*</sup>  &nbsp;</td>
			
			<td width="160">
				<select name="order_status" id="" class="form-control" >

				
				<option value="Blanking" selected>Blanking</option>
				
			</select>
		</td> -->
		<?php  } ?>
		</tr>
		




		
		</div>
		</table>
		<div>
		<button type="submit" class="btn btn-primary" name="submit" id="submit" value="submit">Submit
		</button>
		</div>
      
      </form>


  </div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		// $('#prod').hide();
		// $('#assem_prod').hide();
		//$("  #prod").css("display": "none !important");


	});
	$(document).ready(function(){
		var b=1;
		
		$('#addblank').click(function(){
			$('#blank').append('<tr id="rows'+b+'"><td width="160" id="td'+b+'"></td><td  width="160" class="assemble" id="tda'+b+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+b+'" id="blank_date'+b+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+b+'"  name="blank_pcs'+b+'" class="form-control " placeholder=""></td><td> <button onclick="submitdata('+b+',1)" type="button" class="btn btn-success">Added to Blanking</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+b+'').attr('name', 'prod'+b+'').attr('onchange','changeprods('+b+')').attr('class','form-control').appendTo($('#td'+b+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+b+'').attr('class','form-control').attr('name', 'assemble_prod'+b+'').attr('onchange','changeprodass('+b+')').appendTo($('#tda'+b+''));
			b++;
		});




	});
	$(document).ready(function(){
		var c=1;
		$('#addinventory').click(function(){
			$('#invento').append('<tr id="crows'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+c+'"  name="scrap'+c+'" class="form-control " placeholder=""></td><td> <button onclick="subbmitdata('+c+',1)" type="button" class="btn btn-success">Added to Inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+c+'').attr('name', 'prod'+c+'').attr('onchange','changeprods('+c+')').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+c+'').attr('class','form-control').attr('name', 'assemble_prod'+c+'').attr('onchange','changeprodass('+c+')').appendTo($('#tda'+c+''));
			c++;
		});

	});
	$(document).ready(function(){
		var d=1;
		$('#sendplating').click(function(){
			$('#platings').append('<tr id="plats'+d+'"><td width="160" id="td'+d+'"></td><td  width="160" class="assemble" id="tda'+d+'"></td><td width="130">Date</td><td width="130"><input type="date" name="blank_date'+d+'" id="blank_date'+d+'"class="form-control " placeholder=""></td><td width="120"> Pieces</td><td width="130"><input type="text" id="blank_pcs'+d+'"  name="blank_pcs'+d+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+d+'"  name="scrap'+d+'" class="form-control " placeholder=""></td><td><button onclick="subbmitdataplat('+d+',2)" type="button" class="btn btn-success">Sent to plating</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+d+'').attr('name', 'prod'+d+'').attr('onchange','changeprods('+d+')').attr('class','form-control').appendTo($('#td'+d+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+d+'').attr('class','form-control').attr('name', 'assemble_prod'+d+'').attr('onchange','changeprodass('+d+')').appendTo($('#tda'+d+''));
			d++;
		});

	});

	$(document).ready(function(){
		var c=1;
		$('#addinventoryplating').click(function(){
			$('#inventoplating').append('<tr id="invplating'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+c+'"  name="scrap'+c+'" class="form-control " placeholder=""></td><td> <button onclick="addinventoplating('+c+',2)" type="button" class="btn btn-success">Added to Inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+c+'').attr('name', 'prod'+c+'').attr('onchange','changeprods('+c+')').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+c+'').attr('class','form-control').attr('name', 'assemble_prod'+c+'').attr('onchange','changeprodass('+c+')').appendTo($('#tda'+c+''));
			c++;
		});

	});
	$(document).ready(function(){
		var c=1;
		$('#addplatingfrominvetory').click(function(){
			$('#addplatingfrinve').append('<tr id="platfrom'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="100"> Inv.</td><td width="130"><input type="text" id="inv_blnk'+c+'"  name="inv_blnk'+c+'" class="form-control " placeholder="" readonly></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td> <button onclick="addplatingfrominvent('+c+',2)" type="button" class="btn btn-success">Added to Plating from inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectpc'+c+'').attr('name', 'prodc'+c+'').attr('onchange','changeprodsc('+c+',2)').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_prc'+c+'').attr('class','form-control').attr('name', 'assemble_prodc'+c+'').attr('onchange','changeprodassc('+c+',2)').appendTo($('#tda'+c+''));
			c++;
		});

	});
	$(document).ready(function(){
		var c=1;
		$('#addpackingfrominvetory').click(function(){
			$('#addpackingfrinve').append('<tr id="packfrom'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="100"> Inv.</td><td width="130"><input type="text" id="inv_blnk'+c+'"  name="inv_blnk'+c+'" class="form-control " placeholder="" readonly></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td> <button onclick="addpackingfrominvent('+c+',3)" type="button" class="btn btn-success">Added to Packing from inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectpc'+c+'').attr('name', 'prodc'+c+'').attr('onchange','changeprodsc('+c+',3)').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_prc'+c+'').attr('class','form-control').attr('name', 'assemble_prodc'+c+'').attr('onchange','changeprodassc('+c+',3)').appendTo($('#tda'+c+''));
			c++;
		});

	});
		$(document).ready(function(){
		var c=1;
		$('#addfishinfrominvetory').click(function(){
			$('#addfishfrinve').append('<tr id="fishifrom'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="100"> Inv.</td><td width="130"><input type="text" id="inv_blnk'+c+'"  name="inv_blnk'+c+'" class="form-control " placeholder="" readonly></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td> <button onclick="addfishnifrominvent('+c+',4)" type="button" class="btn btn-success">Added to Packing from inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectpc'+c+'').attr('name', 'prodc'+c+'').attr('onchange','changeprodsc('+c+',4)').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_prc'+c+'').attr('class','form-control').attr('name', 'assemble_prodc'+c+'').attr('onchange','changeprodassc('+c+',4)').appendTo($('#tda'+c+''));
			c++;
		});

	});
			$(document).ready(function(){
		var c=1;
		$('#addeliveryfrominvetory').click(function(){
			$('#adddeliveryfrinve').append('<tr id="deliverfrom'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="100"> Inv.</td><td width="130"><input type="text" id="inv_blnk'+c+'"  name="inv_blnk'+c+'" class="form-control " placeholder="" readonly></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td> <button onclick="adddeliveryfrominvent('+c+',5)" type="button" class="btn btn-success">Added to Packing from inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectpc'+c+'').attr('name', 'prodc'+c+'').attr('onchange','changeprodsc('+c+',5)').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_prc'+c+'').attr('class','form-control').attr('name', 'assemble_prodc'+c+'').attr('onchange','changeprodassc('+c+',5)').appendTo($('#tda'+c+''));
			c++;
		});

	});
	$(document).ready(function(){
		var d=1;
		$('#sendpacking').click(function(){
			$('#packings').append('<tr id="plats'+d+'"><td width="160" id="td'+d+'"></td><td  width="160" class="assemble" id="tda'+d+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+d+'" id="blank_date'+d+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+d+'"  name="blank_pcs'+d+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+d+'"  name="scrap'+d+'" class="form-control " placeholder=""></td><td> <button onclick="subbmitdatapack('+d+',3)" type="button" class="btn btn-success">sent to packing</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+d+'').attr('name', 'prod'+d+'').attr('onchange','changeprods('+d+')').attr('class','form-control').appendTo($('#td'+d+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+d+'').attr('class','form-control').attr('name', 'assemble_prod'+d+'').attr('onchange','changeprodass('+d+')').appendTo($('#tda'+d+''));
			d++;
		});

	});
	$(document).ready(function(){
		var c=1;
		$('#addinventorypacking').click(function(){
			$('#inventopacking').append('<tr id="invtopacking'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+c+'"  name="scrap'+c+'" class="form-control " placeholder=""></td><td> <button onclick="addinventopacking('+c+',3)" type="button" class="btn btn-success">Added to Inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+c+'').attr('name', 'prod'+c+'').attr('onchange','changeprods('+c+')').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+c+'').attr('class','form-control').attr('name', 'assemble_prod'+c+'').attr('onchange','changeprodass('+c+')').appendTo($('#tda'+c+''));
			c++;
		});

	});
	$(document).ready(function(){
		var d=1;
		$('#sendfingd').click(function(){
			$('#finisgoods').append('<tr id="finsg'+d+'"><td width="160" id="td'+d+'"></td><td  width="160" class="assemble" id="tda'+d+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+d+'" id="blank_date'+d+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+d+'"  name="blank_pcs'+d+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+d+'"  name="scrap'+d+'" class="form-control " placeholder=""></td><td> <button onclick="subbmitdatafingd('+d+',4)" type="button" class="btn btn-success">Sent to Finished Goods</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+d+'').attr('name', 'prod'+d+'').attr('onchange','changeprods('+d+')').attr('class','form-control').appendTo($('#td'+d+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+d+'').attr('class','form-control').attr('name', 'assemble_prod'+d+'').attr('onchange','changeprodass('+d+')').appendTo($('#tda'+d+''));
			d++;
		});

	});
		$(document).ready(function(){
		var c=1;
		$('#addinventoryfingd').click(function(){
			$('#inventogdfin').append('<tr id="invtfin'+c+'"><td width="160" id="td'+c+'"></td><td  width="160" class="assemble" id="tda'+c+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+c+'" id="blank_date'+c+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+c+'"  name="blank_pcs'+c+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+c+'"  name="scrap'+c+'" class="form-control " placeholder=""></td><td> <button onclick="addinventogdfinsh('+c+',4)" type="button" class="btn btn-success">Added to Inventory</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+c+'').attr('name', 'prod'+c+'').attr('onchange','changeprods('+c+')').attr('class','form-control').appendTo($('#td'+c+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+c+'').attr('class','form-control').attr('name', 'assemble_prod'+c+'').attr('onchange','changeprodass('+c+')').appendTo($('#tda'+c+''));
			c++;
		});

	});
	$(document).ready(function(){

		var d=1;
		$('#senddelivery').click(function(){
			$('#deliver').append('<tr id="sndtodel'+d+'"><td width="160" id="td'+d+'"></td><td  width="160" class="assemble" id="tda'+d+'"></td><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+d+'" id="blank_date'+d+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+d+'"  name="blank_pcs'+d+'" class="form-control " placeholder=""></td><td>scrap<td><td width="130"><input type="text" id="scrap'+d+'"  name="scrap'+d+'" class="form-control " placeholder=""></td><td> <button onclick="subbmitsendtodel('+d+',5)" type="button" class="btn btn-success">Sent to Delivery</button></td></tr>');
			$('#prod').clone().attr('id', 'selectp'+d+'').attr('name', 'prod'+d+'').attr('onchange','changeprods('+d+')').attr('class','form-control').appendTo($('#td'+d+''));
			$('#assem_prod').clone().attr('id', 'assemble_pr'+d+'').attr('class','form-control').attr('name', 'assemble_prod'+d+'').attr('onchange','changeprodass('+d+')').appendTo($('#tda'+d+''));
			d++;
		});

	});
	function subbmitdata(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var ati=1;
			var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =document.getElementById('scrap'+q).value;

       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw2').show();
    $('#showblankinvent').show();
    //$('#showblankbtn').show();
    $('#newinvento').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#crows'+q).remove();
	}
	}
	function submitdata(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var ati=1;
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati}
    }).done(function(data) {
		});
    $('#showw1').show();
    $('#showblank').show();
    $('#showblankbtn').show();
    $('#newblank').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td></tr>');
		$('#rows'+q).remove();
	}
	}
	
	function addplatingfrominvent(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectpc'+q).children("option:selected").val();
		var products1 = $( "#selectpc"+q+" option:selected" ).text();

		var assembprod =$('#assemble_prc'+q).children("option:selected").val();
		
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_prc"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =0;
       	var ati=2;
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw31').show();
    $('#showplatingfrive').show();
   // $('#showblankbtn').show();
    $('#newplatingsfrominvent').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#platfrom'+q).remove();
	}
	}
	function addpackingfrominvent(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectpc'+q).children("option:selected").val();
		var products1 = $( "#selectpc"+q+" option:selected" ).text();

		var assembprod =$('#assemble_prc'+q).children("option:selected").val();
		
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_prc"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =0;
       	var ati=2;
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw32').show();
    $('#showpackingfrive').show();
   // $('#showblankbtn').show();
    $('#newpackingsfrominvent').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#packfrom'+q).remove();
	}
	}
	function addfishnifrominvent(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectpc'+q).children("option:selected").val();
		var products1 = $( "#selectpc"+q+" option:selected" ).text();

		var assembprod =$('#assemble_prc'+q).children("option:selected").val();
		
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_prc"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =0;
       	var ati=2;
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw33').show();
    $('#showfishfrive').show();
   // $('#showblankbtn').show();
    $('#newfishfrominvent').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#fishifrom'+q).remove();
	}
	}
	function adddeliveryfrominvent(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectpc'+q).children("option:selected").val();
		var products1 = $( "#selectpc"+q+" option:selected" ).text();

		var assembprod =$('#assemble_prc'+q).children("option:selected").val();
		
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_prc"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =0;
       	var ati=2;
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw35').show();
    $('#showdeliverfrive').show();
   // $('#showblankbtn').show();
    $('#newdeliveryfrominvent').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#deliverfrom'+q).remove();
	}
	}
	function subbmitdataplat(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =0;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		var scrap =document.getElementById('scrap'+q).value;
		
		// var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;

       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
    	
		});

    $('#showw3').show();
   $('#showplati').show();
   $('#showplatebtn').show();
    $('#newplatings').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#plats'+q).remove();
	}
	}
	function addinventoplating(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =1;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		//var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =document.getElementById('scrap'+q).value;
		
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw4').show();
    $('#showplatiinvent').show();
   // $('#showplatebtn').show();
    $('#newinventoplat').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#invplating'+q).remove();
	}
	}
	function subbmitdatapack(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =0;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}

		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		//var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;
       	var scrap =document.getElementById('scrap'+q).value;
       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw5').show();
    $('#showpackinvent').show();
   $('#showpackinventbtn').show();
    $('#newpackings').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td width="180"><td>'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#plats'+q).remove();
	}
	}
	function addinventopacking(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();
		var scrap =document.getElementById('scrap'+q).value;
		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =1;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		//var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;

       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw6').show();
    $('#showpackinvent1').show();
   // $('#showplatebtn').show();
    $('#newinventopacking').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td> <td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#invtopacking'+q).remove();
	}
	}
	function subbmitdatafingd(q,w){
		var id ="<?php echo $orderData->order_id ?>";
		var scrap =document.getElementById('scrap'+q).value;
		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =0;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		//var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;

       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw7').show();
    $('#showfisin').show();
   $('#showfisinbtn').show();
    $('#newfingoods').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#finsg'+q).remove();
	}
	}
	function addinventogdfinsh(q,w){
		var id ="<?php echo $orderData->order_id ?>";
		var scrap =document.getElementById('scrap'+q).value;
		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =1;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		//var date =dd + "/" + mm + "/" + yyyy;
		//var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;

       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw8').show();
    $('#finishinveo').show();
   // $('#showplatebtn').show();
    $('#newinventogdfinish').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#invtfin'+q).remove();
	}
	}
	function subbmitsendtodel(q,w){
		var id ="<?php echo $orderData->order_id ?>";
		var scrap =document.getElementById('scrap'+q).value;
		var product =	 $('#selectp'+q).children("option:selected").val();
		var products1 = $( "#selectp"+q+" option:selected" ).text();

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		var ati =0;
		if(products1=='select'){
			products1='';
		}
		var assembprod1 = $( "#assemble_pr"+q+" option:selected" ).text();
		if(assembprod1=='select'){
			assembprod1='';
		}
		var date =document.getElementById('blank_date'+q).value;
		var dateq = new Date(document.getElementById('blank_date'+q).value);
		let dd = dateq.getDate();
		let mm = dateq.getMonth() + 1;
		let yyyy = dateq.getFullYear();
		var dates =dd + "/" + mm + "/" + yyyy;
		//var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;

       	if(date!='' && pcs!=''){
       		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w,ati:ati,scrap:scrap}
    }).done(function(data) {
		});
    $('#showw9').show();
    $('#deliveatab').show();
  // $('#showplatebtn').show();
    $('#newdeliv').append('<tr><td width="180">'+products1+'</td><td width="180">'+assembprod1+'</td><td width="180">'+dates+'</td><td width="180">'+pcs+'</td><td width="180">'+scrap+'</td></tr>');
		$('#sndtodel'+q).remove();
	}
	}
	function changeprodass(n1){
		document.getElementById('selectp'+n1+'').selectedIndex = 0;
	}
	function changeprods(n1){
		document.getElementById('assemble_pr'+n1+'').selectedIndex = 0;
	}
		function changeprodassc(n1,a){
		document.getElementById('selectpc'+n1+'').selectedIndex = 0;
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectpc'+n1).children("option:selected").val();

		var assembprod =	 $('#assemble_prc'+n1).children("option:selected").val();
		$.ajax({
			url : $('body').attr('data-base-url') + 'order/findinventory', 
			method : 'post',  
		   data : {id:id,product:product,assembprod:assembprod,status:a}  
		}).done(function(data) {
			if(data==''){
				data=0;
			}
			console.log(data);
			$('#inv_blnk'+n1).val(data);

		});
	}
	function changeprodsc(n1,a){
		document.getElementById('assemble_prc'+n1+'').selectedIndex = 0;
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectpc'+n1).children("option:selected").val();

		var assembprod =	 $('#assemble_prc'+n1).children("option:selected").val();
		$.ajax({
			url : $('body').attr('data-base-url') + 'order/findinventory', 
			method : 'post',  
		   data : {id:id,product:product,assembprod:assembprod,status:a}  
		}).done(function(data) {
			if(data==''){
				data=0;
			}
			console.log(data);
			$('#inv_blnk'+n1).val(data);
		});
	}
	







	function addblanki(q,w){
		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+q).children("option:selected").val();
		

		var assembprod =$('#assemble_pr'+q).children("option:selected").val();
		
		var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value
       	if(date!='' && pcs!=''){
		$.ajax({
			url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:w}
    }).done(function(data) {
		});
    $('#newblank').append('<tr><td></td><td></td><td>'+date+'</td><td>'+pcs+'</td><td></td><td>add to inventory</td></tr>');
		//$('#rows'+q).remove();
	}else
	{
		alert("please select date or enter pcs");
	}
	}
	function sndtonxt(e,r){

		var id ="<?php echo $orderData->order_id ?>";

		var product =	 $('#selectp'+e).children("option:selected").val();

		var assembprod =	 $('#assemble_pr'+e).children("option:selected").val();
		alert(product);
		alert(assembprod)
		var date = document.getElementById('blank_date'+e).value;
       	var pcs =document.getElementById("blank_pcs"+e).value
		

		$.ajax({
			url : $('body').attr('data-base-url') + 'order/senttostatus',     
      method: 'post', 
      data : {id:id,product:product,assembprod:assembprod,date:date,pcs:pcs,status:r},
       dataType: 'text'
    }).done(function(data) {
    	// alert(data);
    	console.log(data);
		});
    	$('#showw').show();
    $('#newblank').append('<tr><td></td><td></td><td>'+date+'</td><td>'+pcs+'</td><td>'+pcs+'</td><td>sent to plating</td></tr>');
       	 $('#rows'+e).remove();
	}
</script>

<script type="text/javascript">
		$(document).ready(function(){
		var i=1;

		$('#add1').click(function(){
			i++;
			$('#dynamic_field1').append('<tr id="row'+i+'"><td class="partnm" id="td'+i+'"></td><td class="assemble" id="tda'+i+'"></td><td><input type="number" onchange="changeWght('+i+')" id="prod_pcs'+i+'" required  name="prod_pcs'+i+'" class="form-control pcs" placeholder=""></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
			
			$('#selectproduct'+(i-1)+'').clone().attr('id', 'selectproduct'+i+'').attr('name', 'part_nm'+i+'').attr('onchange','changeAss('+i+')').appendTo($('#td'+i+''));
			$('#assemble_prod'+(i-1)+'').clone().attr('id', 'assemble_prod'+i+'').attr('name', 'assemble_prod'+i+'').attr('onchange','changepro('+i+')').appendTo($('#tda'+i+''));
			
			
			document.getElementById("number").value=i;
 		  $(function () {
		  $('#number').val(i);
		});
		});
	$(document).on('click', '.btn_remove', function(){             
	  var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
           i--;
      });
	});


	$(document).ready(function(){  
      
	  var k=$('#number').val();

      $('#edit').click(function(){  
	  
           k++;  
           $('#dynamic_field1').append('<tr id="row'+k+'"><td class="partnm" id="td'+k+'"></td><td class="assemble" id="tda'+k+'"></td><td><input type="number" id="prod_pcs'+k+'" required name="prod_pcs'+k+'" class="form-control pcs" placeholder=""></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>');
		   
		    $('#selectproduct'+(k-1)+'').clone().attr('id', 'selectproduct'+k+'').attr('name', 'part_nm'+k+'').attr('onchange','changeAss('+k+')').appendTo($('#td'+k+''));
		     $('#assemble_prod'+(k-1)+'').clone().attr('id', 'assemble_prod'+k+'').attr('name', 'assemble_prod'+k+'').attr('onchange','changepro('+k+')').appendTo($('#tda'+k+''));
		      
		    
			document.getElementById('selectproduct'+k+'').selectedIndex = 0;
			document.getElementById('assemble_prod'+k+'').selectedIndex = 0;
			// document.getElementById('raw_name'+k+'').selectedIndex = 0;
			document.getElementById("number").value=k;
 		  $(function () {
		  $('#number').val(k);
		  
		});
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           k--; 
      }); 
	  
	  
 });  
</script>
<script type="text/javascript">
	

</script>

 <script type="text/javascript">
	$(document).ready(function(){
	
			
		$('#blanking').hide();
		$('#plating').hide();
		$('#packing').hide();
		
		$('#order_status').change(function(){
			var status =	 $(this).children("option:selected").val();
			//alert(status);
		if(status=='Plating'){
			$('#blanking').show();
		}else if(status=='Packing'){
			$('#plating').show();
			$('#blanking').show();
		}else if(status=='Finished Goods'){
			$('#packing').show();
			$('#plating').show();
			$('#blanking').show();
		}
		});

});


       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

       function changeAss(n1){
       
       			document.getElementById('assemble_prod'+n1+'').selectedIndex = 0;
       			//document.getElementById('prodwght'+n1+'').value = 0;
       			//document.getElementById('prod_pcs'+n1+'').value = 0;
       }
       function changepro(n1){
     			//document.getElementById('prodwght'+n1+'').value = 0;
       			//document.getElementById('prod_pcs'+n1+'').value = 0;
       			document.getElementById('selectproduct'+n1+'').selectedIndex = 0;
       }
       function changeWght(n1){
      		
      	var partnm = document.getElementById('selectproduct'+n1).value;
       		var assemble_prod = document.getElementById('assemble_prod'+n1).value;
       		var prodweight = document.getElementById('prod_pcs'+n1).value;
       		var unit = document.getElementById('unit1'+n1).value;
       		if(partnm!=''){

           $.ajax({
      url : $('body').attr('data-base-url') + 'order/get_wght',     
      method: 'post', 
      data : {id:partnm,prodweight:prodweight,unit:unit}
    }).done(function(data) { 
        console.log(data);

        $('#prodwght'+n1).val(data);
    });
	}else if(assemble_prod!=''){
			$.ajax({
      url : $('body').attr('data-base-url') + 'order/get_wght_ass',     
      method: 'post', 
      data : {id:assemble_prod,prodweight:prodweight,unit:unit}
    }).done(function(data) { 
        console.log(data);
			 $('#prodwght'+n1).val(data);

    });
	}
       	

       }
       function changePcs(n1){
       	// alert(n1);
       		var partnm = document.getElementById('selectproduct'+n1).value;
       		var assemble_prod = document.getElementById('assemble_prod'+n1).value;
       		var prodweight = document.getElementById('prodwght'+n1).value;
       		var unit = document.getElementById('unit1'+n1).value;
       		if(partnm!=''){

           $.ajax({
      url : $('body').attr('data-base-url') + 'order/get_pcs',     
      method: 'post', 
      data : {id:partnm,prodweight:prodweight,unit:unit}
    }).done(function(data) { 
        console.log(data);

        $('#prod_pcs'+n1).val(data);
    });
	}else if(assemble_prod!=''){
			$.ajax({
      url : $('body').attr('data-base-url') + 'order/get_pcs_ass',     
      method: 'post', 
      data : {id:assemble_prod,prodweight:prodweight,unit:unit}
    }).done(function(data) { 
        console.log(data);
			 $('#prod_pcs'+n1).val(data);

    });
	}
       	// document.getElementById('prod_pcs'+n1+'').value='';
       }

       //-->
       function blankused(){
       	//alert(1);
       var blank_scrap = document.getElementById('blank_scrap').value;
       var id = document.getElementById('order_id').value;
       //alert(id);
              $.ajax({
       	url : $('body').attr('data-base-url') + 'order/get_blank_used',
       	method : 'post', 
       	data :{blank_scrap:blank_scrap,id:id}
       }).done(function(data){
       	console.log(data);
       	$('#blank_used').val(data);
       });

       }
       function packingused(){
       	var pack_scrap = document.getElementById('pack_scrap').value;
       	 var id = document.getElementById('order_id').value;
       $.ajax({
       	url : $('body').attr('data-base-url') + 'order/get_pack_used',
       	method : 'post', 
       	data :{pack_scrap:pack_scrap,id:id}
       }).done(function(data){
       	$('#pack_used').val(data);
       });
       }
       function platingused(){
       	var plate_scrap = document.getElementById('plate_scrap').value;
       	 var id = document.getElementById('order_id').value;
       $.ajax({
       	url : $('body').attr('data-base-url') + 'order/get_plat_used',
       	method : 'post', 
       	data :{plate_scrap:plate_scrap,id:id}
       }).done(function(data){
       	$('#plate_used').val(data);
       });
       }
    </SCRIPT>
    