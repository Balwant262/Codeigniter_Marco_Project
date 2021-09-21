<style>
	td{
		padding-top:5px;
	}
</style>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'products/add'?>" method="post">
	<?php if($productsData->product_id!=''){ ?>
	<h4>Edit Product Details</h4>
	<?php }else{ ?>
	<h4>Add Product Details</h4>
	<?php } ?>
			<input type="hidden" name="product_id" value="<?php echo $productsData->product_id ?>" />
<div class="box-form">
       
	<div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Category:</label>
                <select name="category" class="form-control">
			<option value="">Select</option>
			<?php foreach($categoryData as $category){ ?>
			<option value="<?php echo $category->category_id; ?>" <?php if(($productsData->category) == ($category->category_id)){ echo "selected"; } ?>><?php echo $category->category_name; ?></option>
			<?php } ?>
			</select>
         	</div>
         </div>
            
             <div class="col-md-4">
              <div class="form-group">
                <label for="">Equipment Type</label>
                <input type="text" name="equipment_type" class="form-control" value="<?php echo $productsData->equipment_type; ?>" placeholder="Equipment Type">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Item Description</label>
                <input type="text" name="item_description" class="form-control" value="<?php echo $productsData->item_description; ?>" placeholder="Item Description">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Alternate Description</label>
                <input type="text" name="alternate_description" class="form-control" value="<?php echo $productsData->alternate_description; ?>" placeholder="Alternate Description">
         	</div>
         </div>
            
             <div class="col-md-4">
              <div class="form-group">
                <label for="">Alternate Description2</label>
                <input type="text" name="alternate_description2" class="form-control" value="<?php echo $productsData->alternate_description2; ?>" placeholder="Alternate Description2">
         	</div>
         </div>
            
		<div class="col-md-4">
              <div class="form-group">
                <label for="">Oem / Maker Part No:</label>
                <input type="text"  name="part_no" value="<?php echo $productsData->part_no; ?>" class="form-control " placeholder="Oem / Maker Part No" required >
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Oem / Drawing No:</label>
                <input type="text"  name="oem_drawing_no" value="<?php echo $productsData->oem_drawing_no; ?>" class="form-control " placeholder="Oem / Drawing No" required >
         	</div>
         </div>

        
         <div class="col-md-4">
              <div class="form-group">
                <label for="">Manufacturer Code:</label>
                <input type="text" placeholder="Manufacturer Code" name="m_code" class="form-control" value="<?php echo $productsData->m_code; ?>">
         	</div>
         </div>
          <div class="col-md-4">
              <div class="form-group">
                <label for="">Marco Code:</label>
                <input type="text" placeholder="Marco Code" name="marco_code" class="form-control" value="<?php echo $productsData->marco_code; ?>">
         	</div>
         </div>

       
         <div class="col-md-4">
              <div class="form-group">
                <label for="">Vendor Details To Record:</label>
                <select name="suppliers[]" class="form-control" multiple>
			<option value="">Select</option>

			<?php 
			 $a = explode(',',$productsData->supplier_id);
			foreach($supplierData as $supplier){ ?>
			<option value="<?php echo $supplier->supplier_id; ?>" <?php if (in_array($supplier->supplier_id,$a)){ echo "selected"; } ?>><?php echo $supplier->supplier_name; ?></option>
			<?php } ?>
			</select>
         	</div>
         	
         </div>


         
          <div class="col-md-4">
              <div class="form-group">
                <label for="">Marco Price End-User:</label>
                <input type="number" placeholder="Marco Price End-User" name="marco_price_enduser" class="form-control" value="<?php echo $productsData->marco_price_enduser; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Marco Price Dealer:</label>
                <input type="number" placeholder="Marco Price Dealer" name="marco_price_dealer" class="form-control" value="<?php echo $productsData->marco_price_dealer; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Marco Price Wholesale:</label>
                <input type="number" placeholder="Marco Price Wholesale" name="marco_price_wholesale" class="form-control" value="<?php echo $productsData->marco_price_wholesale; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Marco Price Forexport:</label>
                <input type="number" placeholder="Marco Price Forexport" name="marco_price_forexport" class="form-control" value="<?php echo $productsData->marco_price_forexport; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Marco Price For Marine:</label>
                <input type="number" placeholder="Marco Price For Marine" name="marco_price_formarine" class="form-control" value="<?php echo $productsData->marco_price_formarine; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Original Maker Price:</label>
                <input type="number" placeholder="Original Maker Price" name="original_maker_price" class="form-control" value="<?php echo $productsData->original_maker_price; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Importer Ex-works Price:</label>
                <input type="number" placeholder="Importer Ex-works Price" name="importer_exworks_price" class="form-control" value="<?php echo $productsData->importer_exworks_price; ?>">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Importer Ex-works Price:</label>
                <input type="number" placeholder="Importer Ex-works Price" name="importer_exworks_price" class="form-control" value="<?php echo $productsData->importer_exworks_price; ?>">
         	</div>
         </div>
         

           <div class="col-md-4">
              <div class="form-group">
                <label for="">Drawing Upload:</label>
                <input type="file" name="profile_pic" class="form-control" value="" accept="image/x-png,image/gif,image/jpeg" >
                <input type="hidden" name="oldpic" value="<?php echo $productsData->profile_pic ?>">
                <?php if($productsData->profile_pic!=''){ ?>
                <a href="<?=base_url()?>/assets/images/<?php echo $productsData->profile_pic; ?>" target="_blank">See Profile Pic</a>
            	<?php } ?>
         	</div>
         </div>
            
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Material Of Construction Info Record:</label>
                <input type="text" name="material_of_construction_record" class="form-control" value="<?php echo $productsData->material_of_construction_record; ?>" placeholder="Material Of Construction Info Record">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Stock Position:</label>
                <input type="text" name="stock_postion" class="form-control" value="<?php echo $productsData->stock_postion; ?>" placeholder="Stock Position">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Qty In Hand:</label>
                <input type="number" name="qty_in_hand" class="form-control" value="<?php echo $productsData->qty_in_hand; ?>" placeholder="Qty In Hand">
         	</div>
         </div>
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Minimum Qty Reqd In Stock:</label>
                <input type="number" name="minimum_qty_reqd_in_stock" class="form-control" value="<?php echo $productsData->minimum_qty_reqd_in_stock; ?>" placeholder="Minimum Qty Reqd In Stock">
         	</div>
         </div>
            
<!--            <div class="col-md-4">
              <div class="form-group">
                <label for="">Competitor Insights For This Product:</label>
                <input type="number" name="competitor_insights_for_this_product" class="form-control" value="<?php echo $productsData->competitor_insights_for_this_product; ?>" placeholder="Competitor Insights For This Product">
         	</div>
         </div>-->
            
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Further Improvement Needed On Product:</label>
                <input type="text" name="further_improvement_needed_on_product" class="form-control" value="<?php echo $productsData->further_improvement_needed_on_product; ?>" placeholder="Further Improvement Needed On Product">
         	</div>
         </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Client Feedback For This Item:</label>
                <input type="text" name="client_feedback_for_this_item" class="form-control" value="<?php echo $productsData->client_feedback_for_this_item; ?>" placeholder="Client Feedback For This Item">
         	</div>
         </div>
            
            
            
            
         <div class="col-md-4">
              <div class="form-group">
                <label for="">Unit:</label>
               <select name="unit" class="form-control" >
			<option value="">Select</option>
			<option value="Pcs"<?php if($productsData->unit='Pcs'){ echo "selected";} ?>>Pcs</option>
			<option value="Set" <?php if($productsData->unit='Set'){ echo "selected";} ?> >Set</option>
			<option value="Roll"<?php if($productsData->unit='Roll'){ echo "selected";}?> >Roll</option></select>
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
			if($productsData->product_id!=''){  $j=1; 
				 $makemodelData = $this->Products_model->get_data_by('product_makemodel',$productsData->product_id ,'product_id');
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
       <table class="table table-bordered" id="dynamic_field" style="width: 71%">  
       	<tr>
				<th style="width:24%">Tags</th>
				<th style="width:3%">
					</th>
			</tr>

			<?php 
			if($productsData->product_id!=''){  $j=1; 
				 $product_tagsData = $this->Products_model->get_data_by('product_tags',$productsData->product_id ,'product_id');
					foreach ($product_tagsData as $object) { 	 ?>

			<tr id="row<?php echo $j ?>">
				<td>
				<select name="tag_id<?php echo $j ?>"   class="form-control" id="tag_id<?php echo $j ?>">
				<option value="">Select</option>
				<?php foreach($tagsData as $tags){ ?>
				<option value="<?php echo $tags->tag_id; ?>" <?php if(($object->tag_id) == ($tags->tag_id)){ echo "selected"; } ?> ><?php echo $tags->tag_name; ?></option>
				<?php } ?>
			
				</select>
				
				</td>
				<td><button type="button" id="<?php echo $j ?>" class="btn btn-danger btn_remove">X</button></td>
			</tr>


			<?php $j++; } ?> 
			<tr id="row<?php echo $j ?>">
				<td>
				<select name="tag_id<?php echo $j ?>"   class="form-control" id="tag_id<?php echo $j ?>">
				<option value="">Select</option>
				<?php foreach($tagsData as $tags){ ?>
				<option value="<?php echo $tags->tag_id; ?>" ><?php echo $tags->tag_name; ?></option>
				<?php } ?>
			
				</select>
				</td>
				<td>
					<button type="button" id="edit" class="btn btn-success">Add More</button>
					<input type="hidden" name="number1" id="number1" value="<?php echo $j;?>">
				</td>
			</tr>


		<?php }else{ ?> 
			<tr id="row1">
				<td>
				<select name="tag_id1"   class="form-control" id="tag_id1">
				<option value="">Select</option>
				<?php foreach($tagsData as $tags){ ?>
				<option value="<?php echo $tags->tag_id; ?>" ><?php echo $tags->tag_name; ?></option>
				<?php } ?>
			
				</select>
				</td>
				<td>
					<button type="button" id="add" class="btn btn-success">Add More</button>
					<input type="hidden" name="number" id="number" value="1">
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
       <table class="table table-bordered" id="dynamic_field1" style="width: 71%">  
       	<tr>
				<th style="width:24%">Photo Gallery</th>
				<th style="width:3%">
					</th>
			</tr>

			<?php 
			if($productsData->product_id!=''){  $m=1; 
				 $product_picData = $this->Products_model->get_data_by('products_media',$productsData->product_id ,'product_id');
					foreach ($product_picData as $object) { 	 ?>

			<tr id="rowm<?php echo $m ?>">
				<td>
				<input type="file" name="media<?php echo $m; ?>" class="form-control" accept='image/*'>
				<input type="hidden" name="old_media<?php echo $m; ?>" value="<?php echo $object->media; ?>">
				<input type="hidden" name="media_id<?php echo $m; ?>" value="<?php echo $object->id; ?>">
				</td>
				<td>
				<a href="<?=base_url()?>/assets/images/<?php echo $object->media; ?>" target="_blank"><img src="<?=base_url()?>/assets/images/<?php echo $object->media; ?>" style="width:130px"></a>
				</td>
				<td><button type="button"  id="<?php echo $m; ?>" class="btn btn-danger btn_remove1">X</button></td>
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



		<div>
		<button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
		</div>
      
      </form>
      <SCRIPT language=Javascript>
      	$(document).ready(function(){
		var i=1;
		$('#add').click(function(){
			i++;
			$('#dynamic_field').append('<tr id="row'+i+'"><td id="td'+i+'"></td><td><button type="button"  id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');

			$('#tag_id1').clone().attr('id', 'tag_id'+i+'').attr('name', 'tag_id'+i+'').appendTo($('#td'+i+''));

		});

		$(function () {
		  $('#number').val(i);
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



		var k=$('#number1').val();

      $('#edit').click(function(){  
	  
           k++;  
           $('#dynamic_field').append('<tr id="row'+k+'"><td id="td'+k+'"></td><td><button type="button"  id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>')
		   
		    $('#tag_id1').clone().attr('id', 'tag_id'+k+'').attr('name', 'tag_id'+k+'').appendTo($('#td'+k+''));
 		  $(function () {
		  $('#number1').val(k);
		  
		});
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();
      }); 


      var m=1;
		$('#addm').click(function(){
			m++;
			$('#dynamic_field1').append('<tr id="rowm'+m+'"><td ><input type="file" name="media'+m+'" class="form-control" value=""></td><td><button type="button"  id="'+m+'" class="btn btn-danger btn_remove1">X</button></td></tr>');


		});

		$(function () {
		  $('#numberm').val(m);
		});

		$(document).on('click', '.btn_remove1', function(){  
           var button_id = $(this).attr("id");   
           $('#rowm'+button_id+'').remove();
      	});


		var n=$('#numberm1').val();
		$('#editm').click(function(){
			n++;
			$('#dynamic_field1').append('<tr id="rowm'+n+'"><td ><input type="file" name="media'+n+'" class="form-control" value=""></td><td><button type="button"  id="'+n+'" class="btn btn-danger btn_remove1">X</button></td></tr>');
		});

		$(function () {
		  $('#numberm1').val(n);
		});


		});



      	function getModels(n){
           var make_id = $('#make_id'+n).val();

            $.ajax({
                url:'<?php echo base_url();?>products/getModels',
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




       
    
       
    </SCRIPT>