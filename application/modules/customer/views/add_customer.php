<?php 
if(!empty($customerData->customer_id)){?>
  <h4 class="box-title">Edit Customer</h4>
<?php }else{ ?>
  <h4 class="box-title">Add Customer</h4>
<?php } ?>
<?php $useroff=$this->session->get_userdata()['user_details'][0]->office_id; ?>
  
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'customer/add_edit'?>" method="post">
    <div class="box-body">
    <div class="row">
      <div class="col-md-4">
              <div class="form-group">
                <label for="">Organization Name</label>
                <input type="text" name="co_name" value="<?php echo isset($customerData->co_name)?$customerData->co_name:'';?>" class="form-control" placeholder="Last Name" required>
              </div>
            </div>
             <div class="col-md-4">
              <div class="form-group">
                <label for="">Board Line 1 / Landline 1</label>
                <input type="text" name="cust_phone" id="phone" value="<?php echo isset($customerData->cust_phone)?$customerData->cust_phone:'';?>" class="form-control" placeholder="Board Line 1 / Landline 1" required>
                <span id="existPhone" style="width: 62%;"></span>
                <!-- <span id="existPhone1" ></span> -->
              </div>
            </div>
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Board Line 2 / Landline 2</label>
                <input type="text" name="cust_phone2" id="cust_phone2" value="<?php echo isset($customerData->cust_phone2)?$customerData->cust_phone2:'';?>" class="form-control" placeholder="Board Line 2 / Landline 2" required>
                <span id="existPhone" style="width: 62%;"></span>
                <!-- <span id="existPhone1" ></span> -->
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Alternate Number</label>
                <input type="text" name="alternate_phone" id="alternate_phone" value="<?php echo isset($customerData->alternate_phone)?$customerData->alternate_phone:'';?>" class="form-control" placeholder="Alternate Number" required>
                <span id="existPhone" style="width: 62%;"></span>
                <!-- <span id="existPhone1" ></span> -->
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Home Phone</label>
                <input type="text" name="home_phone" id="phone" value="<?php echo isset($customerData->home_phone)?$customerData->home_phone:'';?>" class="form-control" placeholder="Home Phone" required>
                <span id="existPhone" style="width: 62%;"></span>
                <!-- <span id="existPhone1" ></span> -->
              </div>
            </div>
        
    </div>
    </div>
          <div class="box-form2">
          <div class="row">

          <div class="col-md-12">
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_field1" style="width: 100%">  
                <tr>
                <th style="width:24%">Contact Name</th>
                <th style="width:24%">Contact Email</th>
                <th style="width:24%">Contact Cellphone</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($customerData->customer_id!=''){  
                
             $j=1; 
            
              
               foreach ($customer_follow_up as $object) {  
              
              ?>
              <tr  id="row<?php echo $j ?>" class="">
                <td style="width:80px"><input  type="text" class="form-control " id="person_name<?php echo $j; ?>" name="person_name<?php echo $j ?>" value="<?php echo $object->person_name ?>" required/></td>
                 <td style="width:80px"><input  type="email" class="form-control " id="person_email<?php echo $j; ?>" name="person_email<?php echo $j ?>" value="<?php echo $object->person_email ?>" required/></td>
                  <td style="width:80px"><input  type="text" class="form-control " id="person_phone<?php echo $j; ?>" name="person_phone<?php echo $j ?>" value="<?php echo $object->person_phone ?>" required/></td>
                   <?php  $j++; } 
        if($customerData->customer_id){
         ?>
         <input type="hidden" name="number" id="number" value="<?php echo $j-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number" id="number" value="1">
        <?php } ?>
        <td><button type="button" name="edit" id="edit" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:80px"><input  type="text" class="form-control " id="person_name1" name="person_name1" value="" required/></td>
                 <td style="width:80px"><input  type="email" class="form-control " id="person_email1" name="person_email1" value="" required/></td>
                  <td style="width:80px"><input  type="text" class="form-control " id="person_phone1" name="person_phone1" value="" required/></td>
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

  <div class="box-body">
    <div class="row">
        
						
           
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Web Url</label>
                <input type="text" name="web_url" value="<?php echo isset($customerData->web_url)?$customerData->web_url:'';?>" class="form-control" placeholder="Web URL">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label for="">Fb Page</label>
                <input type="text" name="fb_page" value="<?php echo isset($customerData->fb_page)?$customerData->fb_page:'';?>" class="form-control" placeholder="Fb Page">
              </div>
            </div>
             <div class="col-md-4">
              <div class="form-group">
                <label for="">Insta Page</label>
               <input type="text" name="insta_page" class="form-control" value="<?php echo isset($customerData->insta_page)?$customerData->insta_page:'';?>" placeholder="Insta Page">
              </div>
            </div>
             <div class="col-md-4">
              <div class="form-group">
                <label for="">Twitter Handle</label>
               <input type="text" name="twitter_handel" class="form-control" value="<?php echo isset($customerData->twitter_handel)?$customerData->twitter_handel:'';?>" placeholder="Twitter Handle">
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Linked In Connect</label>
               <input type="text" name="linked_connect" class="form-control" value="<?php echo isset($customerData->linked_connect)?$customerData->linked_connect:'';?>" placeholder="Linked In Connect">
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Category Of Client</label>
               <input type="text" name="category_of_client" class="form-control" value="<?php echo isset($customerData->category_of_client)?$customerData->category_of_client:'';?>" placeholder="Category Of Client" required>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Industry Type</label>
               <input type="text" name="industry_type" class="form-control" value="<?php echo isset($customerData->industry_type)?$customerData->industry_type:'';?>" placeholder="Industry Type" required>
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Turn Over Potential</label>
               <input type="text" name="turn_over_potential" class="form-control" value="<?php echo isset($customerData->turn_over_potential)?$customerData->turn_over_potential:'';?>" placeholder="Turn Over Potential" required>
              </div>
            </div>
        
       
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Rating</label>
               <input type="text" name="rating" class="form-control" value="<?php echo isset($customerData->rating)?$customerData->rating:'';?>" placeholder="Rating">
              </div>
            </div>
        
        <div class="col-md-4">
              <div class="form-group">
                <label for="">Client Follow Up Assigned To</label>
               <select name="user_id_assign_to" class="form-control" required>
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($customerData->user_id_assign_to == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>
        
         <div class="col-md-4">
              <div class="form-group">
                <label for="">Location</label>
               <select name="location" class="form-control" required>
                    <option value=''>Select Location</option>
                    <?php foreach ($locations as $loc) {  ?>
                    <option value="<?php echo $loc->id; ?>" <?php if($customerData->location == $loc->id) echo 'selected'; ?>><?php echo $loc->name; ?></option>
                    <?php }  ?>
                    </select>
              </div>
            </div>

            <div>
              <div class="col-md-12">
              <!-- <div class="form-group"> -->
              <label style="font-size: 17px;">Registration Address: </label>
            <!-- </div> -->
          </div>
                
                <div class="col-md-12">
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_field_addresss" style="width: 100%">  
                <tr>
                <th style="width:14%">Address Line 1</th>
                <th style="width:14%">Address Line 2</th>
                <th style="width:14%">Landmark</th>
                <th style="width:14%">City</th>
                <th style="width:14%">State</th>
                <th style="width:14%">Country</th>
                <th style="width:14%">Pincode</th>
                <th style="width:2%">        </th>
              </tr>
              <?php 
                                  
                if($customerData->customer_id!=''){  
                
             $j2=1; 
            
              
               foreach ($customer_address as $addrs) {  
              
              ?>
              <tr  id="row<?php echo $j2 ?>" class="">
                <td style="width:14%"><input  type="text" class="form-control " id="address_line_1<?php echo $j2; ?>" name="address_line_1<?php echo $j2 ?>" value="<?php echo $addrs->address_line_1 ?>" /></td>
                <td style="width:14%"><input  type="text" class="form-control " id="address_line_2<?php echo $j2; ?>" name="address_line_2<?php echo $j2 ?>" value="<?php echo $addrs->address_line_2 ?>" /></td>
                <td style="width:14%"><input  type="text" class="form-control " id="landmark<?php echo $j2; ?>" name="landmark<?php echo $j2 ?>" value="<?php echo $addrs->landmark ?>" /></td>
                <td style="width:14%">
                <select name="city<?php echo $j2; ?>" id="city<?php echo $j2; ?>" class="form-control select2">
                    <option value=''>Select City</option>
                    <?php foreach ($cities as $city) {  ?>
                    <option value="<?php echo $city->id; ?>" <?php if($addrs->city == $city->id) echo 'selected'; ?>><?php echo $city->name; ?></option>
                    <?php }  ?>
                    </select>
                </td>
                <td style="width:14%">
                    <select name="state<?php echo $j2; ?>" id="state<?php echo $j2; ?>" class="form-control select2">
                    <option value=''>Select City</option>
                    <?php foreach ($states as $st) {  ?>
                    <option value="<?php echo $st->id; ?>" <?php if($addrs->state == $st->id) echo 'selected'; ?>><?php echo $st->name; ?></option>
                    <?php }  ?>
                    </select>
                </td>
                <td style="width:14%"><input  type="text" class="form-control " id="country<?php echo $j2; ?>" name="country<?php echo $j2 ?>" value="<?php echo $addrs->country ?>" /></td>
                <td style="width:10%"><input  type="text" class="form-control " id="pin_code<?php echo $j2; ?>" name="pin_code<?php echo $j2 ?>" value="<?php echo $addrs->pin_code ?>" /></td>
                   <?php  $j2++; } 
        if($customerData->customer_id){
         ?>
         <input type="hidden" name="number_address" id="number_address" value="<?php echo $j2-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number_address" id="number_address" value="1">
        <?php } ?>
        <td><button type="button" name="edit" id="edit_address" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{
     
                  ?> 
                <tr id="row">
                <td style="width:14%"><input  type="text" class="form-control " id="address_line_11" name="address_line_11" value="" /></td>
                <td style="width:14%"><input  type="text" class="form-control " id="address_line_21" name="address_line_21" value="" /></td>
                <td style="width:14%"><input  type="text" class="form-control " id="landmark1" name="landmark1" value="" /></td>
                <td style="width:14%">
                <select name="city1" class="form-control select2">
                    <option value=''>Select City</option>
                    <?php foreach ($cities as $city) {  ?>
                    <option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option>
                    <?php }  ?>
                    </select>
                </td>
                <td style="width:14%">
                    <select name="state1" class="form-control select2">
                    <option value=''>Select City</option>
                    <?php foreach ($states as $st) {  ?>
                    <option value="<?php echo $st->id; ?>"><?php echo $st->name; ?></option>
                    <?php }  ?>
                    </select>
                </td>
                    
                <td style="width:14%"><input  type="text" class="form-control " id="country1" name="country1" value="" /></td>
                <td style="width:14%"><input  type="text" class="form-control " id="pin_code1" name="pin_code1" value="" /></td>
                <input type="hidden" name="number_address" id="number_address" value="1">
                <td><button type="button" name="add_address" id="add_address" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                </tr>
                   <?php } ?>

            </table>

                  </div>
                </div>
              </div>
                
                

	
          

        </div>
        
        
                  <div class="box-form2">
          <div class="row">

          <div class="col-md-12">
              <label style="font-size: 17px;">Equipment Details: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_eqt" style="width: 100%">  
                <tr>
                <th style="width:24%">Equipment Type</th>
                <th style="width:24%">Make</th>
                <th style="width:24%">Model</th>
                <th style="width:24%">Quantity</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($customerData->customer_id!=''){  
                
             $j3=1; 
            
              
               foreach ($customer_eqts as $object) {  
              
              ?>
              <tr  id="row<?php echo $j3 ?>" class="">
                <td style="width:80px"><input  type="text" class="form-control " id="eqt_type<?php echo $j3; ?>" name="eqt_type<?php echo $j3 ?>" value="<?php echo $object->eqt_type ?>" /></td>
                 <td style="width:80px"><input  type="text" class="form-control " id="eqt_make<?php echo $j3; ?>" name="eqt_make<?php echo $j3 ?>" value="<?php echo $object->eqt_make ?>" /></td>
                  <td style="width:80px">
                      
                      
                        <select name="eqt_model<?php echo $j3; ?>" class="form-control select2" id="eqt_model<?php echo $j3; ?>">
                    <option value=''>Select Model</option>
                    <?php foreach ($models as $st) {  ?>
                    <option value="<?php echo $st->model_id; ?>" <?php if($object->eqt_model == $st->model_id) echo 'selected'; ?>><?php echo $st->model_name; ?></option>
                    <?php }  ?>
                    </select>
                  
                  </td>
                  
                  
                  <td style="width:80px"><input  type="text" class="form-control " id="eqt_quantity<?php echo $j3; ?>" name="eqt_quantity<?php echo $j3 ?>" value="<?php echo $object->eqt_quantity ?>" /></td>
                   <?php  $j3++; } 
        if($customerData->customer_id){
         ?>
         <input type="hidden" name="number_eqt" id="number_eqt" value="<?php echo $j3-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number_eqt" id="number_eqt" value="1">
        <?php } ?>
        <td><button type="button" name="edit_eqt" id="edit_eqt" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:80px"><input  type="text" class="form-control " id="eqt_type1" name="eqt_type1" value="" /></td>
                 <td style="width:80px"><input  type="text" class="form-control " id="eqt_make1" name="eqt_make1" value="" /></td>
                  <td style="width:80px">
                  <select name="eqt_model1" class="form-control select2" id="eqt_model1">
                    <option value=''>Select Model</option>
                    <?php foreach ($models as $st) {  ?>
                    <option value="<?php echo $st->model_id; ?>"><?php echo $st->model_name; ?></option>
                    <?php }  ?>
                    </select>
                  
                  </td>
                  <td style="width:80px"><input  type="text" class="form-control " id="eqt_quantity1" name="eqt_quantity1" value="" /></td>
                  <input type="hidden" name="number_eqt" id="number_eqt" value="1">
                  <td><button type="button" name="add_eqt" id="add_eqt" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
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
              <label style="font-size: 17px;">Fleet Details: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_flt" style="width: 100%">  
                <tr>
                <th style="width:19%;">Fleet Type</th>
                <th style="width:19%;">DWT</th>
                <th style="width:19%;">Year</th>
                <th style="width:19%;">Potential</th>
                <th style="width:19%;">Voyage</th>
                <th style="width:5%;">        </th>
              </tr>
              <?php 
                                  
                if($customerData->customer_id!=''){  
                
             $j4=1; 
            
              
               foreach ($customer_flts as $object) {  
              
              ?>
              <tr  id="row<?php echo $j4 ?>" class="">
                <td style="width:19%;"><input  type="text" class="form-control " id="flt_type<?php echo $j4; ?>" name="flt_type<?php echo $j4 ?>" value="<?php echo $object->flt_type ?>" /></td>
                 <td style="width:19%;"><input  type="text" class="form-control " id="flt_dwt<?php echo $j4; ?>" name="flt_dwt<?php echo $j4 ?>" value="<?php echo $object->flt_dwt ?>" /></td>
                 <td style="width:19%;"><input  type="text" class="form-control " id="flt_year<?php echo $j4; ?>" name="flt_year<?php echo $j4 ?>" value="<?php echo $object->flt_year ?>" /></td>
                  <td style="width:19%;"><input  type="text" class="form-control " id="flt_potential<?php echo $j4; ?>" name="flt_potential<?php echo $j4 ?>" value="<?php echo $object->flt_potential ?>" /></td>
                  <td style="width:19%;"><input  type="text" class="form-control " id="flt_voyage<?php echo $j4; ?>" name="flt_voyage<?php echo $j4 ?>" value="<?php echo $object->flt_voyage ?>" /></td>
                   <?php  $j4++; } 
        if($customerData->customer_id){
         ?>
         <input type="hidden" name="number_flt" id="number_flt" value="<?php echo $j4-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number_flt" id="number_flt" value="1">
        <?php } ?>
        <td><button type="button" name="edit_flt" id="edit_flt" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:19%;"><input  type="text" class="form-control " id="flt_type1" name="flt_type1" value="" /></td>
                 <td style="width:19%;"><input  type="text" class="form-control " id="flt_dwt1" name="flt_dwt1" value="" /></td>
                 <td style="width:19%;"><input  type="text" class="form-control " id="flt_year1" name="flt_year1" value="" /></td>
                  <td style="width:19%;"><input  type="text" class="form-control " id="flt_potential1" name="flt_potential1" value="" /></td>
                  <td style="width:19%;"><input  type="text" class="form-control " id="flt_voyage1" name="flt_voyage1" value="" /></td>
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
                <th style="width:24%">Image</th>
                
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($customerData->customer_id!=''){  
                
             $j5=1; 
            
              
               foreach ($customer_photos as $object) {  
                   
              ?>
              <tr  id="row<?php echo $j5 ?>" class="">
                <td style="width:80px"><input  type="file" class="form-control " id="photo_g<?php echo $j5; ?>" name="media<?php echo $j5 ?>" value="<?php echo $object->image ?>" /></td>
                 
                   <?php  $j5++; } 
        if($customerData->customer_id){
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

            <div class="col-md-6">
                  <div class="form-group">
                    <label for="Status">Status</label>
                    <select name="status" id="" class="form-control">
                    <option value="1" <?php echo (isset($customerData->status) && $customerData->status == '1')?'selected':''; ?> >Active</option>
                    <option value="0" <?php echo (isset($customerData->status) && $customerData->status == '0')?'selected':''; ?> >Inactive</option>
                    </select>
                  </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Notes</label>
               <textarea type="text" name="notes" class="form-control"  placeholder="Notes"><?php echo isset($customerData->notes)?$customerData->notes:'';?></textarea>
              </div>
            </div>

          

        </div>
        <?php if(!empty($customerData->customer_id)){?>
        <input type="hidden"  name="customer_id" value="<?php echo isset($customerData->customer_id)?$customerData->customer_id:'';?>">

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
    var i1=1;
    var i2=1;
    var i3=1;
    var i4=1;

    $('#add1').click(function(){
      i++;
      $('#dynamic_field1').append('<tr id="row'+i+'"><td><input type="text" class="form-control"  id="person_name'+i+'" name="person_name'+i+'"/></td><td><input type="email" class="form-control"  id="person_email'+i+'" name="person_email'+i+'"/></td><td><input type="text" class="form-control"  id="person_phone'+i+'" name="person_phone'+i+'"/></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      
      document.getElementById("number").value=i;
      $(function () {
      $('#number').val(i);
    });
    });
    
    $('#add_address').click(function(){
      i1++;
      $('#dynamic_field_addresss').append('<tr id="row'+i1+'"><td><input type="text" class="form-control"  id="address_line_1'+i1+'" name="address_line_1'+i1+'"/></td><td><input type="text" class="form-control"  id="address_line_2'+i1+'" name="address_line_2'+i1+'"/></td><td><input type="text" class="form-control"  id="landmark'+i1+'" name="landmark'+i1+'"/></td>\n\
    <td><select class="form-control select2"  id="city'+i1+'" name="city'+i1+'"> <?php foreach($cities as $city){?><option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option><?php } ?></select></td>\n\
<td><select class="form-control select2"  id="state'+i1+'" name="state'+i1+'"> <?php foreach($states as $city){?><option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option><?php } ?></select></td>\n\
<td><input type="text" class="form-control"  id="country'+i1+'" name="country'+i1+'"/></td>\n\
<td><input type="text" class="form-control"  id="pin_code'+i1+'" name="pin_code'+i1+'"/></td>\n\
<td><button type="button" name="remove" id="'+i1+'" class="btn btn-danger btn_remove_address">X</button></td></tr>');
      
      document.getElementById("number_address").value=i1;
      $(function () {
      $('#number_address').val(i1);
    });
    });
    
    $('#add_eqt').click(function(){  
     i2++;
           $('#dynamic_eqt').append('<tr id="row'+i2+'"><td><input type="text" class="form-control"  id="eqt_type'+i2+'" name="eqt_type'+i2+'"/></td><td><input type="text" class="form-control"  id="eqt_make'+i2+'" name="eqt_make'+i2+'"/></td><td><select class="form-control select2"  id="city'+i1+'" name="city'+i1+'"> <?php foreach($models as $m){?><option value="<?php echo $m->model_id; ?>"><?php echo $m->model_name; ?></option><?php } ?></select></td><td><input type="text" class="form-control" id="eqt_quantity'+i2+'" name="eqt_quantity'+i2+'"/></td><td><button type="button" name="remove" id="'+i2+'" class="btn btn-danger btn_remove_eqt">X</button></td></tr>');
       
      document.getElementById("number_eqt").value=i2;
      $(function () {
      $('#number_eqt').val(i2);
      
    });
      }); 
    
        $('#add_flt').click(function(){  
     i3++;
           $('#dynamic_flt').append('<tr id="row'+i3+'"><td><input type="text" class="form-control"  id="flt_type'+i3+'" name="flt_type'+i3+'"/></td><td><input type="text" class="form-control"  id="flt_dwt'+i3+'" name="flt_dwt'+i3+'"/></td><td><input type="text" class="form-control"  id="flt_year'+i3+'" name="flt_year'+i3+'"/></td><td><input type="text" class="form-control" id="flt_potential'+i3+'" name="flt_potential'+i3+'"/></td><td><input type="text" class="form-control" id="flt_voyage'+i3+'" name="flt_voyage'+i3+'"/></td><td><button type="button" name="remove" id="'+i3+'" class="btn btn-danger btn_remove_flt">X</button></td></tr>');
       
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
    
  $(document).on('click', '.btn_remove', function(){        
    var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
           i--;
           
      });
      
      
      $(document).on('click', '.btn_remove_address', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           i1--; 

      }); 
      
      $(document).on('click', '.btn_remove_eqt', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           i2--; 

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
  });  


$(document).ready(function(){  
      
    var k=$('#number').val();
    var ka=$('#number_address').val();
    var kb=$('#number_eqt').val();
    var kc=$('#number_flt').val();
    var kd=$('#number_photo').val();
    

      $('#edit').click(function(){  
    
           k++;  
           $('#dynamic_field1').append('<tr id="row'+k+'"><td><input type="text" class="form-control"  id="person_name'+k+'" name="person_name'+k+'"/></td><td><input type="text" class="form-control"  id="person_email'+k+'" name="person_email'+k+'"/></td><td><input type="text" class="form-control"  id="person_phone'+k+'" name="person_phone'+k+'"/></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number").value=k;
      $(function () {
      $('#number').val(k);
      
    });
      }); 
      
      $('#edit_address').click(function(){  
    
           ka++;  
           $('#dynamic_field_addresss').append('<tr id="row'+ka+'"><td><input type="text" class="form-control"  id="address_line_1'+ka+'" name="address_line_1'+ka+'"/></td><td><input type="text" class="form-control"  id="address_line_2'+ka+'" name="address_line_2'+ka+'"/></td><td><input type="text" class="form-control"  id="landmarka'+ka+'" name="landmarka'+ka+'"/></td>\n\
<td><select class="form-control select2"  id="city'+ka+'" name="city'+ka+'"> <?php foreach($cities as $city){?><option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option><?php } ?></select></td>\n\
<td><select class="form-control select2"  id="state'+ka+'" name="state'+ka+'"> <?php foreach($states as $city){?><option value="<?php echo $city->id; ?>"><?php echo $city->name; ?></option><?php } ?></select></td>\n\
<td><input type="text" class="form-control"  id="country'+ka+'" name="country'+ka+'"/></td>\n\
<td><input type="text" class="form-control"  id="pin_code'+ka+'" name="pin_code'+ka+'"/></td>\n\
<td><button type="button" name="remove" id="'+ka+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    
      document.getElementById("number_address").value=ka;
      $(function () {
      $('#number_address').val(ka);
      
    });
      }); 
      
      $('#edit_eqt').click(function(){  
    
           kb++;  
           $('#dynamic_eqt').append('<tr id="row'+kb+'"><td><input type="text" class="form-control"  id="eqt_type'+kb+'" name="eqt_type'+kb+'"/></td><td><input type="text" class="form-control"  id="eqt_makbe'+kb+'" name="eqt_makbe'+kb+'"/></td><td><select class="form-control select2"  id="city'+kb+'" name="city'+kb+'"> <?php foreach($models as $m){?><option value="<?php echo $m->model_id; ?>"><?php echo $m->model_name; ?></option><?php } ?></select></td><td><input type="text" class="form-control" id="eqt_quantity'+kb+'" name="eqt_quantity'+kb+'"/></td><td><button type="button" name="remove" id="'+kb+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number_eqt").value=kb;
      $(function () {
      $('#number_eqt').val(kb);
      
    });
      }); 
      
      
      $('#edit_flt').click(function(){  
     kc++;
           $('#dynamic_flt').append('<tr id="row'+kc+'"><td><input type="text" class="form-control"  id="flt_type'+kc+'" name="flt_type'+kc+'"/></td><td><input type="text" class="form-control"  id="flt_dwt'+kc+'" name="flt_dwt'+kc+'"/></td><td><input type="text" class="form-control"  id="flt_year'+kc+'" name="flt_year'+kc+'"/></td><td><input type="text" class="form-control" id="flt_potential'+kc+'" name="flt_potential'+kc+'"/></td><td><input type="text" class="form-control" id="flt_voyage'+kc+'" name="flt_voyage'+kc+'"/></td><td><button type="button" name="remove" id="'+kc+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
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
      $('#number_photo').val(i);
      
    });
      }); 
      
      
      
      
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           k--; 

      }); 
      
      $(document).on('click', '.btn_remove_address', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           ka--; 

      }); 
      
      $(document).on('click', '.btn_remove_eqt', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           kb--; 

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
    
    
 });  

</script>