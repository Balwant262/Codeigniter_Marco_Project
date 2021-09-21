<?php 
if(!empty($leadData->lead_id)){?>
  <h4 class="box-title">Edit Lead</h4>
<?php }else{ ?>
  <h4 class="box-title">Add Lead</h4>
<?php } ?>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'leads/add_edit'?>" method="post">
  <div class="box-body">
    <div class="row">
          
          
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Reference / Lead Source</label>
                <input type="text" name="lead_source" id="lead_coname" value="<?php echo isset($leadData->lead_source)?$leadData->lead_source:'';?>" class="form-control" placeholder="Reference / Lead Source" required autocomplete="off">
                  <span id="exist" ></span>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Prospect Name</label>
                <input type="text" name="lead_coperson" value="<?php echo isset($leadData->lead_coperson)?$leadData->lead_coperson:'';?>" class="form-control" placeholder="Prospect Name" required>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Organization Name</label>
                <input type="text" name="organization_name" id="organization_name" value="<?php echo isset($leadData->organization_name)?$leadData->organization_name:'';?>" class="form-control" placeholder="Organization Name" required autocomplete="off" required>
                  <span id="exist" ></span>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Location</label>
                <select name="location" class="form-control" required>
                    <option value=''>Select Location</option>
                    <?php foreach ($locations as $loc) {  ?>
                    <option value="<?php echo $loc->id; ?>" <?php if($leadData->location == $loc->id) echo 'selected'; ?>><?php echo $loc->name; ?></option>
                    <?php }  ?>
                    </select>
                
                  <span id="exist" ></span>
              </div>
            </div>
        
        <?php if($leadData->lead_id!=''){  ?>
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Lead Will Be Managed By</label>
               <select name="lead_managed_by" class="form-control">
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($leadData->lead_managed_by == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        <?php }else{?>
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Lead Will Be Managed By</label>
               <select name="lead_managed_by" class="form-control">
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        <?php }?>
        
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Address Line 1</label>
               <input type="text" name="address1" class="form-control" value="<?php echo isset($leadData->address1)?$leadData->address1:'';?>" placeholder="Address line 1" >
              </div>
            </div> 

          <div class="col-md-4">
              <div class="form-group">
                <label for="">Address Line 2</label>
               <input type="text" name="address2" class="form-control" value="<?php echo isset($leadData->address2)?$leadData->address2:'';?>" placeholder="Address line 2">
              </div>
            </div>
        
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Landmark</label>
               <input type="text" name="landmark" class="form-control" value="<?php echo isset($leadData->landmark)?$leadData->landmark:'';?>" placeholder="Landmark">
              </div>
            </div>
        
          <div class="col-md-4">
            <div class="form-group">
                <label for="">Country</label>
                <select name="lead_country" id="" class="form-control">
                  <option value="">Select Country</option>
                    <option value="India" <?php if($leadData->lead_country == 'India'){ echo "selected"; } ?> selected>India</option>
                </select>
            </div>
          </div>
        
        <?php if($leadData->lead_id!=''){  ?>
          <div class="col-md-4">
              <div class="form-group">
                <label for="">State</label>
               <select name="lead_state" class="form-control">
                    <option value=''>Select State</option>
                    <?php foreach ($states as $user) {  ?>
                    <option value="<?php echo $user->id; ?>" <?php if($leadData->lead_state == $user->id){ echo "selected"; } ?>><?php echo $user->name; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">City</label>
               <select name="lead_city" class="form-control">
                    <option value=''>Select City</option>
                    <?php foreach ($cities as $user) {  ?>
                    <option value="<?php echo $user->id; ?>" <?php if($leadData->lead_city == $user->id){ echo "selected"; } ?>><?php echo $user->name; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        <?php }else{?>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">State</label>
               <select name="lead_state" class="form-control">
                    <option value=''>Select State</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">City</label>
               <select name="lead_city" class="form-control">
                    <option value=''>Select City</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
         <?php }?>

         
            <div class="col-md-4">
                  <div class="form-group">
                    <label for="Status">Status</label>
                    <select name="status" id="" class="form-control">
                    <option value="1" <?php echo (isset($leadData->status) && $leadData->status == '1')?'selected':''; ?> >Active</option>
                    <option value="0" <?php echo (isset($leadData->status) && $leadData->status == '0')?'selected':''; ?> >Inactive</option>
                    </select>
                  </div>
          </div>

          
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Special Comments</label>
               <textarea type="text" name="notes" class="form-control"  placeholder="Notes"><?php echo isset($leadData->notes)?$leadData->notes:'';?></textarea>
              </div>
            </div>

            <div class="col-md-4" >
              <div class="form-group">
                <label for="">Date</label>
               <input type="date" name="date_created" id="date_created" class="form-control" value="<?php  if($leadData->date_created!=''){ $date=date_create($leadData->date_created); echo date_format($date,"Y-m-d"); }?>" >
              </div>
              <br>
            </div>
        <div class="col-md-4" >
              <div class="form-group">
               
              </div>
              <br>
            </div>
        
        
        
        
            


        </div>
      
      
        
      
      
      <div class="box-form2">
          <div class="row">
              
              <?php if($leadData->lead_id!=''){  ?>
              <div class="col-md-4" style="display: none;">
              <div class="form-group">
                <label for="">Action By User</label>
               <select name="action_whom" class="form-control">
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($leadData->action_whom == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        <?php }else{?>
        <div class="col-md-4" style="display: none;">
              <div class="form-group">
                <label for="">Action By User</label>
               <select name="action_whom" class="form-control">
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
         <?php }?>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Action Date</label>
                <input type="date" name="action_when" id="action_when" value="<?php  if($leadData->action_when!=''){ $date=date_create($leadData->action_when); echo date_format($date,"Y-m-d"); }?>" class="form-control" placeholder="Action When" required autocomplete="off">
                  <span id="exist" ></span>
              </div>
            </div>
              
      <div class="col-md-12">
          
          
          
          
           <label style="font-size: 17px;">Action Status Details: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_field1" style="width: 100%">  
                <tr>
                <th style="width:20%">Action Status</th>
                <th style="width:20%">Date</th>
                <th style="width:20%">Remarks</th>
                <th style="width:17%">User</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($leadData->lead_id!=''){  
                
             $j=1; 
            
              
               foreach ($a_statuss as $object) {  
              
              ?>
              <tr  id="row<?php echo $j ?>" class="">
                <td style="width:60px"><input  type="text" class="form-control " id="a_status<?php echo $j; ?>" name="a_status<?php echo $j ?>" value="<?php echo $object->a_status ?>" /></td>
                 <td style="width:60px"><input  type="date" class="form-control " id="a_date<?php echo $j; ?>" name="a_date<?php echo $j ?>" value="<?php  if($object->a_date!=''){ $date=date_create($object->a_date); echo date_format($date,"Y-m-d"); }?>" /></td>
                  <td style="width:60px"><input  type="text" class="form-control " id="a_remark<?php echo $j; ?>" name="a_remark<?php echo $j ?>" value="<?php echo $object->a_remark ?>" /></td>
                  <td style="width:60px">
                      
               
               <select name="users_id<?php echo $j; ?>" class="form-control">
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($object->users_id == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              
                  </td>
                   <?php  $j++; } 
        if($leadData->lead_id){
         ?>
         <input type="hidden" name="number" id="number" value="<?php echo $j-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number" id="number" value="1">
        <?php } ?>
        <td><button type="button" name="edit" id="edit" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:60px"><input  type="text" class="form-control " id="a_status1" name="a_status1" value="" /></td>
                 <td style="width:60px"><input  type="date" class="form-control " id="a_date1" name="a_date1" value="" /></td>
                  <td style="width:60px"><input  type="text" class="form-control " id="a_remark1" name="a_remark1" value="" /></td>
                <td style="width:60px">
                     
                
               <select name="users_id1" class="form-control">
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              
                  </td>  
                
                <input type="hidden" name="number" id="number" value="1">
                  <td><button type="button" name="add1" id="add1" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
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
              <label style="font-size: 17px;">Product Particulars: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_product" style="width: 100%">  
                <tr>
                <th style="width:24%">Product</th>
                <th style="width:24%">Make</th>
                <th style="width:24%">Model</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($leadData->lead_id!=''){  
                
             $j5=1; 
            
              
               foreach ($lead_products as $object) {  
                   
              ?>
              <tr  id="row<?php echo $j5 ?>" class="">
                <td style="width:80px">
                    
                    <select class="form-control select2"  id="product<?php echo $j5 ?>" name="product<?php echo $j5 ?>"> 
                        <option value="">Select Product</option>    
                        <?php foreach($products as $city){?>
                            <option value="<?php echo $city->product_id; ?>" <?php if($object->product == $city->product_id){ echo "selected"; } ?>><?php echo $city->part_no; ?></option>
                                <?php } ?>
                        </select>
                </td>
                <td style="width:80px">
                    
                    <select class="form-control select2"  id="make<?php echo $j5 ?>" name="make<?php echo $j5 ?>"> 
                        <option value="">Select Make</option>    
                        <?php foreach($makes as $m){?>
                            <option value="<?php echo $m->make_id; ?>" <?php if($object->make_id == $m->make_id){ echo "selected"; } ?>><?php echo $m->make_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                <td style="width:80px">
                    
                    <select class="form-control select2"  id="model<?php echo $j5 ?>" name="model<?php echo $j5 ?>"> 
                        <option value="">Select Model</option>    
                        <?php foreach($models as $city){?>
                            <option value="<?php echo $city->model_id; ?>" <?php if($object->model_id == $city->model_id){ echo "selected"; } ?>><?php echo $city->model_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                   <?php  $j5++; } 
        if($leadData->lead_id){
         ?>
         <input type="hidden" name="number_product" id="number_product" value="<?php echo $j5-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number_product" id="number_product" value="1">
        <?php } ?>
        <td><button type="button" name="edit_product" id="edit_product" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:80px">
                    
                    
                        <select class="form-control select2"  id="product1" name="product1">
                            <option value="">Select Product</option>
                            <?php foreach($products as $city){?>
                            <option value="<?php echo $city->product_id; ?>"><?php echo $city->part_no; ?></option>
                                <?php } ?>
                        </select> 
                </td>
                
                <td style="width:80px">
                    
                    <select class="form-control select2"  id="make<?php echo $j5 ?>" name="make<?php echo $j5 ?>"> 
                        <option value="">Select Make</option>    
                        <?php foreach($makes as $m){?>
                            <option value="<?php echo $m->make_id; ?>"><?php echo $m->make_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                <td style="width:80px">
                    
                    <select class="form-control select2"  id="model<?php echo $j5 ?>" name="model<?php echo $j5 ?>"> 
                        <option value="">Select Model</option>    
                        <?php foreach($models as $city){?>
                            <option value="<?php echo $city->model_id; ?>"><?php echo $city->model_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                 
                  <input type="hidden" name="number_product" id="number_product" value="1">
                  <td><button type="button" name="add_product" id="add_product" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
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
              <label style="font-size: 17px;">Follow Up Details: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_flt" style="width: 100%">  
                <tr>
                <th style="width:24%">Remarks</th>
                <th style="width:24%">Date</th>
                
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($leadData->lead_id!=''){  
                
             $j4=1; 
            
              
               foreach ($lead_follows as $object) {  
              
              ?>
              <tr  id="row<?php echo $j4 ?>" class="">
                <td style="width:80px"><input  type="text" class="form-control " id="fl_remark<?php echo $j4; ?>" name="fl_remark<?php echo $j4 ?>" value="<?php echo $object->fl_remark ?>" /></td>
                 <td style="width:80px"><input  type="date" class="form-control " id="fl_date<?php echo $j4; ?>" name="fl_date<?php echo $j4 ?>" value="<?php  if($object->fl_date!=''){ $date=date_create($object->fl_date); echo date_format($date,"Y-m-d"); }?>" /></td>
                 
                   <?php  $j4++; } 
        if($leadData->lead_id){
         ?>
         <input type="hidden" name="number_flt" id="number_flt" value="<?php echo $j4-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number_flt" id="number_flt" value="1">
        <?php } ?>
        <td><button type="button" name="edit_flt" id="edit_flt" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:80px"><input  type="text" class="form-control " id="fl_remark1" name="fl_remark1" value="" /></td>
                 <td style="width:80px"><input  type="date" class="form-control " id="fl_date1" name="fl_date1" value="" /></td>
                 
                  <input type="hidden" name="number_flt" id="number_flt" value="1">
                  <td><button type="button" name="add_flt" id="add_flt" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
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
              <label style="font-size: 17px;">Photo Gallery: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_photo" style="width: 100%">  
                <tr>
                <th style="width:24%;">Image</th>
                <th style="width:25%;">Download</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($leadData->lead_id!=''){  
                
             $j5=1; 
            
              
               foreach ($lead_photos as $object) {  
                   
              ?>
              <tr  id="row<?php echo $j5 ?>" class="">
                <td style="width:80px"><input  type="file" class="form-control " id="photo_g<?php echo $j5; ?>" name="media<?php echo $j5 ?>" value="<?php echo $object->image ?>" /></td>
                <td style="width:80px"><a href="<?php echo base_url('assets/customer_gallery/'.$object->image) ?>">Download</a></td>
                   <?php  $j5++; } 
        if($leadData->lead_id){
         ?>
         <input type="hidden" name="number_photo" id="number_photo" value="<?php echo $j5-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number_photo" id="number_photo" value="1">
        <?php } ?>
        <td><button type="button" name="edit_photo" id="edit_photo" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:80px"><input  type="file" class="form-control " id="photo_g1" name="media1" value="" /></td>
                 
                  <input type="hidden" name="number_photo" id="number_photo" value="1">
                  <td><button type="button" name="add_photo" id="add_photo" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                </tr>
                   <?php } ?>

            </table>

                  </div>
                </div>
              </div>
</div>
              </div>


     <div class="form-check">
      <input class="form-check-input" type="checkbox" name="inquiry_received" id="" value="1">
      <label class="form-check-label" for="exampleRadios1">
    Inquiry Received
  </label>
      
 </div>




        <?php if(!empty($leadData->lead_id)){?>
        <input type="hidden"  name="lead_id" value="<?php echo isset($leadData->lead_id)?$leadData->lead_id:'';?>">

        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="edit" value="edit" class="btn btn-success wdt-bg">Update</button>
        </div>
              <!-- /.box-body -->
        <?php }else{?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="add" class="btn btn-success wdt-bg">Add</button>
        </div>
        <?php }?>
      </form>

  
  <script type="text/javascript">
  $(document).ready(function(){
    var i=1;
    var i3=1;
    var i4=1;
    var i5=1;
    
    $('#add1').click(function(){
      i++;
      $('#dynamic_field1').append('<tr id="row'+i+'"><td><input type="text" class="form-control"  id="a_status'+i+'" name="a_status'+i+'"/></td><td><input type="date" class="form-control"  id="a_date'+i+'" name="a_date'+i+'"/></td><td><input type="text" class="form-control"  id="a_remark'+i+'" name="a_remark'+i+'"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      
      document.getElementById("number").value=i;
      $(function () {
      $('#number').val(i);
    });
    });
    
            $('#add_flt').click(function(){  
     i3++;
           $('#dynamic_flt').append('<tr id="row'+i3+'"><td><input type="text" class="form-control"  id="fl_remark'+i3+'" name="fl_remark'+i3+'"/></td><td><input type="date" class="form-control"  id="fl_date'+i3+'" name="fl_date'+i3+'"/></td><td><button type="button" name="remove" id="'+i3+'" class="btn btn-danger btn_remove_flt">X</button></td></tr>');
       
      document.getElementById("number_flt").value=i3;
      $(function () {
      $('#number_flt').val(i3);
      
    });
      }); 
    
    
    
          $('#add_photo').click(function(){  
     i4++;
           $('#dynamic_photo').append('<tr id="row'+i4+'"><td><input type="file" class="form-control"  id="photo_g'+i4+'" name="media'+i4+'"/></td><td><button type="button" name="remove" id="'+i4+'" class="btn btn-danger btn_remove_photo">X</button></td></tr>');
       
      document.getElementById("number_photo").value=i4;
      $(function () {
      $('#number_photo').val(i4);
      
    });
      });
      
      $('#add_product').click(function(){  
     i5++;
           $('#dynamic_product').append('<tr id="row'+i5+'"><td><select class="form-control select2"  id="product'+i5+'" name="product'+i5+'"> <?php foreach($products as $city){?><option value="<?php echo $city->product_id; ?>"><?php echo $city->part_no; ?></option><?php } ?></select></td><td><select class="form-control select2"  id="make'+i5+'" name="make'+i5+'"> <?php foreach($makes as $city){?><option value="<?php echo $city->make_id; ?>"><?php echo $city->make_name; ?></option><?php } ?></select></td><td><select class="form-control select2"  id="model'+i5+'" name="model'+i5+'"> <?php foreach($models as $city){?><option value="<?php echo $city->model_id; ?>"><?php echo $city->model_name; ?></option><?php } ?></select></td><td><button type="button" name="remove" id="'+i5+'" class="btn btn-danger btn_remove_product">X</button></td></tr>');
       
      document.getElementById("number_product").value=i5;
      $(function () {
      $('#number_product').val(i5);
      
    });
      });
      
        $(document).on('click', '.btn_remove', function(){        
    var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
           i--;
           
      });
      
      $(document).on('click', '.btn_remove_flt', function(){  
          
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           i3--; 
           
      }); 
      
      $(document).on('click', '.btn_remove_photo', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           i4--; 

      });
      
       $(document).on('click', '.btn_remove_product', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           i5--; 

      });
  }); 
  
  
$(document).ready(function(){  
      
   var k=$('#number').val();
    var kc=$('#number_flt').val();
    var kd=$('#number_photo').val();
    var ke=$('#number_product').val();
    
          $('#edit').click(function(){  
    
           k++;  
           $('#dynamic_field1').append('<tr id="row'+k+'"><td><input type="text" class="form-control"  id="a_status'+k+'" name="a_status'+k+'"/></td><td><input type="date" class="form-control"  id="a_date'+k+'" name="a_date'+k+'"/></td><td><input type="text" class="form-control"  id="a_remark'+k+'" name="a_remark'+k+'"/></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number").value=k;
      $(function () {
      $('#number').val(k);
      
    });
      }); 
    
      $('#edit_flt').click(function(){  
     kc++;
           $('#dynamic_flt').append('<tr id="row'+kc+'"><td><input type="text" class="form-control"  id="fl_remark'+kc+'" name="fl_remark'+kc+'"/></td><td><input type="date" class="form-control"  id="fl_date'+kc+'" name="fl_date'+kc+'"/></td><td><button type="button" name="remove" id="'+kc+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number_flt").value=kc;
      $(function () {
      $('#number_flt').val(kc);
      
    });
      }); 
      
       $('#edit_photo').click(function(){  
     kd++;
           $('#dynamic_photo').append('<tr id="row'+kd+'"><td><input type="file" class="form-control"  id="photo_g'+kd+'" name="media'+kd+'"/></td><td><button type="button" name="remove" id="'+kd+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number_photo").value=kd;
      $(function () {
      $('#number_photo').val(kd);
      
    });
      }); 
      
      $('#edit_product').click(function(){  
     ke++;
           $('#dynamic_product').append('<tr id="row'+ke+'"><td><select class="form-control select2"  id="product'+ke+'" name="product'+ke+'"> <?php foreach($products as $city){?><option value="<?php echo $city->product_id; ?>"><?php echo $city->part_no; ?></option><?php } ?></select></td><td><select class="form-control select2"  id="make'+ke+'" name="make'+ke+'"> <?php foreach($makes as $city){?><option value="<?php echo $city->make_id; ?>"><?php echo $city->make_name; ?></option><?php } ?></select></td><td><select class="form-control select2"  id="model'+ke+'" name="model'+ke+'"> <?php foreach($models as $city){?><option value="<?php echo $city->model_id; ?>"><?php echo $city->model_name; ?></option><?php } ?></select></td><td><button type="button" name="remove" id="'+ke+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number_product").value=ke;
      $(function () {
      $('#number_product').val(ke);
      
    });
      }); 

$(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           k--; 

      }); 
      
      $(document).on('click', '.btn_remove_flt', function(){
          
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           kc--; 
           
      }); 
      
      $(document).on('click', '.btn_remove_photo', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           kd--; 

      }); 
      
      $(document).on('click', '.btn_remove_product', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           ke--; 

      }); 
    
    
 });  

</script>