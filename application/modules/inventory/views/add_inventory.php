


<style type="text/css">
	td{
		padding: 10px;
	}
</style>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'inventory/add'?>" method="post">
			<input type="hidden" name="inventory_id" value="<?php echo $inventoryData->inventory_id ?>" />
			<div class="box-form2">
				<div class="row">
				<?php //print_r($productsData); ?>
					<div class="col-md-6">
              <div class="form-group">
              	<label for="">Products</label>
             <select onchange="chansgeass()"  class="form-control partnm" id="p" name="product" >
        <option value="">Select</option>
         <?php foreach ($productsData as  $products) { ?>
              <option value="<?php echo $products->product_id; ?>" <?php if (($products->product_id) == ($value->product)) { echo "selected"; } ?>><?php echo $products->part_no; ?></option>
            <?php   } ?>
               </select>   
                  </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              	<label for="">Assembly Products</label>
            <select onchange="changedesc()"  class="form-control partnm" id="as" name="assembleproduct">
        <option value="">Select</option>
          <?php foreach ($assembleData as  $assemble) { ?>
              <option value="<?php echo $assemble->assemble_id; ?>" <?php if (($assemble->assemble_id) == ($value->assem_prof)) { echo "selected"; } ?>><?php echo $assemble->part_name; ?></option>
            <?php   } ?>
               
              
        </select> 
                  </div>
            </div>
		<div class="col-md-6">
              <div class="form-group">
                <label for="">Pieces</label>
                                <input type="number" name="pieces" value="<?php echo $inventoryData->pieces ?>"  class="form-control" placeholder="Pieces" >
              </div>
            </div>
             <button style="margin:15px;" type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
    
		</div>
	</div>
      </form>

      <script type="text/javascript">
      	 function changedesc(){
          document.getElementById('p').selectedIndex = 0;
       }
       function chansgeass(){
        
          document.getElementById('as').selectedIndex = 0;
       }
      </script>