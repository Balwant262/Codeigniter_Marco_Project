<?php 
if(!empty($supplierData->tag_id)){?>
  <h4 class="box-title">Edit Supplier</h4>
<?php }else{ ?>
  <h4 class="box-title">Add Supplier</h4>
<?php } ?>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'suppliers/add_edit'?>" method="post" onsubmit="return validateForm()">

  <div class="box-body">
    <div class="row">
        
						<div class="col-md-6">
						  <div class="form-group">
						    <label for="">Supplier Name</label>
						    <input type="text" name="supplier_name" id="supplier_name" value="<?php echo isset($supplierData->supplier_name)?$supplierData->supplier_name:'';?>" class="form-control" placeholder="Supplier Name" required autocomplete="off">
                <span id="checkex" style="color: red; display: none;" >Supplier Already Exist...</span>
						  </div>
						</div>
            <input type="hidden" id="extst" value="0">

            <?php $usertype=$this->session->get_userdata()['user_details'][0]->user_type; if ($usertype=='admin') { ?>

            <!-- <div class="col-md-4">
              <div class="form-group">
                <label for="">Supplier Price</label>
                <input type="number" name="supplier_price" value="<?php echo isset($supplierData->supplier_price)?$supplierData->supplier_price:'';?>" class="form-control" placeholder="Supplier Price" >
              </div>
            </div> -->
          <?php } ?>


          <div class="col-md-6">
              <div class="form-group">
                <label for="">Phone</label>
                <input type="text" name="phone" id="phone" value="<?php echo isset($supplierData->phone)?$supplierData->phone:'';?>" class="form-control" placeholder="Phone No." required>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" value="<?php echo isset($supplierData->email)?$supplierData->email:'';?>" class="form-control" placeholder="Email">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">PAN No.</label>
                <input type="text" name="pan" value="<?php echo isset($supplierData->pan)?$supplierData->pan:'';?>" class="form-control" placeholder="PAN Number">
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="">Address</label>
               <textarea type="text" name="address" class="form-control"  placeholder="Address"><?php echo isset($supplierData->address)?$supplierData->address:'';?></textarea>
              </div>
            </div>




    </div>
        <?php if(!empty($supplierData->supplier_id)){?>
        <input type="hidden"  name="supplier_id" value="<?php echo isset($supplierData->supplier_id)?$supplierData->supplier_id:'';?>">

        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
        </div>
              <!-- /.box-body -->
        <?php }else{?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="add" class="btn btn-success wdt-bg">Add</button>
        </div>
        <?php } ?>
      </form>

<script type="text/javascript">
  $(document).ready(function() {  

  $('#supplier_name').change(function () {  
    var supplier_name = $(this).val();
    //alert(item_name);
    $.ajax({
        url:'<?php echo base_url();?>Suppliers/checksuppname',
        method: 'post',
        data: {supplier_name: supplier_name},
        dataType: 'text',
        success: function(data){
           // console.log(data);
            document.getElementById("checkex").style.display = data;
            if(data=='block'){
              $('#extst').val(1);
            }else{
              $('#extst').val(0);
            }
        }
     });

  });
});

function validateForm() {
  if ($('#extst').val() == 1) {
    alert("Tag Already Exist..");
    return false;
  }
}
</script>