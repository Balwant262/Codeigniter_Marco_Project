<style type="text/css">
     select {
        /*width: 160px;*/
        /*margin: 10px;*/
    }
        td {
        	padding: 5px;
        }
    
    .top9{
    	/*margin-top:9px;*/
    }


@media print {
input#hideme { 
display:block;
}
}
</style> 

    
          	<?php if($assembleData->assemble_id!=''){ ?>
		   	<h4 class="box-title" id="heading">Edit Assembly Product</h4>
		   	<?php }else{ ?>
		   	<h4 class="box-title" id="heading">Add Assembly Product</h4>
		 	<?php } ?>

<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'assemble/add'?>" method="post" >

			<input type="hidden" name="assemble_id" value="<?php echo $assembleData->assemble_id ?>" />
			<div class="box-form">
	<div class="row">

		<div class="col-md-6">
              <div class="form-group">
                <label for="">Part No:</label>
                <input type="text"  name="part_name" value="<?php echo $assembleData->part_name; ?>" class="form-control " placeholder="" required>
         	</div>
         </div>

         <div class="col-md-6">
              <div class="form-group">
                <label for="">Price:</label>
                <input type="number"  name="price" value="<?php echo $assembleData->price; ?>" class="form-control " placeholder=""  >
         	</div>
         </div>

          <div class="col-md-6">
              <div class="form-group">
                <label for="">Manufacturer code:</label>
                <input type="text" name="m_code" class="form-control" value="<?php echo $assembleData->m_code; ?>">
         	</div>
         </div>

              <div class="col-md-6">
              <div class="form-group">
                <label for="">Video:</label>
                <input type="file" name="video" class="form-control" value="" accept='video/*'>
                <input type="hidden" name="oldvideo" value="<?php echo $assembleData->video ?>">
                <?php if($assembleData->video!=''){ ?>
                <a href="<?=base_url()?>/assets/images/<?php echo $assembleData->video; ?>" target="_blank">Watch Video</a>
            	<?php } ?>
         	</div>
         </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Unit:</label>
               <select name="unit" class="form-control" >
			<option value="">Select</option>
			<option value="Pcs"<?php if($assembleData->unit='Pcs'){ echo "selected";} ?>>Pcs</option>
			<option value="Set" <?php if($assembleData->unit='Set'){ echo "selected";} ?> >Set</option>
			<option value="Roll"<?php if($assembleData->unit='Roll'){ echo "selected";}?> >Roll</option></select>
         	</div>
         </div>

           <div class="col-md-6">
              <div class="form-group">
                <label for="">Profile Pic:</label>
                <input type="file" name="profile_pic" class="form-control" value="" accept="image/x-png,image/gif,image/jpeg" >
                <input type="hidden" name="oldpic" value="<?php echo $assembleData->profile_pic ?>">
                <?php if($assembleData->profile_pic!=''){ ?>
                <a href="<?=base_url()?>/assets/images/<?php echo $assembleData->profile_pic; ?>" target="_blank">See Profile Pic</a>
            	<?php } ?>
         	</div>
         </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Supplier:</label>
                <select name="supplier_id" class="form-control">
			<option value="">Select</option>
			<?php foreach($supplierData as $supplier){ ?>
			<option value="<?php echo $supplier->supplier_id; ?>" <?php if(($assembleData->supplier_id) == ($supplier->supplier_id)){ echo "selected"; } ?>><?php echo $supplier->supplier_name; ?></option>
			<?php } ?>
			</select>
         	</div>
         </div>

			</div>
		</div>
		
		 <div class="box-form2">
		   <!-- <div class=" box-form" style=""><h5>Assembly Details</h5></div>  -->
	<div class="row">
	
	<div class="col-md-12">
			<div class="form-group">  

                          <div class="table-responsive">  
                               <table class="table table-bordered" id="dynamic_field1">  
                               	<tr>
				<th style="width:200px">Parts</th>
				
				<th style="width:80px" >Pieces</th>
				
				

				
				<th style="width:100px"></th>
			</tr>
                               		<?php 
                               		
								if($assembleData->assemble_id!=''){  
								
						 $j=1; 
						
						  
						   foreach ($assemble_followupData as $object) { 	
						  
						  ?>
				
			<tr  id="row" class="">
				<td width="150px"><select name="product_name<?php echo $j; ?>"  class="form-control selecting" id="selectproduct<?php echo $j; ?>" required>
			<option value="">Select</option>
			


			<?php foreach($productsData as $products){ ?>
			<option value="<?php echo $products->product_id; ?>"  <?php if(($object->product_name) == ($products->product_id)){ echo "selected"; } ?>    ><?php echo $products->part_no; ?></option>
			<?php } ?>
			</select></td>
			
				<td style="width:80px"><input  type="text"  onkeypress="return isNumberKey(event)" class="top9 form-control" name="product_wght<?php echo $j ?>" value="<?php echo $object->product_wght ?>"  /></td>
				 <?php  $j++; } 
				if($assembleData->assemble_id){
				 ?>

				<input type="hidden" name="number" id="number" value="<?php echo $j-1 ?>">
				<?php } else { ?>
				<input type="hidden" name="number" id="number" value="1">
				<?php } ?>
				
				<td><button type="button" name="edit" id="edit" class="btn btn-success">Add More</button></td> 
				
				
				</tr>
				
				<?php }else{ ?>	
				




				<tr id="row">
						<td><select name="product_name1"   class="form-control" id="selectproduct1" required>
				<option value="">Select</option>

				<?php foreach($productsData as $products){ ?>
				<option value="<?php echo $products->product_id; ?>"  <?php if(($object->product_name) == ($products->product_id)){ echo "selected"; } ?>    ><?php echo $products->part_no; ?></option>
				<?php } ?>
			
				</select></td>
			
				
				<td><input type="text"  onkeypress="return isNumberKey(event)" class="form-control top9" name="product_wght1" value="" /></td>
			
				<input type="hidden" name="number" id="number" value="1">
			
						  	<td><button type="button" name="add1" id="add1" class="btn btn-success">Add More</button></td>
						  	
						  	 <?php } ?>

				</tr>  
</div>

		</table>

		
	</div>
	
</div>
</div>
</div>
</div>


<div class="box-form2">
	<div class="row">
	
	<div class="col-md-12">
			<div class="form-group">  

          <div class="table-responsive">  
       <table class="table table-bordered" id="dynamic_field3" style="width: 100%">  
       	<tr>
				<th style="width:24%">Make</th>
				<th style="width:24%">Model</th>
				<th style="width:3%">
					</th>
			</tr>

			<?php 
			if($assembleData->assemble_id!=''){  $j=1; 
				 $makemodelData = $this->Assemble_model->get_data_by('assemble_makemodel',$assembleData->assemble_id ,'assemble_id');
					foreach ($makemodelData as $object) { 	 ?>

			<tr id="rowmm<?php echo $j ?>">
				<td>
				<select name="make_id<?php echo $j ?>"   class="form-control" id="make_id<?php echo $j ?>" onchange="getModels(<?php echo $j; ?>)">
				<option value="">Select</option>
				<?php foreach($makeData as $make){ ?>
				<option value="<?php echo $make->make_id; ?>" <?php if(($object->make_id) == ($make->make_id)){ echo "selected"; } ?> ><?php echo $make->make_name; ?></option>
				<?php } ?>
			
				</select>
				
				</td>

				<td>
				<select name="model_id<?php echo $j ?>"   class="form-control" id="model_id<?php echo $j ?>">
				<option value="">Select</option>
				<?php foreach($modelData as $model){ ?>
				<option value="<?php echo $model->model_id; ?>" <?php if(($object->model_id) == ($model->model_id)){ echo "selected"; } ?> ><?php echo $model->model_name; ?></option>
				<?php } ?>
			
				</select>
				
				</td>
				<td><button type="button" id="<?php echo $j ?>" class="btn btn-danger btn_remove">X</button></td>
			</tr>


			<?php $j++; } ?> 
			<tr id="rowmm<?php echo $j ?>">
				<td>
				<select name="make_id<?php echo $j ?>"   class="form-control" id="make_id<?php echo $j ?>" onchange="getModels(<?php echo $j; ?>)">
				<option value="">Select</option>
				<?php foreach($makeData as $make){ ?>
				<option value="<?php echo $make->make_id; ?>"  ><?php echo $make->make_name; ?></option>
				<?php } ?>
			
				</select>
				
				</td>

				<td>
				<select name="model_id<?php echo $j ?>"   class="form-control" id="model_id<?php echo $j ?>">
				<option value="">Select</option>
				
				</select>
				
				</td>
				<td>
					<button type="button" id="editmm" class="btn btn-success">Add More</button>
					<input type="hidden" name="numbermm1" id="numbermm1" value="<?php echo $j;?>">
				</td>
			</tr>


		<?php }else{ ?> 
			<tr id="rowmm1">
				<td>
				<select name="make_id1"   class="form-control" id="make_id1" onchange="getModels(1)">
				<option value="">Select</option>
				<?php foreach($makeData as $make){ ?>
				<option value="<?php echo $make->make_id; ?>" ><?php echo $make->make_name; ?></option>
				<?php } ?>
			
				</select>
				</td>

				<td>
				<select name="model_id1"   class="form-control" id="model_id1">
				<option value="">Select</option>

			
				</select>
				</td>

				<td>
					<button type="button" id="addmm" class="btn btn-success">Add More</button>
					<input type="hidden" name="numbermm" id="numbermm" value="1">
				</td>
			</tr>
		<?php } ?>
		

       </table>
   </div>
</div>
</div>
</div>
</div>
		




<div class="box-form2">
	<div class="row">
	
	<div class="col-md-12">
			<div class="form-group">  

          <div class="table-responsive">  
       <table class="table table-bordered" id="dynamic_field" style="width: 74%">  
       	<tr>
				<th style="width:64%">Tags</th>
				<th style="width:70px">
					</th>
			</tr>

			<?php 
			if($assembleData->assemble_id!=''){  $k=1; 
				 $assemble_tagsData = $this->Assemble_model->get_data_by('asseble_product_tags',$assembleData->assemble_id,'assemble_id');
					foreach ($assemble_tagsData as $object) { 	 ?>

			<tr id="row_t<?php echo $k ?>">
				<td>
				<select name="tag_id<?php echo $k ?>"   class="form-control" id="tag_id<?php echo $k ?>">
				<option value="">Select</option>
				<?php foreach($tagsData as $tags){ ?>
				<option value="<?php echo $tags->tag_id; ?>" <?php if(($object->tag_id) == ($tags->tag_id)){ echo "selected"; } ?> ><?php echo $tags->tag_name; ?></option>
				<?php } ?>
			
				</select>
				
				</td>
				<td><button type="button" name="remove" id="<?php echo $k ?>" class="btn btn-danger btn_remove1">X</button></td>
			</tr>


			<?php $k++; } ?> 
			<tr id="row_t<?php echo $k ?>">
				<td>
				<select name="tag_id<?php echo $k ?>"   class="form-control" id="tag_id<?php echo $k ?>">
				<option value="">Select</option>
				<?php foreach($tagsData as $tags){ ?>
				<option value="<?php echo $tags->tag_id; ?>" ><?php echo $tags->tag_name; ?></option>
				<?php } ?>
			
				</select>
				</td>
				<td>
					<button type="button" id="edit_t" class="btn btn-success">Add More</button>
					<input type="hidden" name="number_t1" id="number_t1" value="<?php echo $k; ?>">
				</td>
			</tr>


		<?php }else{ ?> 
			<tr id="row_t1">
				<td>
				<select name="tag_id1"   class="form-control" id="tag_id1">
				<option value="">Select</option>
				<?php foreach($tagsData as $tags){ ?>
				<option value="<?php echo $tags->tag_id; ?>" ><?php echo $tags->tag_name; ?></option>
				<?php } ?>
			
				</select>
				</td>
				<td>
					<button type="button" id="add_t" class="btn btn-success">Add More</button>
					<input type="hidden" name="number_t" id="number_t" value="1">
				</td>
			</tr>
		<?php } ?>
		

       </table>
   </div>
</div>
</div>
</div>
</div>

<div class="box-form2">
	<div class="row">
	
	<div class="col-md-12">
			<div class="form-group">  

          <div class="table-responsive">  
       <table class="table table-bordered" id="dynamic_field2" style="width: 74%">  
       	<tr>
				<th style="width:64%">Pictures</th>
				<th style="width:170px">
					</th>
					<th style="width:50px"></th>
			</tr>

			<?php 
			if($assembleData->assemble_id!=''){  $m=1; 
				 $assemble_picData = $this->Assemble_model->get_data_by('assemble_media',$assembleData->assemble_id ,'assemble_id');
					foreach ($assemble_picData as $object) { 	 ?>

			<tr id="rowm<?php echo $m ?>">
				<td>
				<input type="file" name="media<?php echo $m; ?>" class="form-control" accept='image/*'>
				<input type="hidden" name="old_media<?php echo $m; ?>" value="<?php echo $object->media; ?>">
				<input type="hidden" name="media_id<?php echo $m; ?>" value="<?php echo $object->id; ?>">
				</td>
				<td>
				<a href="<?=base_url()?>/assets/images/<?php echo $object->media; ?>" target="_blank"><img src="<?=base_url()?>/assets/images/<?php echo $object->media; ?>" style="width:130px"></a>
				</td>
				<td><button type="button"  id="<?php echo $m; ?>" class="btn btn-danger btn_remove2">X</button></td>
			</tr>


			<?php $m++; } ?> 
			<tr id="rowm<?php echo $m ?>">
				<td>
				<input type="file" name="media<?php echo $m; ?>" class="form-control" accept='image/*'>
				</td>
				<td>
					<button type="button" id="editm" class="btn btn-success">Add More</button>
					<input type="hidden" name="numberm1" id="numberm1" value="<?php echo $m;?>">
				</td>
			</tr>


		<?php }else{ ?> 
			<tr id="rowm1">
				<td>
				<input type="file" name="media1" class="form-control" accept='image/*'>
				</td>
				<td>
					<button type="button" id="addm" class="btn btn-success">Add More</button>
					<input type="hidden" name="numberm" id="numberm" value="1">
				</td>
			</tr>
		<?php } ?>
		

       </table>
   </div>
</div>
</div>
</div>
</div>


		<div> <button type="submit" class="btn-sm  btn btn-success "  name="submit" value="submit">Submit </button>
		
		</div>
      </div>
      
</div>
</form>
</div>
</div>
</div>


<script>
	$(document).ready(function(){
		var i=1;

		$('#add1').click(function(){
			i++;
			$('#dynamic_field1').append('<tr id="row'+i+'"><td id="td'+i+'"></td><td><input type="text"  onkeypress="return isNumberKey(event)" class="top9 form-control" name="product_wght'+i+'"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>')
			
			$('#selectproduct'+(i-1)+'').clone().attr('id', 'selectproduct'+i+'').attr('required','required').attr('name', 'product_name'+i+'').appendTo($('#td'+i+''));
			
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
           $('#dynamic_field1').append('<tr id="row'+k+'"><td id="td'+k+'"></td><td><input type="text"  onkeypress="return isNumberKey(event)" class="top9  form-control" name="product_wght'+k+'"/></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>')
		   
		    $('#selectproduct'+(k-1)+'').clone().attr('id', 'selectproduct'+k+'').attr('required','required').attr('name', 'product_name'+k+'').appendTo($('#td'+k+''));
		   
			document.getElementById('selectproduct'+k+'').selectedIndex = 0;
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
	  
	  

      var i=1;
		$('#add_t').click(function(){
			i++;
			$('#dynamic_field').append('<tr id="row'+i+'"><td id="td_t'+i+'"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');

			$('#tag_id1').clone().attr('id', 'tag_id'+i+'').attr('name', 'tag_id'+i+'').appendTo($('#td_t'+i+''));

		});

		$(function () {
		  $('#number_t').val(i);
		});





		var m=$('#number_t1').val();

      $('#edit_t').click(function(){  
	  
           m++;  
           $('#dynamic_field').append('<tr id="row_t'+m+'"><td id="td_t'+m+'"></td><td><button type="button" name="remove" id="'+m+'" class="btn btn-danger btn_remove1">X</button></td></tr>')
		   
		    $('#tag_id1').clone().attr('id', 'tag_id'+m+'').attr('name', 'tag_id'+m+'').appendTo($('#td_t'+m+''));
 		  $(function () {
		  $('#number_t1').val(m);
		  
		});
      });  
      $(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#row_t'+button_id+'').remove();
      }); 


      var m=1;
		$('#addm').click(function(){
			m++;
			$('#dynamic_field2').append('<tr id="rowm'+m+'"><td ><input type="file" name="media'+m+'" class="form-control" value=""></td><td><button type="button"  id="'+m+'" class="btn btn-danger btn_remove1">X</button></td></tr>');


		});

		$(function () {
		  $('#numberm').val(m);
		});

		$(document).on('click', '.btn_remove2', function(){  
           var button_id = $(this).attr("id");   
           $('#rowm'+button_id+'').remove();
      	});


		var n=$('#numberm1').val();
		$('#editm').click(function(){
			n++;
			$('#dynamic_field2').append('<tr id="rowm'+n+'"><td ><input type="file" name="media'+n+'" class="form-control" value=""></td><td><button type="button"  id="'+n+'" class="btn btn-danger btn_remove1">X</button></td></tr>');
		});

		$(function () {
		  $('#numberm1').val(n);
		});


		var mm=1;
		$('#addmm').click(function(){
			mm++;
			$('#dynamic_field3').append('<tr id="rowmm'+mm+'"><td>				<select name="make_id'+mm+'"   class="form-control" id="make_id'+mm+'" onchange="getModels('+mm+')">				<option value="">Select</option>				<?php foreach($makeData as $make){ ?>
				<option value="<?php echo $make->make_id; ?>" ><?php echo $make->make_name; ?></option>				<?php } ?>
							</select>				</td>				<td>				<select name="model_id'+mm+'"   class="form-control" id="model_id'+mm+'">				<option value="">Select</option>				</select>				</td><td><button type="button"  id="'+mm+'" class="btn btn-danger btn_removemm">X</button></td></tr>');

			
		});

		$(function () {
		  $('#numbermm').val(i);
		});

		$(document).on('click', '.btn_removemm', function(){  
           var button_id = $(this).attr("id");   
           $('#rowmm'+button_id+'').remove();
      }); 


		var mm1=$('#numbermm1').val();
		$('#editmm').click(function(){
		

			mm1++;
			$('#dynamic_field3').append('<tr id="rowmm'+mm1+'"><td>				<select name="make_id'+mm1+'"   class="form-control" id="make_id'+mm1+'" onchange="getModels('+mm1+')">				<option value="">Select</option>				<?php foreach($makeData as $make){ ?>
				<option value="<?php echo $make->make_id; ?>" ><?php echo $make->make_name; ?></option>				<?php } ?>
							</select>				</td>				<td>				<select name="model_id'+mm1+'"   class="form-control" id="model_id'+mm1+'">				<option value="">Select</option>				</select>				</td><td><button type="button"  id="'+mm1+'" class="btn btn-danger btn_removemm">X</button></td></tr>');

			
		});

		$(function () {
		  $('#numbermm1').val(mm1);
		});



 });  
</script>
<SCRIPT language=Javascript>
       <!--
       function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

       function getModels(n){
           var make_id = $('#make_id'+n).val();

            $.ajax({
                url:'<?php echo base_url();?>assemble/getModels',
                method: 'post',
                data: {make_id: make_id},
                dataType: 'json',
                success: function(response){
                   // console.log(data);
                    
                     $('#model_id'+n).find('option').not(':first').remove();

          // Add options
          			$.each(response,function(index,data){
             		$('#model_id'+n).append('<option value="'+data['model_id']+'">'+data['model_name']+'</option>');
          			});
                }
             });


        }

       //-->
    </SCRIPT>