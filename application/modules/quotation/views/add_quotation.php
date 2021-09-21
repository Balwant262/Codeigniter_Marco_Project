
<style>
	thead tr th,tr td{
		padding:5px;
	}
	.select2-container{
  width: 100% !important;
}
.des{
	border:1px dotted;
}
.d-none{
  display: none;
}
</style>
    
<?php 
   function getassproductName($ids){
      $query= $this->db->Select('*')->from('assemble')->where('assemble_id',$ids)->get();
      $result=$query->row();
      echo $result->part_name;
          }
    function getproductName($id){
      $query= $this->db->Select('*')->from('products')->where('product_id',$id)->get();
      $result=$query->row();
      echo $result->part_no;
          }
?>
  

<?php $this->load->view('include/header'); ?>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<div class="col-md-12">
	<div class="col-md-2"> </div>
	<div class="col-md-10" >
<form role="form bor-rad " enctype="multipart/form-data" action="<?php echo base_url().'quotation/addquotation'?>" method="post">
	<?php 
	//print_r($quotationData);
	if($quotationData->quotation_id!=''){ ?>
	<h4>Edit Quotation Details</h4>
	<?php }else{ ?>
	<h4>Add Quotation Details</h4>
	<?php } ?>
			<input type="hidden" name="quotation_id" value="<?php echo $quotationData->quotation_id ?>" />
<div class="box-form">
	<div class="row">
		<div class="col-md-4">
              <div class="form-group">
                <label  for="">Marco Reference No:</label>
              
                <select class="form-control" name="inquiry" id="inquiry" required="" onchange="getdetails()">
                	<option value="">Select</option>
                	<?php foreach ($inquireData as $key => $value) { ?>
                		<option value="<?php echo $value->inquiry_id; ?>"<?php if(($value->inquiry_id)==($quotationData->inquiry)){ echo "selected";} ?>>
                			
                                    <?php 
                                    echo $value->marco_inqrefno;
                                    //if($value->exist_cust!='0'){
//                  $query = $this->db->Select('*')->from('customers')->where('customer_id',$value->exist_cust)->get();
//          $resultss=$query->row();
//  		
//  		
//  		echo $resultss->co_name;
//                		
//                			}else{
//                				echo $value->marco_inqrefno;
//                			}
                			?>
                			
                		</option>
                	<?php } ?>
                </select>
         	</div>
         </div>
         <div class="col-md-3">
               <div class="form-group">
                <label  for="">Currency Type:</label>
                <select name="currecncytype" class="form-control">
                  <option value="1" <?php if ($quotationData->currecncytype =='1') { echo "selected"; } ?>>Rupees (INR) </option>
                  <option value="2" <?php if ($quotationData->currecncytype =='2') { echo "selected"; } ?>>US dollar (USD) </option> 
                  <option value="3" <?php if ($quotationData->currecncytype =='3') { echo "selected"; } ?>>Euro (EUR) </option>
                  <option value="4" <?php if ($quotationData->currecncytype =='4') { echo "selected"; } ?>>Pounds (GBP) </option>
                </select>
               </div>
         </div>
         <div class="col-md-3">
               <div class="form-group">
                <label for="">Date:</label>
                <input required class="form-control" type="date" name="quot_Date" value="<?php echo $quotationData->quot_Date; ?>">
              </div></div>
    
        
     
     	 
        
         <?php 
           $id=$quotationData->inquiry;
    $query = $this->db->Select('*')->from('inquiry')->where('inquiry_id',$id)->get();
    $result =$query->row();
    if($result->exist_cust=='0'){
       
    }else{
          $query = $this->db->Select('*')->from('customers')->where('customer_id',$result->exist_cust)->get();
          $results=$query->row();
          
    }   
     ?>
        
           	<!-- <h2 class="text-center"> Quotation Details </h2> -->
         
         	<div class="col-md-4 ">
              <div class="form-group">
                <label for="">Company Name :</label>
                  <input type="text" name="" class="form-control coname" value="<?php 
                    echo $results->co_name.$result->inq_coname; ?>" readonly>
                	
             
               
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for=""> Phone : </label>
                	  <input type="text" name="" class="form-control cophone" value="<?php 
                    echo $results->cust_phone.$result->cophone; ?>" readonly>

              
               
              </div>
            </div>
            <div class="col-md-4 ">
              <div class="form-group">
                <label for=""> Email: </label> 
                		 <input type="email" name="" class="form-control coemail" value="<?php 
                      echo $results->email.$result->inq_coemail; ?>" readonly>
                   
                           
              </div>
            </div>
            
             <div class="col-md-4 ">
              <div class="form-group">
                <label for="">Contact Person:</label>
                   <input type="text" name="" class="form-control copers" value="<?php 
                      echo $results->inq_coperson ?>" readonly>

                	
                </p>              
              </div>
            </div>
             <div class="col-md-4 d-none">
              <div class="form-group">
                <label for="">Contact Person Email:</label>  
             <input type="text" name="" class="form-control copersemail" value="<?php      echo $results->inq_copersemail ?>" readonly>
                
                            
              </div>
            </div>
            <div class="col-md-4 ">
              <div class="form-group">
                <label for=""> Model Name: </label> 
                     <input type="text" name="model_text" class="form-control " value="<?php 
                      echo $quotationData->model_text; ?>" >
                   
                           
              </div>
            </div>
            </div>
     
            <div class="col-md-12 row">
            <table border="1" class="table-responsive prod" style="width:100%;border-color:#d2d6de">
            	<thead>
            	<tr>
            	<th>Product</th>
            	<th> Assembly Product </th>
              <th> Description </th>
            	<th> Quantity </th>

            	<th> Price </th> 
            	<th> Total </th> 
              <th> Discount Type </th>
              <th> Discount </th>  
              <th> Grand Total </th> 
          	    </tr></thead>
          	    <tbody>
          	    	<?php $query = $this->db->Select('*')->from('quotaion_products')->where('quot_id',$quotationData->quotation_id)->get();
              // print_r($this->db->last_query());
     $result= $query->result();
     $c=0;
     foreach ($result as $key => $value) { $c++ ?>
    <tr class="oldata">
      <td>
      <select onchange="chansgeass('<?php echo $c; ?>')"  class="form-control partnm" id="p<?php echo $c; ?>" name="product<?php echo $c; ?>" >
        <option value="">Select</option>
         <?php foreach ($productsData as  $products) { ?>
              <option value="<?php echo $products->product_id; ?>" <?php if (($products->product_id) == ($value->product)) { echo "selected"; } ?>><?php echo $products->part_no; ?></option>
            <?php   } ?>
               
              
        </select>
        </td>
      <td><select onchange="changedesc('<?php echo $c; ?>')"  class="form-control partnm" id="as<?php echo $c; ?>" name="assem_prof<?php echo $c; ?>">
        <option value="">Select</option>
          <?php foreach ($assproductsData as  $assemble) { ?>
              <option value="<?php echo $assemble->assemble_id; ?>" <?php if (($assemble->assemble_id) == ($value->assem_prof)) { echo "selected"; } ?>><?php echo $assemble->part_name; ?></option>
            <?php   } ?>
               
              
        </select></td>
          <td><input name="desc<?php echo $c?>" type="text" onchange="prodblank(<?php echo $c; ?>);" id="desc<?php echo $c; ?>"  class="form-control " value="<?php echo $value->desc; ?>" ></td>
      <td><input name="qtys<?php echo $c?>" type="number" onchange="gettotal(<?php echo $c; ?>);allinditotalafterdisc();getalltot(<?php echo $c; ?>);" id="qtys<?php echo $c; ?>"  class="form-control " value="<?php echo $value->quot_qty; ?>" ></td>
      <td><input name="prics<?php echo $c?>" type="number" id="prics<?php echo $c; ?>"  onchange="gettotal(<?php echo $c; ?>);getalltot(<?php echo $c; ?>);allinditotalafterdisc()" class="form-control " value="<?php echo $value->quot_price; ?>" ></td>
      <td><input type="text" name="quot_amt<?php echo $c?>"  id="tot<?php echo $c; ?>" class="form-control " value="<?php echo $value->quot_amt; ?>" readonly></td>
      <td>
        <select onchange="getalltot(<?php echo $c; ?>);allinditotalafterdisc()" id="disctype<?php echo $c; ?>" name="disctype<?php echo $c; ?>" class="form-control">
          <option value="1" <?php if($value->quot_disc_typ==1){ echo "selected";} ?>>Percentage </option>
          <option value="2" <?php if($value->quot_disc_typ==2){ echo "selected";} ?>>Flat</option>
        </select>
      </td>
      <td><?php //print_r($value); ?>
        <input type="number" value="<?php echo $value->quot_disc; ?>" onchange="getalltot(<?php echo $c; ?>);allinditotalafterdisc()" name="indidisc<?php echo $c; ?>" id="indidisc<?php echo $c; ?>" class="form-control">
      </td>
      <td>
         <input type="number" name="totaftdisc<?php echo $c?>" readonly value="<?php echo $value->quot_total; ?>" onchange="allinditotalafterdisc()"  id="totaftdisc<?php echo $c; ?>" class="form-control">
      </td>
      
    </tr>
    <?php  }
     ?>
     <tr class="oldatatot">
       <td colspan="8">Total</td>
       <td >
          <?php if($quotationData->discount!='0'){ ?>
         <input type="number" value="<?php echo $quotationData->grandtotal;  ?>"class="form-control" required readonly>
       <?php }else { ?>
         <input type="number" value="<?php echo $quotationData->alltotaftdisc;  ?>"  name="alltotaftdisc" id="alltotaftdisc" class="form-control" required readonly>
       <?php } ?>
       </td>
     </tr>
     <?php if($quotationData->discount!='0'){ ?>
     <tr class="oldatatot">
      <td colspan="3">Discount Type </td>
      <td colspan="2"><?php if($quotationData->discounttype==1){ echo "percent";}else{ echo "flat";} ?> </td>
      <td colspan="2">Discount</td><td colspan="2"><?php echo $quotationData->discount;  ?></td>
     </tr>
     <tr class="oldatatot">
      <td colspan="8">Grand Total </td>
    <td colspan="2"><?php echo $quotationData->alltotaftdisc;  ?></td>
     </tr><?php } ?>
          	    </tbody>
            </table>
         
             </div>
              	 	<?php 
     	
     	$term=explode(",",$quotationData->term);  
     	//print_r($term);?>
         <div class="col-md-6 " style="margin-left:-15px; margin-top:30px;">
              <div class="form-group">
                <label for="">Terms:</label>
                <div class="mytestclass" style="display:inline-table;"><?php
			foreach ($termsData as $key => $value) {
				?>
				<input type="checkbox" name="terms[]" value="<?php echo $value->terms_id; ?>" <?php if(in_array($value->terms_id,$term)){echo "checked";} ?>><?php echo $value->terms_descr.""; ?>
                                <a id="btnEditRow" class="termsModalButton mClass"  href="javascript:;" type="button" data-src="<?php echo $value->terms_id; ?>" data-quot_id="<?php echo $quotationData->quotation_id;?>" title="Edit"><i class="fa fa-pencil" data-id=""></i></a><?php echo "<br>"; ?>

			<?php }	?>

			 </div>
         	</div>

         </div>

         	</div>
        
    
</div>
<div class="content-wrapper">
         <button style="margin:15px;" type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button>
    
             </div>
		<div>
		</div>
       <input type="hidden" name="allprod" value="<?php echo $c; ?>" id="allprod">
      </form>
      <input type="hidden" name="beforeTotal" value="" id="beforeTotal">
        <input type="hidden" name="aftertotal" value="" id="aftertotal">
       
  </div>

<!-- Modal Crud Start-->
<div class="modal fade" id="nameModal_quotation" role="dialog">
  <div class="modal-dialog">
    <div class="box box-primary popup" >
      <div class="box-header with-border formsize">
        <!-- <h3 class="box-title"> Product </h3> -->
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <!-- /.box-header -->
      <div class="modal-body" style="padding: 0px 0px 0px 0px;"></div>
    </div>
  </div>
</div>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#inquiry").select2();
                
                   $(".mytestclass").on("click",".termsModalButton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'quotation/getmodalterms2',
      method: 'post', 
      data : {
        id: $(this).attr('data-src'),
        quot_id: $(this).attr('data-quot_id')
      }
    }).done(function(data) {
      $('#nameModal_quotation').find('.modal-body').html(data);
      $('#nameModal_quotation').modal('show'); 
    })
  });


	});
	function getdetails(){
    $('.sets').remove();
     $('.discset').remove();
		var x=document.getElementById("inquiry").selectedIndex;
	var val=document.getElementsByTagName("option")[x].value;
	  $.ajax({
      url : $('body').attr('data-base-url') + 'quotation/getproductdetail',     
      method: 'post',
     
      data : {val:val}
    }).done(function(data) {

    	var obj  = JSON.parse(data);
			console.log(data);
			var all=0;
			// Now the two will work
      var c=0;
        $(".set").remove();
			  $.each(obj,function(index,data){
          c++;
          var pn='p'+c;
          var asn='as'+c;
             var qty=parseInt(data['qty']);
              var price=parseInt(data['price']);
              var total =qty*price;

              all += total;
           
             
             $(".oldata").detach();
             $(".oldatatot").detach();
             // $("tbody").detach();
             $('.prod').append('<tr class="set"><td><select class="form-control" onchange="chansgeass('+c+')" name="product'+c+'" partnm" id="'+pn+'" >        <option value="">Select</option>         <?php foreach ($productsData as  $products) { ?>
              <option value="<?php echo $products->product_id; ?>" ><?php echo $products->part_no; ?></option>            <?php   } ?>
                                    </select></td><td><select onchange="changedesc('+c+')"  name="assem_prof'+c+'"                            class="form-control partnm" id="'+asn+'">        <option value="">Select</option>          <?php foreach ($assproductsData as  $assemble) { ?>
              <option value="<?php echo $assemble->assemble_id; ?>" ><?php echo $assemble->part_name; ?></option>            <?php   } ?>
                                </select></td><td><input type="text" name="desc'+c+'" class="form-control" onchange="prodblank('+c+');" id="desc'+c+'" value="'+data['desc']+'"></td><td><input type="number" name="qtys'+c+'" class="form-control" onchange="gettotal('+c+');getalltot('+c+');allinditotalafterdisc()" id="qtys'+c+'" value="'+data['qty']+'"></td><td><input name="prics'+c+'" class="form-control" type="number" id="prics'+c+'"  onchange="getalltot('+c+');gettotal('+c+');allinditotalafterdisc()" value="'+data['price']+'"></td><td><input id="tot'+c+'" name="quot_amt'+c+'" readonly class="form-control" value="'+total+'"></td>      <td><select onchange="getalltot('+c+');allinditotalafterdisc()" id="disctype'+c+'" name="disctype'+c+'" class="form-control">          <option value="1">Percentage </option>          <option value="2">Flat</option>        </select>      </td>      <td>        <input type="number" onchange="getalltot('+c+');allinditotalafterdisc()" name="indidisc'+c+'" id="indidisc'+c+'" class="form-control">      </td>      <td>         <input readonly onchange="allinditotalafterdisc()" type="number" name="totaftdisc'+c+'" id="totaftdisc'+c+'" class="form-control">  </td></tr>');
             $('#'+pn).val(data['products']);
         	    $('#'+asn).val(data['assemblyprod']);
          });
        $('#allprod').val(c);
        
		
			 $("#beforeTotal").val(all);
			//  $('.prod').append('<tr class="set"><td colspan="4">Total</td><td><input class="form-control" value="'+all+'" readonly></td></tr>');
	     });
	
		   $.ajax({
      url : $('body').attr('data-base-url') + 'quotation/getdetail',     
      method: 'post', 
      data : {val:val}
    }).done(function(data) { 
       

       var dat =JSON.parse(data);
     console.log(dat);
       // $('.coname').val="";
        $('.cophone').val="";
        $('.coemail').val="";
         $('.copers').val="";
       	 $('.copersemail').val="";
         //alert(dat.co_name);
         // alert(dat.inq_coname);
       	if(dat.co_name!=undefined){

        $('.coname').val(dat.co_name);
       	$('.cophone').val(dat.cust_phone);
        $('.coemail').val(dat.email);
       	}
        if(dat.inq_coname!=undefined){
        $('.coname').val(dat.inq_coname);
        $('.cophone').val(dat.inq_phone);
        $('.coemail').val(dat.inq_coemail); }
         $('.copers').val(dat.inq_coperson);	
        $('.copersemail').val(dat.inq_copersemail); 
    });
	}
	function getdiscountprice(){
	var disc=document.getElementById("discount").value;
  var disct=document.getElementById("discounttype").value;
	var total=document.getElementById("alltotaftdisc").value;
	if(disct==1){
	var calc= total*disc/100;
	var main = parseInt(total)-parseInt(calc);
	}else{
     main = parseInt(total)-parseInt(disc);
  }
	$(".mainfoot").detach();
	$('<tfoot class="mainfoot"><tr><td colspan="8" class="text-right">Grand Total('+disc+')</td><td><input name="alltotaftdisc" class="form-control" value="'+main+'" readonly></td></tr></tfoot>').appendTo('.prod');
  $('#aftertotal').val(main);
	}
  function gettotal(n)
  {
    var quantity = document.getElementById("qtys"+n).value;
    var price = document.getElementById("prics"+n).value;
    var total =parseInt(quantity)*parseInt(price);
    
    $('#tot'+n).val(total);
  }
  function getalltot(n){
    var total = document.getElementById("tot"+n).value;
    var disctype = document.getElementById("disctype"+n).value;
    var indidisc = document.getElementById("indidisc"+n).value;
    var calcu=0;
    if(disctype==1){
      var calcu1 = total*indidisc/100;
       calcu =parseInt(total)-parseInt(calcu1);
    }else{
       calcu = parseInt(total)-parseInt(indidisc);
    }
    $('#totaftdisc'+n).val(calcu);

  }
  // $( window ).on( "load", function() {
    function allinditotalafterdisc(){
   
     var prod = document.getElementById("allprod").value;
      console.log(prod);
     var allt=0;

    for (var i = 1; i<=prod; i++) {
    var pro = document.getElementById("totaftdisc"+i).value; 
    console.log(pro);
    if(pro!=''){
    allt += parseInt(pro);
    }
     console.log(allt);
    }
      console.log(allt);
    $(".oldatatot").remove();
    $(".sets").remove();
    $(".discset").remove();
     $('#alltotaftdisc').val(allt);
      $('.prod').append('<tr class="sets"><td colspan="8">Total</td><td><input class="form-control" name="grandtotal" id="alltotaftdisc" value="'+allt+'" readonly></td></tr>');
        $('.prod').append('<tr class="discset"><td colspan="3">Discount Type </td><td colspan="2"><select name="discounttype" id="discounttype" onchange="getdiscountprice()" class="form-control"><option value="1">Percentage </option><option value="2">Flat </option>           </select></td><td colspan="2">Discount</td><td colspan="2"><input type="number" name="discount" id="discount" onchange="getdiscountprice()" class="form-control"></td></tr>');
    }
  // });
  function prodblank(n1){
          document.getElementById('p'+n1).selectedIndex = 0;
          document.getElementById('as'+n1).selectedIndex = 0;
       }
     function chansgeass(n1){
          document.getElementById('desc'+n1).val=0;
          document.getElementById('as'+n1).selectedIndex = 0;
       }
        function changedesc(n1){
          document.getElementById('p'+n1).selectedIndex = 0;
           document.getElementById('desc'+n1).val=0;
       }
       
       

</script>