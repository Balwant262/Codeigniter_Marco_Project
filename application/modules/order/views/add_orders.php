<style type="text/css">
	td{
		padding: 5px;
	}
	.borderpad{
		border:1px solid lightgrey;
		margin:10px auto ;
	}
	.modal-dialog .popup{
		width:960px !important	;
	}
</style>
<?php  $id= $this->Order_model->getlastid(); 
?>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'order/add'?>" method="post">
<!-- <h3>Add rawmaterial Details</h3> -->
			<input type="hidden" id="order_id" name="order_id" value="<?php echo $orderData->order_id ?>" />
				<table><tr>
					<td width="150px">Client Name<sup>*</sup>  &nbsp; </td>
			<td width='150px'><select name="client" class="form-control " required>
				<option value=""> Select </option>
				<?php


				foreach ($userdatas as $key => $usere) { 
					if($usere->name!='admin'){?>

					<option value="<?php echo $usere->client_id; ?>"  <?php if(($orderData->client) == ($usere->client_id)){ echo "selected"; } ?>    ><?php echo $usere->client_name; ?></option>
				<?php } }
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
			<td colspan="3"><br><b>Please Select Products Or Assembly Products<br></b></td>
		</tr>
			 </table>
	
			<div class="box-form2">
				<div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field1">  
                               	<tr>
				<th style="width:100px">Products</th>
				
				<th style="width:80px" >Assembly Products</th>
				<th style="width:80px" >Pcs</th>
				
				
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
					
			
				<td style="width: 80px">
					<input type="number" id="prod_pcs1" onchange="changeWght(1)" name="prod_pcs1" value="" class="form-control pcs" placeholder="" required>
				</td>
				
			
				<input type="hidden" name="number" id="number" value="1">
			
						  	<td><button type="button" name="add1" id="add1" class="btn btn-success">Add More</button></td>
						  	
						  	 <?php } ?>

				</tr>  
</div>












			<table id="example1" >
			
			
<?php 
	
			if($orderData->order_id !=''){
				 $followcount=count($order_follow_up);
				 	for ($i=1; $i <=$followcount ; $i++) {?> 
				<table>
					<tr> 	
						<td> <?php  echo $this->Order_model->getassproductname($order_follow_up[$i]->assemble_prod);
							echo $this->Order_model->getproductname($order_follow_up[$i]->part_nm);?> </td> 
			
			<td width="150"> <button type="button" id="addblank<?php echo $i; ?>" name="addblank<?php echo $i; ?>" class="btn btn-success">Add Blanking</button></td>

			</tr>
			<table class="borderpad" id="blank<?php echo $i; ?>">
				
			<thead  id="newblank"><tr> <td>Blanking </td></tr>
				<tr id="showw" style="display: none"> 
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Comments </td>
				</tr>
			 </thead></table>
		<table class="borderpad" id="plate">
		<thead  id="newplating"><tr> <td>Plating </td></tr>
				<tr id="showws" style="display: none"> 
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Comments </td>
				</tr>
			 </thead>		
			<input type="hidden" name="platingid" id="platingid" value="1"></table>
		<table class="borderpad" id="pak">
			<thead  id="newpacking"><tr> <td>packing </td></tr>
				<tr id="showwspac" style="display: none"> 
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Comments </td>
				</tr>
			 </thead>	
		<input type="hidden" name="packingid" id="packingid" value="1">
		
	</table>
		<table class="borderpad" id="fins">
		<thead  id="newfinished"><tr> <td>Finished Goods </td></tr>
				<tr id="showwsfin" style="display: none"> 
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Comments </td>
				</tr>
			 </thead>
			 <input type="hidden" name="finishid" id="finishid" value="1">	
		
	</table>
		<table class="borderpad" id="del">
		<thead  id="newdelive"><tr> <td>Delivery </td></tr>
				<tr id="shodeliv" style="display: none"> 
					<td width="180">Date</td>
					<td width="180">Pieces </td>
					<td width="180"> Comments </td>
				</tr>
			 </thead>
			 <input type="hidden" name="delivid" id="delivid" value="1">	
	</table>


		<?php echo "<br>"; } } else { ?>
			<tr>
			<td width="150">Order Status<sup>*</sup>  &nbsp;</td>
			
			<td width="160">
				<select name="order_status" id="" class="form-control" >

				
				<option value="Booked" selected>Booked</option>
				
			</select>
		</td>
	</tr>
		<?php  } ?>
		
		
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
           $('#dynamic_field1').append('<tr id="row'+k+'"><td class="partnm" id="td'+k+'"></td><td class="assemble" id="tda'+k+'"></td><td><input type="number" onchange="changeWght('+k+')" id="prod_pcs'+k+'" required name="prod_pcs'+k+'" class="form-control pcs" placeholder=""></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>');
		   
		    $('#selectproduct'+(k-1)+'').clone().attr('id', 'selectproduct'+k+'').attr('name', 'part_nm'+k+'').attr('onchange','changeAss('+k+')').appendTo($('#td'+k+''));
		     $('#assemble_prod'+(k-1)+'').clone().attr('id', 'assemble_prod'+k+'').attr('name', 'assemble_prod'+k+'').attr('onchange','changepro('+k+')').appendTo($('#tda'+k+''));
		      
		    
			document.getElementById('selectproduct'+k+'').selectedIndex = 0;
			document.getElementById('assemble_prod'+k+'').selectedIndex = 0;
			
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
	$(document).ready(function(){
		var b=1;
		$('#addblank'+b).click(function(){

			
			$('#blank'+b).append('<tr id="rows'+b+'"><td width="150">Date</td><td width="160"><input type="date" name="blank_date'+b+'" id="blank_date'+b+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="blank_pcs'+b+'"  name="blank_pcs'+b+'" class="form-control " placeholder=""></td><td> <button onclick="addblanki('+b+',1)" type="button" class="btn btn-success">Add to Inventory</button></td><td> <button type="button" onclick="sndtonxt('+b+',1)" class="btn btn-success">Send to Plating </button></td></tr>');
			b++;
		});
		
	});
	 function addblanki(q,w){     	 
      	if(w==1){
      	var date = document.getElementById('blank_date'+q).value;
       	var pcs =document.getElementById("blank_pcs"+q).value;
      		$('#showw').show();
      		
       	 $('#newblank').append('<tr><td>'+date+'</td><td>'+pcs+'</td><td>added to Inventory</td></tr>');
       	 $('#rows'+q).remove();
      	}else if(w==2){
      	var date = document.getElementById('plate_date'+q).value;
       	var pcs =document.getElementById("plate_pcs"+q).value;
      		$('#showws').show();
      	
       	 $('#newplating').append('<tr><td>'+date+'</td><td>'+pcs+'</td><td>added to Inventory</td></tr>');
       	 	$('#showws'+q).remove();
      	}
      	else if(w==3){
      	var date = document.getElementById('pack_date'+q).value;
       	var pcs =document.getElementById("pack_pcs"+q).value;
      		$('#showwspac').show();
      		
       	 $('#newpacking').append('<tr><td>'+date+'</td><td>'+pcs+'</td><td>added to Inventory</td></tr>');
       	 $('#showws2'+q).remove();
      	}
      	else if(w==4){
      	var date = document.getElementById('fin_date'+q).value;
       	var pcs =document.getElementById("fin_pcs"+q).value;
      		$('#showwsfin').show();
      		
       	 $('#newfinished').append('<tr><td>'+date+'</td><td>'+pcs+'</td><td>added to Inventory</td></tr>');
       	 $('#showwsfin'+q).remove();
      	}else if(w==5){
      	var date = document.getElementById('deliv_date'+q).value;
       	var pcs =document.getElementById("deliv_pcs"+q).value;
      		$('#shodeliv').show();
      		
       	 $('#newdelive').append('<tr><td>'+date+'</td><td>'+pcs+'</td><td>added to Inventory</td></tr>');
       	 $('#rowsdeli'+q).remove();
      	}

     
   }
   function sndtonxt(e,r){
   	if(r==1){
     var dates = document.getElementById('blank_date'+e).value;
     var pcsi =document.getElementById("blank_pcs"+e).value;
     var plateid =document.getElementById("platingid").value;
      		$('#showw').show();
       	 $('#newblank').append('<tr><td>'+dates+'</td><td>'+pcsi+'</td><td>Sended to Plating</td></tr>');
       	 // document.getElementById('plate_date'+plateid).value=dates;
       	 // document.getElementById('plate_pcs'+plateid).value=pcsi;
       	 document.getElementById("platingid").value=plateid+1;
       	 $('#plate').append('<tr id="showws'+(plateid)+'"><td width="150">Date</td><td width="160"><input type="date" name="plate_date'+(plateid)+'" id="plate_date'+(plateid)+'" value="'+dates+'" class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="plate_pcs'+(plateid)+'" value="'+pcsi+'" name="plate_pcs'+(plateid)+'" class="form-control " placeholder=""></td><td> <button onclick="addblanki('+(plateid)+',2)" type="button" class="btn btn-success">Add to Inventory</button></td><td> <button type="button" onclick="sndtonxt('+(plateid)+',2)" class="btn btn-success">Send to packing </button></td></tr>');
		


       	 $('#rows'+e).remove();
      	}else if(r==2){
     var dates = document.getElementById('plate_date'+e).value;
     var pcsi =document.getElementById("plate_pcs"+e).value;
     var plateid =document.getElementById("packingid").value;
      		$('#showws').show();
       	 $('#newplating').append('<tr><td>'+dates+'</td><td>'+pcsi+'</td><td>Sended to packing</td></tr>');
       	 // document.getElementById('pack_date'+plateid).value=dates;
       	 // document.getElementById('pack_pcs'+plateid).value=pcsi;
       	 document.getElementById("packingid").value=plateid+1;
       	  $('#pak').append('<tr id="showws2'+(plateid)+'"><td width="150">Date</td><td width="160"><input type="date" value="'+dates+'" name="pack_date'+(plateid)+'" id="pack_date'+(plateid)+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" id="pack_pcs'+(plateid)+'" value="'+pcsi+'" name="pack_pcs'+(plateid)+'" class="form-control " placeholder=""></td><td> <button onclick="addblanki('+(plateid)+',3)" type="button" class="btn btn-success">Add to Inventory</button></td><td> <button type="button" onclick="sndtonxt('+(plateid)+',3)" class="btn btn-success">Send to packing </button></td></tr>');
		
       	 $('#showws'+e).remove();
      	}
      	else if(r==3){
     var dates = document.getElementById('pack_date'+e).value;
     var pcsi =document.getElementById("pack_pcs"+e).value;
     var plateid =document.getElementById("finishid").value;
      		$('#showwspac').show();
       	 $('#newpacking').append('<tr><td>'+dates+'</td><td>'+pcsi+'</td><td>Sended to Finished Goods</td></tr>');
       	 // document.getElementById('fin_date'+plateid).value=dates;
       	 // document.getElementById('fin_pcs'+plateid).value=pcsi;
       	 document.getElementById("finishid").value=plateid+1;
       	  $('#fins').append('<tr id="showwsfin'+(plateid)+'"><td width="150">Date</td><td width="160"><input type="date" value="'+dates+'" name="fin_date'+(plateid)+'" id="fin_date'+(plateid)+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" value="'+pcsi+'" id="fin_pcs'+(plateid)+'"  name="fin_pcs'+(plateid)+'" class="form-control " placeholder=""></td><td> <button onclick="addblanki('+(plateid)+',4)" type="button" class="btn btn-success">Add to Inventory</button></td><td> <button type="button" onclick="sndtonxt('+(plateid)+',4)" class="btn btn-success">Send to packing </button></td></tr>');
       	 $('#showws2'+e).remove();
      	}else if(r==4){
     var dates = document.getElementById('fin_date'+e).value;
     var pcsi =document.getElementById("fin_pcs"+e).value;
     var plateid =document.getElementById("delivid").value;
      		$('#showwsfin').show();
       	 $('#newfinished').append('<tr><td>'+dates+'</td><td>'+pcsi+'</td><td>Sended to Delivery</td></tr>');
       	 // document.getElementById('deliv_date'+plateid).value=dates;
       	 // document.getElementById('deliv_pcs'+plateid).value=pcsi;
       	 document.getElementById("delivid").value=plateid+1;
       	  $('#del').append('<tr id="rowsdeli'+(plateid)+'"><td width="150">Date</td><td width="160"><input type="date" value="'+dates+'" name="deliv_date'+(plateid)+'" id="deliv_date'+(plateid)+'"class="form-control " placeholder=""></td><td width="20"></td><td width="130"> Pieces</td><td width="160"><input type="text" value="'+pcsi+'" id="deliv_pcs'+(plateid)+'"  name="deliv_pcs'+(plateid)+'" class="form-control " placeholder=""></td><td> <button onclick="addblanki('+(plateid)+',5)" type="button" class="btn btn-success">Add to Inventory</button></td><td> </td></tr>');
       	 $('#showwsfin'+e).remove();
      	}
      	
   }

</script>
















 <script type="text/javascript">
	$(document).ready(function(){
		// $('#addsendpalting').click(function(){	

		// 	$("#blank").('<tr id="row">')
		// });
				
		// $('#blanking').hide();
		// $('#plating').hide();
		// $('#packing').hide();
		
		// $('#order_status').change(function(){
		// var status=$(this).children("option:selected").val();
		
		// if(status=='Plating'){
		// 	$('#blanking').show();
		// }else if(status=='Packing'){
		// 	$('#plating').show();
		// 	$('#blanking').show();
		// }else if(status=='Finished Goods'){
		// 	$('#packing').show();
		// 	$('#plating').show();
		// 	$('#blanking').show();
		// }
		// });

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
       	document.getElementById('prod_pcs'+n1+'').value = 0;
       }
       function changepro(n1){
       			document.getElementById('prod_pcs'+n1+'').value = 0;
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
    