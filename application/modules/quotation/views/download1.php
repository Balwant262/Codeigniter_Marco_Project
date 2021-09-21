<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
<style type="text/css">
	.col-sm-6{
		width: 50%;
		display: inline-block;
	}
 th,td{
    padding:5px;
  }
</style>

<h3 class="box-title" align="center" style="margin-bottom: 25px;">Quotation Details</h3>
			<?php 

		
			
			$inquiryData = getDataByid('inquiry',$quotationData->inquiry,'inquiry_id');
			if($inquiryData->exist_cust!='0'){
			$customerData = getDataByid('customers',$inquiryData->exist_cust,'customer_id');
			}
			$termsData =$this->Quotation_model->get_data_by('terms');
    $currency =$quotationData->currecncytype;
    if($quotationData->currecncytype=='1'){
          $currency="INR";
        }else if($quotationData->currecncytype=='2'){
          $currency="USD";
        }else if($quotationData->currecncytype=='3'){
          $currency="EUR";
        }else if($quotationData->currecncytype=='4'){
          $currency="GBP";
        }
      	

			?>
		
		      <div class="col-sm-6 row">
              <p class="text-left"> <b>Reference No:  <?php echo $inquiryData->inqrefno; ?></b></p>        
         </div>
          <div class="col-sm-6 row">     
              <p class="text-right" style="padding-right:30px"> Date: <?php
                $date=date_create($quotationData->quot_Date);
echo date_format($date,"d/m/Y"); ?> </p>
        </div>
		  
		  
    
        <p class="text-left">
             
                <b>M/s.  <?php if($inquiryData->exist_cust!='0'){
                  echo $customerData->co_name;
                }
                else{
                echo $inquiryData->inq_coname; } ?>
               </b>
            
        </p>
		  <p class="text-left">
              <?php  $address = $customerData->cust_address1.$customerData->cust_city.$customerData->cust_state.$customerData->cust_country.$customerData->cust_pin ; 
              echo wordwrap($address,25,"<br>\n");
              ?><bR>
                   <?php if($inquiryData->exist_cust!='0'){
                  echo $customerData->email;
                }
                else{
                echo $inquiryData->inq_coemail; } ?>
                <br>
                  <?php if($inquiryData->exist_cust!='0'){
                  echo $customerData->cust_phone;
                }
                else{
                echo $inquiryData->inq_phone; } ?>
                <?php $inquiryData->inq_phone; ?>
              
        </p>

        <p class="text-left">
             
               
                
           
        </p>
    	
        <p class="text-left">
            <b>Kind Attn: <?php echo $inquiryData->inq_coperson; ?></b>
      </p>
      
    
        <p>Dear Sir, </p>
        <p>We thank you for your enquiry for Compressor Spares <b> <?php 
                      echo $quotationData->model_text; ?></b> </p>
        <p>are glad to quote our best prices are as under: -            </p>
     


		  <div class="">

			       <table border="1" class="table-responsive prod" style="width:100%;border-color:#d2d6de">
            	<thead>
            	<tr>
            	<th colspan="2">Product</th>
            	<th> Unit </th>
            	<th> Quantity </th>
            	<th> Price <b>(<?php echo $currency; ?>)</b> </th> 
            	<th> Total </th> 

              <th> Discount Type </th>
              <th> Discount </th>  
              <th> Grand Total <b>(<?php echo $currency; ?>)</b></th> 
          	    </tr></thead>
          	    <tbody>
          	    	<?php 
                  foreach ($quotation_followupData as $key => $value) { 

                     ?>
          	    	<tr >
          	    		<td>

          	    		<?php // print_r($value);
                     if($value->product!=0){
                  $pros = getDataByid('products',$value->product,'product_id');
                    echo $this->Quotation_model->getproductName($value->product); 
                    $prodman_code =$this->Quotation_model->getprodmcode($value->product); 
                    }elseif ($value->assem_prof!=0){
                    $assem = getDataByid('assemble',$value->assem_prof,'assemble_id');
                      echo $this->Quotation_model->getassproductName($value->assem_prof);
                      $assm_code =$this->Quotation_model->getassmanufactcode($value->assem_prof);
                    }else{
                         echo $value->desc;
                      }?>
                      
                    </td>
          	    		<td><?php echo $prodman_code."".$assm_code; ?></td> 
                    <td><?php echo $pros->unit.$assem->unit;  ?> </td>
          	    		<td class="text-right"><?php echo $value->quot_qty; ?></td>
          	    		<td class="text-right"><?php echo $value->quot_price; ?></td>
          	    		<td class="text-right"><?php echo $value->quot_amt; ?></td>
                    <?php if($value->quot_disc!='' ||$value->quot_disc!=0){ ?>
          	    		<td><?php if($value->quot_disc_typ==1){echo "Percentage";}else{
          	    			echo "Flat";
          	    		} ?></td>

          	    		<td class="text-right"><?php echo $value->quot_disc; ?></td>
          	    		<td class="text-right"><?php echo $value	->quot_total; ?></td>
          	    		<?php } ?>
          	    	</tr>	
          	    <?php 	} ?>
    			</tbody>
    			<tfoot>
    				<tr>
    				<td colspan="8">Total</td>
    				<td class="text-right"><?php echo $quotationData->grandtotal; ?></td>
    				</tr>
    				<?php if($quotationData->discount!=0) {  ?>
    				<tr>
    				
    				<td colspan="4">Discount Type</td>
    				<td>
    				<?php if($quotationData->discounttype==1){echo "Percentage";}else{
          	    			echo "Flat";
          	    		} ?>
          	    	</td>
          	    	<td colspan="3">Discount </td>
    				<td class="text-right"><?php echo $quotationData->discount; ?></td>
    				</tr>
    				<tr>
    				<td colspan="8">Grand Total</td>
    				<td class="text-right"><?php echo $quotationData->alltotaftdisc; ?></td>
    				</tr>
    			<?php } ?>
    			</tfoot>
		</table>		 
	</div>
	<div class="row">
		<div class="col-sm-12">
		<p>
				Terms: </p>
			<p class="" >
				 <?php 	$term=explode(",",$quotationData->term); 
				 
				 foreach ($termsData as $key => $value) {
				 if(in_array($value->terms_id,$term))
				 	{  echo $value->terms_descr."<br>";} 
				 }

				  ?></p>
			</div>
		</div>
	</div><br>
  <p >We await your valued order at the earliest.          </p>
  <p ><b>For Marco Air Control Services,    </b></p>
  <p ><b><i><u>HARPREET SINGH  </u></i></b></p>
  <p ><b>Partner           </b></p>   
	