<style type="text/css">
	.popup{
		width:900px !important;
	}
  .d-none{
    display: none;
  }
  tr td{
    padding:5px;
  }
  .table>tbody>tr>td{
    padding: 5px;
  }
</style>

<?php 
$quot=$this->db->Select('*')->from('quotation')->where('quotation_id',$orderData->quotation)->get();
$quot1=$quot->row();
//print_r($quot1);
$quotfollow=$this->db->Select('*')->from('quotaion_products')->where('quot_id',$orderData->quotation)->get();
$quotfollow=$quotfollow->result();
//print_r($quotfollow);
 ?>

 <Select width="150" id="prod" class="d-none" name="prod" >
    <option value="">select</option>
    <?php
  foreach ($quotfollow as $key => $value) {
     //print_r($value);
    if($value->product!=0){
     
    echo  "<option value=".$value->product.">".$this->Order_model->getproductname($value->product)."</option>";
  }
  }
?>
</Select>
<Select width="150" id="assem_prod" class="d-none" name="assem_prod">
  <option value="">select</option>
    <?php
  foreach ($quotfollow as $key => $value) {
   // print_r($value->assem_prof);
    if($value->assem_prof!=0){
    echo "<option value=".$value->assem_prof.">".$this->Order_model->getassproductname($value->assem_prof)."</option>";
  }
  }
?>
</Select>
<Select width="150" id="descrip" class="d-none" name="descrip">
  <option value="">select</option>
    <?php
  foreach ($quotfollow as $key => $value) {
   // print_r($value->assem_prof);
    if($value->desc!='' || $value->desc!='undefined'){
    echo "<option value=".$value->desc.">".$value->desc."</option>";
  }
  }
?>
</Select>
<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'order/add'?>" method="post">
  <div class="box-body">
  	<input type="hidden" name="order_id" value="<?php echo $orderData->order_id; ?>">
        <input type="hidden" name="quotation_id" value="<?php echo $orderData->quotation; ?>">
        
    <div class="row">
    	 <div class="col-md-6">
              <div class="form-group">
                <label for="">Reference No </label>
                <?php $q= $this->db->Select('*')->from('inquiry')->where('inquiry_id',$orderData->inq)->get();
               	$result= $q->row(); ?>
                <input type="text" name="ref" value="<?php echo $result->inqrefno ?>" class="form-control" placeholder="Reference No" readonly>
              </div>
            </div>
              <div class="col-md-6" >
              <div class="form-group">
                <label for="">Order Date</label>
               <input required type="date" name="ord_date" id="ord_date" class="form-control" value="<?php echo $orderData->ord_date;?>" >
              </div>
              <br>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="">Order Status </label>
                
                <select name="ord_status" id="" class="form-control" required>
                  <option value="">Select</option>
                  <option value="1" <?php if($orderData->ord_status == '1'){ echo "selected"; } ?> >Pending</option>
                  <option value="2" <?php if($orderData->ord_status == '2'){ echo "selected"; } ?> >Processing</option>
                  <option value="3" <?php if($orderData->ord_status == '3'){ echo "selected"; } ?> >Completed</option>
                   <option value="4" <?php if($orderData->ord_status == '4'){ echo "selected"; } ?> >Delivered</option>

                </select>
              </div>
            </div>
            <table border="1" class="cell-border examdple1 table table-striped table1 delSelTable dataTable no-footer">
                <tr> <td><a href="<?php echo base_url().'order/download_productData/'.$orderData->quotation?>">Download Product Data to Excel</a> </td> </tr>
                <tr>
                <th> Product </th>
                <th>Quantity </th>
                <th> Price</th>
                <th>Amount</th>
                <th> Discount Type</th>
                <th>Discount </th>
                <th> Total Amount</th>
              </tr>
              <?php $totalSum=0; ?>
            <?php foreach ($quotfollow as $key => $value) { ?>
               <?php $sum = 0; ?>
             <tr> 
              <td>
                
                    <?php // print_r($value);
                     if($value->product!=0){
                 
                    echo $this->Order_model->getproductName($value->product); 
                    $prodman_code =$this->Order_model->getprodmcode($value->product); 
                    }elseif ($value->assem_prof!=0){
                    $assem = getDataByid('assemble',$value->assem_prof,'assemble_id');
                      echo $this->Order_model->getassproductName($value->assem_prof);
                      $assm_code =$this->Order_model->getassmanufactcode($value->assem_prof);
                    }else{
                         echo $value->desc;
                      } ?>
              </td>
              <td><?php echo $value->quot_qty; ?></td>
              <td><?php echo $value->quot_price; ?></td>
              <td><?php echo $value->quot_amt; ?></td>
               <td><?php if($value->quot_disc_typ=1){
                echo "Percentage";
               }else{ echo "Flat";} ?></td>
              <td><?php echo $value->quot_disc; ?></td>
              <?php $sum+= $value->quot_total; $totalSum+= $sum; ?>
                          
              <td><?php echo $value->quot_total; ?></td>
             </tr>
            <?php } ?>
             <input type="hidden" id="order_price" value="<?php  echo $totalSum; ?>">

          </table>
           <table id="examples">
               <tr>

<?php if($orderData->order_id !=''){
        ?>
        <td width="150"> <button type="button" id="addprocess" name="addprocess" class="btn btn-success">Add Processing</button></td>
      <?php } ?>
       <?php $query=$this->db->Select('*')->from('order_status')->where('order_stat',2)->where('order_no',$orderData->order_id)->get();
       // print_r($this->db->last_query());
        $result=$query->result();
        if($result){
          $display="block";
        }else{
          $display="none";
        } ?>
               </tr>
                <tr>
        <table border="1" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer" id="process">
          <tr>
            <th>Product</th>
            <th>Assembly Products</th>
            <th>Description</th>
            <th>Date</th>
            <th>Pieces</th>
            <th></th>
          </tr>
          <?php
        
        
        foreach ($result as $key => $value) { ?>
          <tr>
        <td width="180"><?php echo $this->Order_model->getproductname($value->ord_products); ?> </td>
        <td width="180"><?php echo $this->Order_model->getassproductname($value->ord_ass_products); ?> </td>
        <td ><?php echo $value->ord_description;  ?>
        <td width="180"><?php  
        $dates= date_create("$value->ord_date");
         echo date_format($dates,"d/m/Y");  ?> </td>

         <td width="180"><?php echo $value->ord_pcs; ?> </td>
          </tr>
        <?php }
         ?>

        </table>
        </tr>
             </table>
             <table id="examples">
               <tr>

<?php if($orderData->order_id !=''){
        ?>
        <td width="150"> <button type="button" id="addcompleted" name="addcompleted" class="btn btn-success">Add Completed</button></td>
      <?php } ?>

        <?php $query=$this->db->Select('*')->from('order_status')->where('order_stat',3)->where('order_no',$orderData->order_id)->get();
       // print_r($this->db->last_query());
        $result=$query->result();
        if($result){
          $display="block";
        }else{
          $display="none";
        } ?>
               </tr>
                <tr>
        <table border="1" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer" id="complete">
          <tr>
            <th>Product</th>
            <th>Assembly Products</th>
            <th>Description</th>
            <th>Date</th>
            <th>Pieces</th>
            <th></th>
          </tr>
            <?php
        
        
        foreach ($result as $key => $value) { ?>
          <tr>
        <td width="180"><?php echo $this->Order_model->getproductname($value->ord_products); ?> </td>
        <td width="180"><?php echo $this->Order_model->getassproductname($value->ord_ass_products); ?> </td>
        <td ><?php echo $value->ord_description;  ?>
        <td width="180"><?php  
        $dates= date_create("$value->ord_date");
         echo date_format($dates,"d/m/Y");  ?> </td>

         <td width="180"><?php echo $value->ord_pcs; ?> </td>
          </tr>
        <?php }
         ?>
        </table>
        </tr>
             </table>
             <table id="examples">
               <tr>

<?php if($orderData->order_id !=''){
        ?>
        <td width="150"> <button type="button" id="adddelivered" name="adddelivered" class="btn btn-success">Add Delivered</button></td>
      <?php } ?>
       <?php $query=$this->db->Select('*')->from('order_status')->where('order_stat',4)->where('order_no',$orderData->order_id)->get();
       // print_r($this->db->last_query());
        $result=$query->result();
        if($result){
          $display="block";
        }else{
          $display="none";
        } ?>
               </tr>
                <tr>
        
                <table border="1" class="cell-border example1 table table-striped table1 delSelTable dataTable no-footer" id="delivered">
          <tr>
            <th>Product</th>
            <th>Assembly Products</th>
            <th>Description</th>
            <th>Date</th>
            <th>Pieces</th>
            <th></th>
          </tr>
          <?php
        
        
        foreach ($result as $key => $value) { ?>
          <tr>
        <td width="180"><?php echo $this->Order_model->getproductname($value->ord_products); ?> </td>
        <td width="180"><?php echo $this->Order_model->getassproductname($value->ord_ass_products); ?> </td>
        <td ><?php echo $value->ord_description;  ?>
        <td width="180"><?php  
        $dates= date_create("$value->ord_date");
         echo date_format($dates,"d/m/Y");  ?> </td>

         <td width="180"><?php echo $value->ord_pcs; ?> </td>
          </tr>
        <?php }
         ?>
        </table>
        </tr>
        <tr>
            <td>Pending Amount</td>
            <td ><input class="" type="text" class="" name="pending_amount" id="pending_amount" value="<?php echo $orderData->pending_amount; ?>"></td>
        </tr>
        
             </table>

             

        </div>
        <div class="row">
		<button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
		</div>
    </div>
</form>
<script>
  $(document).ready(function(){
    var b=1;
    
    var pending_amount = $('#pending_amount').val();
    var order_price = $('#order_price').val();
    if(pending_amount==0)
        $('#pending_amount').val(order_price);
    
    
    $('#addprocess').click(function(){
      $('#process').append('<tr id="rows'+b+'"><td width="160" id="tdas'+b+'"></td><td  width="160" class="assemble" id="tda'+b+'"></td><td width="160"><input type="text" id="descrip'+b+'"  name="descrip'+b+'" class="form-control" placeholder="Description"></td><td width="160"><input type="date" name="ord_date'+b+'" id="ord_date'+b+'"class="form-control " placeholder=""></td><td width="160"><input type="text" id="process_pcs'+b+'"  name="process_pcs'+b+'" class="form-control " placeholder=""></td><td> <button onclick="submitdata('+b+',1)" type="button" class="btn btn-success">Add to Processing</button></td></tr>');
      
      $('#prod').clone().attr('id', 'selectp'+b+'').attr('name', 'prod'+b+'').attr('onchange','prodblank('+b+')').attr('class','form-control').appendTo($('#tdas'+b+''));
      $('#assem_prod').clone().attr('id', 'assemble_pr'+b+'').attr('class','form-control').attr('name', 'assemble_prod'+b+'').attr('onchange','changedesc('+b+')').appendTo($('#tda'+b+''));
      b++;
    });
  });
   $(document).ready(function(){
    var c=1;
    
    $('#addcompleted').click(function(){
      $('#complete').append('<tr id="complete'+c+'"><td width="160" id="tdasa'+c+'"></td><td  width="160" class="assemble" id="tdaa'+c+'"></td><td  width="160"><input type="text" id="descrip'+c+'"  name="descrip'+c+'" class="form-control" placeholder="Description"></td><td width="160"><input type="date" name="ord_date'+c+'" id="ord_date'+c+'"class="form-control " placeholder=""></td><td width="160"><input type="text" id="process_pcs'+c+'"  name="process_pcs'+c+'" class="form-control " placeholder=""></td><td> <button onclick="submitdata('+c+',2)" type="button" class="btn btn-success">Add to Completed</button></td></tr>');
      $('#prod').clone().attr('id', 'selectp'+c+'').attr('name', 'prod'+c+'').attr('onchange','prodblank('+c+')').attr('class','form-control').appendTo($('#tdasa'+c+''));
      $('#assem_prod').clone().attr('id', 'assemble_pr'+c+'').attr('class','form-control').attr('name', 'assemble_prod'+c+'').attr('onchange','changedesc('+c+')').appendTo($('#tdaa'+c+''));
      c++;
    });
  });
   $(document).ready(function(){
    var d=1;
    
    $('#adddelivered').click(function(){
      $('#delivered').append('<tr id="delivered'+d+'"><td width="160" id="tdasb'+d+'"></td><td  width="160" class="assemble" id="tdab'+d+'"></td><td  width="160"><input type="text" id="descrip'+d+'"  name="descrip'+d+'" class="form-control" placeholder="Description"></td><td width="160"><input type="date" name="ord_date'+d+'" id="ord_date'+d+'"class="form-control " placeholder=""></td><td width="160"><input type="text" id="process_pcs'+d+'"  name="process_pcs'+d+'" class="form-control " placeholder=""></td><td> <button onclick="submitdata('+d+',3)" type="button" class="btn btn-success">Add to Delivered</button></td></tr>');
      $('#prod').clone().attr('id', 'selectp'+d+'').attr('name', 'prod'+d+'').attr('onchange','prodblank('+d+')').attr('class','form-control').appendTo($('#tdasb'+d+''));
      $('#assem_prod').clone().attr('id', 'assemble_pr'+d+'').attr('class','form-control').attr('name', 'assemble_prod'+d+'').attr('onchange','changedesc('+d+')').appendTo($('#tdab'+d+''));
      d++;
    });
  });
   
  function prodblank(n1){
        
          document.getElementById('assemble_pr'+n1).selectedIndex = 0;
       }
  
        function changedesc(n1){
          document.getElementById('selectp'+n1).selectedIndex = 0;
          
       }
       function submitdata(q,w){
          var id ="<?php echo $orderData->order_id ?>";
          var date =document.getElementById('ord_date'+q).value;
           var pcs =document.getElementById('process_pcs'+q).value;
           var descrip =document.getElementById('descrip'+q).value;
          var product = $('#selectp'+q).children("option:selected").val();

          var assembprod =$('#assemble_pr'+q).children("option:selected").val();
           
           if(date!='' && pcs!=''){
          $.ajax({
      url : $('body').attr('data-base-url') + 'order/addblanktostatus',     
      method: 'post', 
        data : {id:id,products:product,assembprod:assembprod,date:date,pcs:pcs,status:w,descrip:descrip}
    }).done(function(data) {
     if(w==1){
      $('#process').append('<tr><td width="180">'+product+'</td><td width="180">'+assembprod+'</td><td width="180">'+descrip+'</td><td width="180">'+date+'</td><td width="180">'+pcs+'</td></tr>');
    $('#rows'+q).remove();
  }else if(w==2){
      $('#complete').append('<tr><td width="180">'+product+'</td><td width="180">'+assembprod+'</td><td width="180">'+descrip+'</td><td width="180">'+date+'</td><td width="180">'+pcs+'</td></tr>');
    $('#complete'+q).remove();
  }else if(w==3){
    $('#delivered').append('<tr><td width="180">'+product+'</td><td width="180">'+assembprod+'</td><td width="180">'+descrip+'</td><td width="180">'+date+'</td><td width="180">'+pcs+'</td></tr>');
    $('#delivered'+q).remove();
  }

    });
  }else{
  alert('enter date or quantity');
  }
}

</script>
         