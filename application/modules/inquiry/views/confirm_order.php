 <style> 
td{ 
	padding-top:5Px; 
	padding-bottom:5px;
}
.item_name{
  position: inherit !important;
}
.select2-container{
  width: 100% !important;
}
 </style>



<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'inquiry/confirm_order'?>" method="post"><br>

			<input type="hidden" name="inquiry_number" value="<?php echo $inquiryData[0]->inquiry_number ?>" />

           <?php $this->db->select('*');
          $this->db->from('inventory');
          $this->db->group_by('item_name');
          $query = $this->db->get();
          $productData = $query->result(); ?>


			<div class="box-form " >
			 <div class="form-group col-md-6" >
					<label>Client</label>
   					  <select name="client_id" id="client_id" class="form-control">
              <option value="">Select</option>
              <?php foreach ($clientData as  $Client) { ?>
              <option value="<?php echo $Client->client_id; ?>" <?php if (($Client->client_id) == ($inquiryData[0]->client_id)) { echo "selected"; } ?>><?php echo $Client->client_name; ?></option>
            <?php   } ?>
            </select>
 			 </div>
 			 
			</div>


          <table id="dynamic_field1" class="cell-border example2 table table-striped table1 delSelTable col-md-6">
            <tbody id="tbody1">

              <?php $i=1; foreach ($inquiryData as $value) {
               ?>

           <tr class="row1">
             

                  <td style="width: 18%;" class="ui-widget">Item
                       <select name="item_name<?php echo $i; ?>" id="item_name<?php echo $i; ?>" class="form-control item_name" onchange="item_name(<?php echo $i; ?>)">
                      <option value="">Select</option>
                        <?php foreach ($productData as  $item) { ?>
                        <option value="<?php echo $item->item_name; ?>" <?php if($value->item_name==$item->item_name){ echo "selected"; } ?>><?php echo $item->item_name; ?></option>
                      <?php   } ?>
                    </select>
                  </td>

                  <td class="showsplit" >Select <span class="size<?php echo $i; ?>"></span>
                    <select name="uom<?php echo $i; ?>" id="uom<?php echo $i; ?>" class="form-control " onchange="checkGL(<?php echo $i; ?>)">
                      <option value="">Select</option>
                      <?php  $query = $this->db->select('*')->from('inventory')->where('item_name',$value->item_name)->get();
                            $data = $query->result(); foreach ($data as $value1) { ?>
                          <option value="<?php echo $value1->uom1; ?>"><?php echo $value1->uom1; ?></option>
                        <?php } ?>
                    </select>
                       <!-- <input type="text" class="form-control" name="uom1" id="uom1" value=""> -->
                  </td>
            
            <td style="width: 15%;display: none" class="showsplit"><br>
               <input type="radio" id="split<?php echo $i; ?>" class="frm-style"name="split<?php echo $i; ?>" value="0" checked="">
              <label> Normal</label>
              <input type="radio" id="split<?php echo $i; ?>"  name="split<?php echo $i; ?>" value="1">
              <label> Split</label>
            </td>

            <td><label class="size<?php echo $i; ?>">UOM</label>
              <input type="number" name="new_uom<?php echo $i; ?>" id="new_uom<?php echo $i; ?>" class="form-control "  min="0" value="<?php echo $value->uom; ?>">

              <div id="gainDiv<?php echo $i; ?>" style="display: none;">
              <input type="checkbox" name="gain<?php echo $i; ?>" id="gain<?php echo $i; ?>" > Gain
              </div>

              <div id="lossDiv<?php echo $i; ?>" style="display: none">
              <input type="radio" id="loss<?php echo $i; ?>" name="loss<?php echo $i; ?>" value="0" checked="">
              <label> Add Inventory</label>
              <input type="radio" id="loss<?php echo $i; ?>"  name="loss<?php echo $i; ?>" value="1">
              <label> Loss</label>
              </div>
            </td>


            <td><label class="pcs1">Pcs</label>
              <input type="number" name="quantity<?php echo $i; ?>" id="quantity<?php echo $i; ?>" class="form-control" min="0" value="<?php echo $value->quantity; ?>">
            </td>
           

            </tr>
          <?php $i++; } ?>
                 <input type="hidden" name="number" id="number" value="<?php echo $i-1; ?>" >
          </tbody>
          </table>



		<div>

         
        <div class="box-footer sub-btn-wdt">
          <button type="submit" name="submit" value="add" class="btn btn-success wdt-bg">Confirm Order</button>
        </div>
        



		<!-- <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button> -->
		</div>
      
      </form>


      <script type="text/javascript">
  $(document).ready(function() {  



  });

    function category(number){
      var category_id = $('#category_id'+number).val();

      // AJAX request
      $.ajax({
        url:'<?php echo base_url();?>/inquiry/getItems',
        method: 'post',
        data: {id: category_id},
        dataType: 'json',
        success: function(response){

          // Remove options 
          $('#item_name'+number).find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#item_name'+number).append('<option value="'+data['item_name']+'">'+data['item_name']+'</option>');
          });


            $('#item_name'+number).selectize({
                sortField: 'text'
            });

        }
     });
   }

  function item_name(number){
      // alert(this.id);
      // var number = this.id.replace('item_name','');
      // alert(myString);
      var item_name = $('#item_name'+number).val();

      // AJAX request
      $.ajax({
        url:'<?php echo base_url();?>/inquiry/getUOM',
        method: 'post',
        data: {item_name: item_name},
        dataType: 'json',
        success: function(response){

          // Remove options 
          $('#uom'+number).find('option').not(':first').remove();

          // Add options
          $.each(response,function(index,data){
             $('#uom'+number).append('<option value="'+data['uom1']+'">'+data['uom1']+'</option>');
          });

          $('#thetable tr').not(':first').remove();
              var html = '';
              // for(var i = 0; i < data.d.length; i++)
              $.each(response,function(index,data){
                          html += '<tr><td>' + data['uom1'] + 
                                  '</td><td>' + data['pcs'] + '</td></tr>';
                                });
          $('#thetable tr').first().after(html);
        }
     });

      $.ajax({
        url:'<?php echo base_url();?>/inquiry/getUnits',
        method: 'post',
        data: {id: item_name},
        dataType: 'text',
        success: function(data){
           console.log(data);
          var newdata = JSON.parse(data);
          console.log(newdata);
          
          $(".size"+number).text(newdata.primary_unit_name);
          $(".pcs"+number).text(newdata.secondary_unit_name);
          $(".size").text(newdata.primary_unit_name);
          $(".pcs").text(newdata.secondary_unit_name);
         
        }
     });


   }

  function checkGL(number){
       // var number = this.id.replace('new_uom','');
      
      var new1 = $('#new_uom'+number).val();
      var Selecteduom = $('#uom'+number).val();
      // alert(Selecteduom);
      // alert(new1);    
      if(parseInt(Selecteduom) < parseInt(new1)){
        // alert('gain');
        if (confirm('Is it a gain?')) {

            $('#gainDiv'+number).show();
            $("#gain"+number).prop("checked", true);
            $('#lossDiv'+number).hide();
            
        }else{
          $("#gain"+number).prop("false", true);
          $('#lossDiv'+number).hide();
        }

      }else if(Selecteduom > new1){
        // alert(1);
          $('#lossDiv'+number).show();
          $('#gainDiv'+number).hide();
            $("#gain"+number).prop("checked", false);
      }else{
         $("#gain"+number).prop("checked", false);
        $('#lossDiv'+number).hide();
        $('#gainDiv'+number).hide();

      }

   }



</script>