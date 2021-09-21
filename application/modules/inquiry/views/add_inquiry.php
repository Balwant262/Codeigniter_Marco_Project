<style type="text/css">
  .popup{
    width:900px !important;
  }
</style>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'inquiry/add'?>" method="post">
  <?php if($inquiryData->inquiry_id==''){?>
    <h4> Add Inquiry </h4>
  <?php }else{ ?>
    <h4> Edit Inquiry </h4>
  <?php } ?>
			<input type="hidden" name="inquiry_id" value="<?php echo $inquiryData->inquiry_id ?>" />


			<div class="box-form " >
        <div class="col-sm-12 row">
        <div class="col-md-3">
              <div class="form-group">
                <label for="">Inquiry Reference No.</label>
                <input type="text" name="inqrefno" id="inqrefno" class="form-control" value="<?php echo $inquiryData->inqrefno; ?>" placeholder="Inquiry Reference No." onchange="checkref()">
                <span id="cn" style="color: red; display:none;">Reference No already exist.</span>
          </div>
         </div>
            <div class="col-md-3">
              <div class="form-group">
                <label for="">Marco Reference No.</label>
                <input type="text" name="marco_inqrefno" id="marco_inqrefno" class="form-control" value="<?php echo $inquiryData->marco_inqrefno; ?>" placeholder="Marco Reference No." onchange="checkref()">
                <span id="cn" style="color: red; display:none;">Reference No already exist.</span>
          </div>
         </div>
          <div class="col-md-3">
              <div class="form-group">
                <label for="">Existing Customer</label>
                 <select name="exist_cust" id="exist_cust" class="form-control" onchange="changenew();changelead();">
              <option value="">Select</option>
              <?php foreach ($custData as  $cust) { ?>
              <option value="<?php echo $cust->customer_id; ?>" <?php if (($cust->customer_id) == ($inquiryData->exist_cust)) { echo "selected"; } ?>><?php echo $cust->co_name; ?></option>
            <?php   } ?>
            </select>
          </div>
         </div>
            
            <div class="col-md-2" id="div_address" <?php if($inquiryData->inquiry_id==''){ echo 'style="display:none;"';}?>>
              <div class="form-group">
                <label for="">Customer Address</label>
                 <select name="cust_address" id="cust_address" class="form-control">
                        <option value="">Select Address</option>
              
            </select>
          </div>
         </div>
            
         <!-- <div class="col-md-3">
              <div class="form-group">
                <label for="">Existing Leads</label>
                 <select name="exist_leads" id="exist_leads" class="form-control" onchange="changenew();changecustom();">
              <option value="">Select</option>
              <?php foreach ($leadsData as  $lead) { ?>
              <option value="<?php echo $lead->inquiry_id; ?>" <?php if (($lead->inquiry_id) == ($inquiryData->exist_leads)) { echo "selected"; } ?>><?php echo $lead->lead_coname; ?></option>
            <?php   } ?>
            </select>
          </div>
         </div>-->
      <?php //if($inquiryData->inquiry_id==''){?>
          <div class="col-md-1">
              <div class="form-group">
                <label for="">New</label><br>
                <input type="checkbox" onchange="changecust()" name="new" id="new" class="" value="1" <?php if($inquiryData->new==1) {echo "checked";}  ?>>
          </div>
         </div>
       <?php //} ?>
        </div>
         <div class="col-md-6 hidee">
              <div class="form-group">
                <label for="">Company Name</label>
                <input type="text" name="inq_coname" id="inq_coname" value="<?php echo $inquiryData->inq_coname; ?>" class="form-control" placeholder="Company Name" >
              </div>
            </div>
            <div class="col-md-6 hidee">
              <div class="form-group">
                <label for="">Company Email</label>
                <input type="email" name="inq_coemail" id="inq_coemail" value="<?php echo $inquiryData->inq_coemail; ?>" class="form-control" placeholder="Company Email" >
              </div>
            </div>
            <div class="col-md-6 hidee">
              <div class="form-group">
                <label for="">Contact Person</label>
                <input type="text" name="inq_coperson" value="<?php echo $inquiryData->inq_coperson; ?>" class="form-control" placeholder="Contact Person">
              </div>
            </div>
            <div class="col-md-6 hidee">
              <div class="form-group">
                <label for="">Contact Person Email</label>
                <input type="email" name="inq_copersemail" value="<?php echo $inquiryData->inq_copersemail; ?>" class="form-control" placeholder="Email" >
              </div>
            </div>
            <div class="col-md-6 hidee">
              <div class="form-group">
                <label for="">Phone</label>
                <input type="text" name="inq_phone" id="phone" value="<?php echo $inquiryData->inq_phone; ?>" class="form-control" placeholder="Phone No." >
               
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Inquiry Date</label>
               <input type="date" name="inq_date_created" id="inq_date_created" class="form-control" value="<?php echo $inquiryData->inq_date_created; ?>">
              </div>
              <br>
            </div>
            <div class="col-md-6 hidee">
              <div class="form-group">
                <label for="">Address</label>
               <textarea type="text" name="inq_address" class="form-control" placeholder="Address">
                 <?php echo $inquiryData->inq_address; ?>
               </textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Special Terms And Conditions By Client At Time Of Enquiry</label>
               <textarea type="text" name="special_terms_condition" class="form-control" placeholder="Special Terms And Conditions By Client At Time Of Enquiry">
                  <?php echo $inquiryData->special_terms_condition; ?>
               </textarea>
              </div>
            </div>
                  
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Technical Data Provided</label>
               <div class="row"> 
                    <div class="col-sm-6"> <input type="file" name="technical_data" id="technical_data" value="<?php echo $inquiryData->technical_data; ?>" class="form-control"></div>
                    <div class="col-sm-6"> <input type="file" name="technical_data2" id="technical_data2" value="<?php echo $inquiryData->technical_data2; ?>" class="form-control"></div> 
                </div> 
                
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Catalog Scan Provided</label>
                <div class="row"> 
                    <div class="col-sm-6"> <input type="file" name="catalog_scan" id="catalog_scan" value="<?php echo $inquiryData->catalog_scan; ?>" class="form-control"></div>
                    <div class="col-sm-6"> <input type="file" name="catalog_scan2" id="catalog_scan2" value="<?php echo $inquiryData->catalog_scan2; ?>" class="form-control"></div> 
                </div> 
                
               
              </div>
            </div>
                            
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Additional Details Of Contractor Attending Site</label>
                <input type="text" name="contractor_attending" id="phone" value="<?php echo $inquiryData->contractor_attending; ?>" class="form-control" placeholder="Additional Details Of Contractor Attending Site" >
               
              </div>
            </div>
                  
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Client Contact</label>
                <input type="text" name="client_contact" id="phone" value="<?php echo $inquiryData->client_contact; ?>" class="form-control" placeholder="Client Contact" >
               
              </div>
            </div>
                            
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Cellphone Number</label>
                <input type="text" name="cellphone_number" id="phone" value="<?php echo $inquiryData->cellphone_number; ?>" class="form-control" placeholder="Cellphone Number" >
               
              </div>
            </div>                 
                  
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Enquiry Assigned To</label>
                <select name="user_id_assign_to" class="form-control" required>
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($inquiryData->user_id_assign_to == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
               
              </div>
            </div>
                            
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Additional Information Mandatory To Provide</label>
               <textarea type="text" name="additioninfor" class="form-control" placeholder="Additional Information Mandatory To Provide">
                  <?php echo $inquiryData->additioninfor; ?>
               </textarea>
              </div>
            </div>

            <div class="col-md-12">
        <div class="table-responsive">  
         <table class="table table-bordered" id="dynamic_field1">  
              <tr>
        <th style="width:130px;">Products</th>
        <th style="width:130px;">Assembly Products</th>
        <th style="width:130px;">Make</th>
        <th style="width:130px;">Model</th>
        
        <th style="width:120px;">Description</th>
        <th style="width:120px;">Quantity</th>
        <th style="width:120px;">Price</th>

        <th ></th>
      </tr>
      <?php 
                                  
                if($inquiryData->inquiry_id!=''){  
                
             $j=1; 
            
              
               foreach ($inquiry_follow_up as $object) {  
              
              ?>


      <tr  id="row" class="">
        <td style="width:130px;"><select name="products<?php echo $j; ?>" class="form-control partnm" id="products<?php echo $j; ?>" onchange="changeAss(<?php echo $j; ?>)">
      <option value="">Select</option>
              <?php foreach ($productData as  $products) { ?>
              <option value="<?php echo $products->product_id; ?>" <?php if (($products->product_id) == ($object->products)) { echo "selected"; } ?>><?php echo $products->part_no; ?></option>
            <?php   } ?>
    
      </select>
          </td>
          <td style="width:130px;">
            <select name="assemblyprod<?php echo $j; ?>"   class="form-control assemble" id="assemblyprod<?php echo $j; ?>" onchange="changepro(<?php echo $j; ?>)" >
     <option value="">Select</option>

     <?php foreach ($assembleData as  $assemble) { ?>
              <option value="<?php echo $assemble->assemble_id; ?>" <?php if (($assemble->assemble_id) == ($object->assemblyprod)) { echo "selected"; } ?>><?php echo $assemble->part_name; ?></option>
            <?php   } ?>
    
      </select>

          </td>
          
          <td style="width:130px;">
                    
                    <select class="form-control select2 make"  id="make<?php echo $j ?>" name="make<?php echo $j ?>"> 
                        <option value="">Select Make</option>    
                        <?php foreach($makes as $m){?>
                            <option value="<?php echo $m->make_id; ?>" <?php if($object->make_id == $m->make_id){ echo "selected"; } ?>><?php echo $m->make_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                <td style="width:130px;">
                    
                    <select class="form-control select2 model"  id="model<?php echo $j ?>" name="model<?php echo $j ?>"> 
                        <option value="">Select Model</option>    
                        <?php foreach($models as $city){?>
                            <option value="<?php echo $city->model_id; ?>" <?php if($object->model_id == $city->model_id){ echo "selected"; } ?>><?php echo $city->model_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                
          
          <td style="width:120px;"><input type="text" id="description<?php echo $j; ?>"  name="description<?php echo $j; ?>" onchange="prodblank(<?php echo $j; ?>)" value="<?php echo $object->description; ?>" class="form-control " placeholder="" >
          </td>
          <td style="width:120px;"><input type="number" id="qty<?php echo $j; ?>"  name="qty<?php echo $j; ?>" value="<?php echo $object->qty; ?>" class="form-control " placeholder="" required="">
          </td>
          <td style="width:120px;"><input type="number" id="price<?php echo $j; ?>"  name="price<?php echo $j; ?>" value="<?php echo $object->price ?>" class="form-control " placeholder="" required="">
          </td>
          <?php  $j++; } 
        if($inquiryData->inquiry_id!=''){
         ?>
         <input type="hidden" name="number" id="number" value="<?php echo $j-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number" id="number" value="1">
        <?php } ?>

        <td><button type="button" name="edit" id="edit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button></td> 
        
        
        </tr>
        
        <?php } else{ ?>

        <tr id="row">
            <td style="width:130px;"><select name="products1" onchange="changeAss(1)"   class="form-control partnm" id="products1" >
        <option value="">Select</option>

        <?php
        foreach($productData as $products){ ?>
        <option value="<?php echo $products->product_id; ?>"  <?php if(($object->products) == ($products->product_id)){ echo "selected"; } ?>    ><?php echo $products->part_no; ?></option>
        <?php } ?>
      
        </select></td>
        <td style="width:130px;">
            <select name="assemblyprod1" onchange="changepro(1)"  class="form-control assemble" id="assemblyprod1" >
      <option value="">Select</option>

      <?php foreach($assembleData as $assemble){ ?>
      <option value="<?php echo $assemble->assemble_id; ?>"  <?php if(($object->assemble_prod) == ($assemble->assemble_id)){ echo "selected"; } ?>    ><?php echo $assemble->part_name; ?></option>
      <?php } ?>
      </select>
          </td>
          
          <td style="width:130px;">
                    
                    <select class="form-control select2"  id="make1" name="make1"> 
                        <option value="">Select Make</option>    
                        <?php foreach($makes as $m){?>
                            <option value="<?php echo $m->make_id; ?>" <?php if($object->make_id == $m->make_id){ echo "selected"; } ?>><?php echo $m->make_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
                <td style="width:130px;">
                    
                    <select class="form-control select2"  id="model1" name="model1"> 
                        <option value="">Select Model</option>    
                        <?php foreach($models as $city){?>
                            <option value="<?php echo $city->model_id; ?>" <?php if($object->model_id == $city->model_id){ echo "selected"; } ?>><?php echo $city->model_name; ?></option>
                                <?php } ?>
                        </select>
                </td>
          
          <td style="width:120px;"><input type="text" id="description1" onchange="prodblank(1)"  name="description1" value="" class="form-control " placeholder="" >
          </td>
          <td style="width:120px;"><input type="number" id="qty1"  name="qty1" value="" class="form-control " placeholder="" required="">
          </td>
          <td style="width:120px;"><input type="number" id="price1"  name="price1" value="" class="form-control " placeholder="" required="">
          </td>

          <input type="hidden" name="number" id="number" value="1">
      
                <td><button type="button" name="add1" id="add1" class="btn btn-sm btn-success"><i class="fa fa-plus"></i></button></td>
                
                 <?php } ?>
               </tr>

             </table>
           </div>
         </div>






          <div class="col-md-6">
              <div class="form-group">
                <label for="">Status Inquiry</label>
                
                <select name="inqstatus" id="inqstatus" class="form-control">
                  <option value="">Select</option>
                  <option value="1" <?php if($inquiryData->inqstatus==1) {echo "selected";}  ?>>Inquiry Recieved </option>
                  <option value="2" <?php if($inquiryData->inqstatus==2) {echo "selected";}  ?>>Quotation Sent</option>
                  <option value="3" <?php if($inquiryData->inqstatus==3) {echo "selected";}  ?>>Quotation Approved</option>
                  <option value="4" <?php if($inquiryData->inqstatus==4) {echo "selected";}  ?>>Lost</option>
                </select>
          </div>
         </div>
           <div class="col-md-6 showonlost" style="display:none;">
              <div class="form-group">
                <label for="">Reason For Lost</label>
                
                <select name="lostreason" id="lostreason" class="form-control">
                  <option value="">Select</option>
                  <option value="1"<?php if($inquiryData->lostreason==1) {echo "selected";}  ?>>Product Not Available </option>
                  <option value="2"<?php if($inquiryData->lostreason==2) {echo "selected";}  ?>>Quotation Too High</option>
                  <option value="3"<?php if($inquiryData->lostreason==3) {echo "selected";}  ?>>Customer did not Respond</option>
                 
                </select>
          </div>
         </div>

         <div class="col-md-6">
              <div class="form-group">
                <label for="">Status Description</label>
                <textarea class="form-control" name="statusdescription">
                  <?php echo $inquiryData->statusdescription; ?>
                </textarea> 
          </div>
         </div>

                            
         
                            
                            
                         
                            
                            
                <div class="col-md-12">  
           <label style="font-size: 17px;">Queries To Confirm From Client: </label>
              <div class="form-group">  

                  <div class="table-responsive"> 
                  <table class="table table-bordered" id="dynamic_field2" style="width: 100%">  
                <tr>
                <th style="width:24%">Queries</th>
                <th style="width:24%">Date</th>
                <th style="width:24%">Remarks</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($inquiryData->inquiry_id!=''){  
                
             $j=1; 
            
              
               foreach ($a_statuss as $object) {  
              
              ?>
              <tr  id="row<?php echo $j ?>" class="">
                <td style="width:80px"><input  type="text" class="form-control " id="a_status<?php echo $j; ?>" name="a_status<?php echo $j ?>" value="<?php echo $object->a_status ?>" /></td>
                 <td style="width:80px"><input  type="date" class="form-control " id="a_date<?php echo $j; ?>" name="a_date<?php echo $j ?>" value="<?php  if($object->a_date!=''){ $date=date_create($object->a_date); echo date_format($date,"Y-m-d"); }?>" /></td>
                  <td style="width:80px"><input  type="text" class="form-control " id="a_remark<?php echo $j; ?>" name="a_remark<?php echo $j ?>" value="<?php echo $object->a_remark ?>" /></td>
                   <?php  $j++; } 
        if($inquiryData->inquiry_id){
         ?>
         <input type="hidden" name="number2" id="number2" value="<?php echo $j-1 ?>">
        <?php } else { ?>
        <input type="hidden" name="number2" id="number2" value="1">
        <?php } ?>
        <td><button type="button" name="edit" id="edit2" class="btn btn-success"><i class="fa fa-plus"></i></button></td> 
              </tr>
              <?php }else{ ?> 
                <tr id="row">
                <td style="width:80px"><input  type="text" class="form-control " id="a_status1" name="a_status1" value="" /></td>
                 <td style="width:80px"><input  type="date" class="form-control " id="a_date1" name="a_date1" value="" /></td>
                  <td style="width:80px"><input  type="text" class="form-control " id="a_remark1" name="a_remark1" value="" /></td>
                  <input type="hidden" name="number2" id="number2" value="1">
                  <td><button type="button" name="add1" id="add2" class="btn btn-success"><i class="fa fa-plus"></i></button></td>
                </tr>
                   <?php } ?>

            </table>

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
                <th style="width:24%">User</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($inquiryData->inquiry_id!=''){  
                
             $j4=1; 
            
              
               foreach ($lead_follows as $object) {  
              
              ?>
              <tr  id="row<?php echo $j4 ?>" class="">
                <td style="width:80px"><input  type="text" class="form-control " id="fl_remark<?php echo $j4; ?>" name="fl_remark<?php echo $j4 ?>" value="<?php echo $object->fl_remark ?>" /></td>
                 <td style="width:80px"><input  type="date" class="form-control " id="fl_date<?php echo $j4; ?>" name="fl_date<?php echo $j4 ?>" value="<?php  if($object->fl_date!=''){ $date=date_create($object->fl_date); echo date_format($date,"Y-m-d"); }?>" /></td>
                 <td style="width:80px">
                     <select name="user_id<?php echo $j4; ?>" class="form-control" required>
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>" <?php if($object->user_id == $user->users_id) echo 'selected'; ?>><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
                 </td>
                 
                   <?php  $j4++; } 
        if($inquiryData->inquiry_id){
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
                 <td style="width:80px">
                     <select name="user_id1" class="form-control" required>
                    <option value=''>Select User</option>
                    <?php foreach ($users as $user) {  ?>
                    <option value="<?php echo $user->users_id; ?>"><?php echo $user->fname; ?></option>
                    <?php }  ?>
                    </select>
                 </td>
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
                <th style="width:24%">Download</th>
                <th style="width:3%">        </th>
              </tr>
              <?php 
                                  
                if($inquiryData->inquiry_id!=''){  
                
             $j5=1; 
            
              
               foreach ($lead_photos as $object) {  
                   
              ?>
              <tr  id="row<?php echo $j5 ?>" class="">
                <td style="width:80px"><input  type="file" class="form-control " id="photo_g<?php echo $j5; ?>" name="media<?php echo $j5 ?>" value="<?php echo $object->image ?>" /></td>
                 <td style="width:80px"><a href="<?php echo base_url('assets/customer_gallery/'.$object->image) ?>">Download</a></td>
                   <?php  $j5++; } 
        if($inquiryData->inquiry_id){
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


     
              
              
              
              
              
              
              
              
              
              
              
              
              
      
			
 			 
			</div>


          


		<div>

         <?php if(!empty($inquiryData->inquiry_id)){?>
        <input type="hidden"  name="inquiry_id" value="<?php echo isset($inquiryData->inquiry_id)?$inquiryData->inquiry_id:'';?>">

        <div class="box-footer sub-btn-wdt">
          <button type="submit" id="submit" name="edit"  value="edit" class="btn btn-success wdt-bg">Update</button>
        </div>
              <!-- /.box-body -->
        <?php }else{?>
        <div class="box-footer sub-btn-wdt">
          <button type="submit" id="submit" name="submit"  value="add" class="btn btn-success wdt-bg">Add</button>
        </div>
        <?php }?>

		</div>
      
      </form>

<style type="text/css">
  .select2-container{
 width: 100% !important;
}
.popup{
  width:700px;
}

</style>
<script type="text/javascript">
  function checkref(){
        var ref = document.getElementById("inqrefno").value;
        if (ref!='') {
          $.ajax({
                  url : $('body').attr('data-base-url') + 'inquiry/checkref',   
                    method: 'post',
                    data: {ref: ref},
                    dataType: 'text',
                    success: function(data){
                       console.log(data);
                        if (data==1) {
                          $('.cn').show();
                          alert('refrence no already exists');
                          $('#submit').hide();
                        }else{
                           $('.cn').hide();
                            $('#submit').show();
                        }
                    }
                 });
                  }      
  }


  $(document).ready(function(){
      <?php if(!empty($inquiryData->inquiry_id)){?>
 var cust_id = <?php echo $inquiryData->exist_cust;?>; 
 var cust_address = <?php echo $inquiryData->cust_address;?>; 
$.ajax({
      url : $('body').attr('data-base-url') + 'inquiry/get_customer_address',     
      method: 'post', 
      data : {customer_id:cust_id}
    }).done(function(data) { 
      //console.log(data);
      $('#cust_address').empty();
      servers = $.parseJSON(data);
       $('#cust_address').append('<option>Select Address</option>');
      $.each(servers, function(index, value) {
          //alert(servers[index].id);
          $('#cust_address').append('<option value='+servers[index].id+' <?php if($inquiryData->cust_address == ''){echo 'Selected';} ?> >'+servers[index].address_line_1+','+servers[index].address_line_2+','+servers[index].landmark+'</option>');
      });
      $("#cust_address").val(cust_address).change(); 
     });
     
     
    
      <?php }?>
  
  
    $("#exist_cust").select2()
   // $("#exist_leads").select2()
    var i=1;
    var i2=1;
    var i3=1;
    var i4=1;

    $('#add1').click(function(){
      i++;
      $('#dynamic_field1').append('<tr id="row'+i+'"><td class="partnm" id="td'+i+'"></td><td class="assemble" id="tda'+i+'"></td><td class="make" id="tdb'+i+'"></td><td class="model" id="tdc'+i+'"></td><td width="160"><input type="text" id="description'+i+'" onchange="prodblank('+i+')"  name="description'+i+'" class="form-control " placeholder=""></td><td width="160"><input type="number" id="qty'+i+'"  name="qty'+i+'" class="form-control " placeholder=""></td><td width="160"><input type="number" id="price'+i+'"  name="price'+i+'" class="form-control " placeholder=""></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      
      $('#products'+(i-1)+'').clone().attr('id', 'products'+i+'').attr('name', 'products'+i+'').attr('onchange','changeAss('+i+')').appendTo($('#td'+i+''));
      $('#assemblyprod'+(i-1)+'').clone().attr('id', 'assemblyprod'+i+'').attr('name', 'assemblyprod'+i+'').attr('onchange','changepro('+i+')').appendTo($('#tda'+i+''));
      $('#make'+(i-1)+'').clone().attr('id', 'make'+i+'').attr('name', 'make'+i+'').appendTo($('#tdb'+i+''));
      $('#model'+(i-1)+'').clone().attr('id', 'model'+i+'').attr('name', 'model'+i+'').appendTo($('#tdc'+i+''));
     
     document.getElementById('products'+i+'').selectedIndex = 0;
     document.getElementById('assemblyprod'+i+'').selectedIndex = 0;
     document.getElementById('make'+i+'').selectedIndex = 0;
     document.getElementById('model'+i+'').selectedIndex = 0;
      
      document.getElementById("number").value=i;
      $(function () {
      $('#number').val(i);
    });
    });
    
    $('#add2').click(function(){
      i2++;
      $('#dynamic_field2').append('<tr id="row'+i2+'"><td><input type="text" class="form-control"  id="a_status'+i2+'" name="a_status'+i2+'"/></td><td><input type="date" class="form-control"  id="a_date'+i2+'" name="a_date'+i2+'"/></td><td><input type="text" class="form-control"  id="a_remark'+i2+'" name="a_remark'+i2+'"/></td><td><button type="button" name="remove" id="'+i2+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      
      document.getElementById("number2").value=i2;
      $(function () {
      $('#number2').val(i2);
    });
    });
    
     $('#add_flt').click(function(){  
     i3++;
           $('#dynamic_flt').append('<tr id="row'+i3+'"><td><input type="text" class="form-control"  id="fl_remark'+i3+'" name="fl_remark'+i3+'"/></td><td><input type="date" class="form-control"  id="fl_date'+i3+'" name="fl_date'+i3+'"/></td><td><select class="form-control select2"  id="user_id'+i3+'" name="user_id'+i3+'"> <?php foreach($users as $user){?><option value="<?php echo $user->user_id; ?>"><?php echo $user->fname; ?></option><?php } ?></select></td><td><button type="button" name="remove" id="'+i3+'" class="btn btn-danger btn_remove_flt">X</button></td></tr>');
       
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
      
         
        $(document).on('click', '.btn_remove2', function(){        
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
    var k2=$('#number2').val();
    var kc=$('#number_flt').val();
    var kd=$('#number_photo').val();

      $('#edit').click(function(){  
    
           k++;  
           $('#dynamic_field1').append('<tr id="row'+k+'"><td class="partnm" id="td'+k+'"></td><td class="assemble" id="tda'+k+'"></td><td class="make" id="tdb'+k+'"></td><td class="model" id="tdc'+k+'"></td><td width="160"><input type="text" id="description'+k+'" onchange="prodblank('+k+')"  name="description'+k+'" class="form-control " placeholder=""></td><td width="160"><input type="number" id="qty'+k+'"  name="qty'+k+'" class="form-control " placeholder=""></td><td width="160"><input type="number" id="price'+k+'"  name="price'+k+'" class="form-control " placeholder=""></td><td><button type="button" name="remove" id="'+k+'" class="btn btn-danger btn_remove">X</button></td></tr>');
      
      $('#products'+(k-1)+'').clone().attr('id', 'products'+k+'').attr('name', 'products'+k+'').attr('onchange','changeAss('+k+')').appendTo($('#td'+k+''));
      $('#assemblyprod'+(k-1)+'').clone().attr('id', 'assemblyprod'+k+'').attr('name', 'assemblyprod'+k+'').attr('onchange','changepro('+k+')').appendTo($('#tda'+k+''));
      $('#make'+(k-1)+'').clone().attr('id', 'make'+k+'').attr('name', 'make'+k+'').appendTo($('#tdb'+k+''));
      $('#model'+(k-1)+'').clone().attr('id', 'model'+k+'').attr('name', 'model'+k+'').appendTo($('#tdc'+k+''));
     
     document.getElementById('products'+k+'').selectedIndex = 0;
     document.getElementById('assemblyprod'+k+'').selectedIndex = 0;
     document.getElementById('make'+k+'').selectedIndex = 0;
     document.getElementById('model'+k+'').selectedIndex = 0;
     
      document.getElementById("number").value=k;
      $(function () {
      $('#number').val(k);
      
    });
      });  
      
      
      $('#edit2').click(function(){  
    
           k2++;  
           $('#dynamic_field2').append('<tr id="row'+k2+'"><td><input type="text" class="form-control"  id="a_status'+k2+'" name="a_status'+k2+'"/></td><td><input type="date" class="form-control"  id="a_date'+k2+'" name="a_date'+k2+'"/></td><td><input type="text" class="form-control"  id="a_remark'+k2+'" name="a_remark'+k2+'"/></td><td><button type="button" name="remove" id="'+k2+'" class="btn btn-danger btn_remove2">X</button></td></tr>');
       
      document.getElementById("number2").value=k2;
      $(function () {
      $('#number2').val(k2);
      
    });
      }); 
    
      $('#edit_flt').click(function(){  
     kc++;
           $('#dynamic_flt').append('<tr id="row'+kc+'"><td><input type="text" class="form-control"  id="fl_remark'+kc+'" name="fl_remark'+kc+'"/></td><td><input type="date" class="form-control"  id="fl_date'+kc+'" name="fl_date'+kc+'"/></td><td><select class="form-control select2"  id="user_id'+kc+'" name="user_id'+kc+'"> <?php foreach($users as $user){?><option value="<?php echo $user->user_id; ?>"><?php echo $user->fname; ?></option><?php } ?></select></td><td><button type="button" name="remove" id="'+kc+'" class="btn btn-danger btn_remove">X</button></td></tr>');
       
      document.getElementById("number_flt").value=kc;
      $(function () {
      $('#number_flt').val(kc);
      
    });
      }); 
      
       $('#edit_photo').click(function(){  
     kd++;
           $('#dynamic_photo').append('<tr id="row'+kd+'"><td><input type="file" class="form-control"  id="photo_g'+kd+'" name="media'+kd+'"/></td><td><button type="button" name="remove" id="'+kd+'" class="btn btn-danger btn_remove_photo">X</button></td></tr>');
       
      document.getElementById("number_photo").value=kd;
      $(function () {
      $('#number_photo').val(kd);
      
    });
      }); 
      
      
      
      
      
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           k--; 
      }); 
      
      $(document).on('click', '.btn_remove2', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove(); 
           k2--; 

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



  $(document).ready(function() { 
    var newval=document.getElementById('new').value;
    if(newval==1){
       $('.hidee').show();
    }else{
    $('.hidee').hide();
  }
  $('#inqstatus').change(function(){
  var status1=document.getElementById('inqstatus').selectedIndex;
  if(status1==4){
       $('.showonlost').show();
  }else{
     $('.showonlost').hide();
  }
  });
  });

       function changeAss(n1){
       
            document.getElementById('assemblyprod'+n1).selectedIndex = 0; 
            var val1=$('#products'+n1).val();
           
       $.ajax({
      url : $('body').attr('data-base-url') + 'inquiry/getprice',     
      method: 'post', 
      data : {val1:val1}
    }).done(function(data) { 
      console.log(data);
       $("#price"+n1).val(data);
     });
       }
       function changepro(n1){
        document.getElementById('products'+n1).selectedIndex = 0;
      var val1=$('#assemblyprod'+n1).val();
           
       $.ajax({
      url : $('body').attr('data-base-url') + 'inquiry/getpriceass',     
      method: 'post', 
      data : {val1:val1}
    }).done(function(data) { 
      console.log(data);
       $("#price"+n1).val(data);
     });
       }
        function changecustom(){
       
            document.getElementById('exist_cust').selectedIndex = 0; 
             document.getElementById('new').value=0;
              $('#new').prop('checked', false);
            $('.hidee').hide();
            
       }
       function changelead(){
        // document.getElementById('exist_leads').selectedIndex = 0;
         document.getElementById('new').value=0;
          $('#new').prop('checked', false);
         $('.hidee').hide();
         $('#div_address').show();
         var cust_id = $('#exist_cust').val();
         //alert(cust_id);
         $.ajax({
            url : $('body').attr('data-base-url') + 'inquiry/get_customer_address',     
            method: 'post', 
            data : {customer_id:cust_id}
          }).done(function(data) { 
            //console.log(data);
            $('#cust_address').empty();
            servers = $.parseJSON(data);
             $('#cust_address').append('<option>Select Address</option>');
            $.each(servers, function(index, value) {
                //alert(servers[index].id);
                $('#cust_address').append('<option value='+servers[index].id+'>'+servers[index].address_line_1+','+servers[index].address_line_2+','+servers[index].landmark+'</option>');
            });
           });
         
         
         
       }
       function changenew(){ 
         document.getElementById('new').value=0;
          $('#new').prop('checked', false);
       }
       function changecust(){
         //document.getElementById('exist_leads').selectedIndex = 0;
          document.getElementById('exist_cust').selectedIndex = 0;
           document.getElementById('new').value=1;
           $('#new').prop('checked', true);
           $('.hidee').show();
           $('#div_address').hide();
       }
       
</script>