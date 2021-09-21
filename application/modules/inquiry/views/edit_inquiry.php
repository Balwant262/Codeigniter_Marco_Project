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

1

<form role="form bor-rad" enctype="multipart/form-data" action="<?php echo base_url().'inquiry/edit'?>" method="post"><br>

			<input type="hidden" name="inquiry_number" value="<?php echo $inquiryData[0]->inquiry_number; ?>" />

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

      <div class="col-md-12">
      <div class="form-group">  
                    
                          <div class="table-responsive">
      <button type="button" id="add" onclick="addmore2()" class="btn btn-success">Add More</button>

          <table id="dynamic_field1" class="cell-border example2 table table-striped table1 delSelTable col-md-6">
            <tbody id="tbody1">

              <?php $i=1; foreach ($inquiryData as $value) { ?>
           <tr class="row<?php echo $i ?>">
               

                    <td style="width: 18%;" class="ui-widget">Item
                       <select name="item_name<?php echo $i ?>" id="item_name<?php echo $i ?>" class="form-control item_name" onchange="item_name(<?php echo $i ?>)">
                      <option value="">Select</option>
                        <?php foreach ($productData as  $item) { ?>
                        <option value="<?php echo $item->item_name; ?>" <?php if($value->item_name == $item->item_name){ echo "selected"; } ?>><?php echo $item->item_name; ?></option>
                      <?php   } ?>
                    </select>
                  </td>

                
           

            <td><label class="size1">UOM</label>
              <input type="number" name="new_uom<?php echo $i ?>" id="new_uom<?php echo $i ?>" class="form-control new_uom"  min="0" value="<?php echo $value->uom; ?>" >

              
            </td>


            <td><label class="pcs<?php echo $i ?>">Pcs</label>
              <input type="number" name="quantity<?php echo $i ?>" id="quantity<?php echo $i ?>" onchange="addmore()" class="form-control" min="0" value="<?php echo $value->quantity; ?>" >
            </td>
            <!-- <td> -->
              
              <!-- <button type="button" id="add" class="btn btn-success">Add More</button>
            </td> -->

            <td><button type="button" name="remove" id="<?php echo $i ?>" class="btn btn-danger btn_remove">X</button></td>

             <input type="hidden" name="row_id<?php echo $i ?>" id="row_id<?php echo $i ?>" value="<?php echo $value->inquiry_id; ?>" >
            </tr>

          <?php $i++; } ?>

          <input type="hidden" name="number" id="number" value="<?php echo $i-1; ?>" >
          </tbody>
          </table>
        </div></div></div>

     

         <div class="box-form">
           <div class="form-group">
             <table class="table table-striped" id="thetable">
               <!-- <tr><th>UOM</th><th>Pcs</th></tr> -->
               <tr><th><span class="size"></span></th><th><span class="pcs"></span></th></tr>
               <!-- <tr><td></td><td></td></tr> -->
             </table>
           </div>
         </div>






		<div>

       
        <div class="box-footer sub-btn-wdt">
          <button type="submit"  value="edit" class="btn btn-success wdt-bg">Update</button>
        </div>
              <!-- /.box-body -->
      



		<!-- <button type="submit" class="btn btn-primary" name="submit" value="submit">Submit</button> -->
		</div>
      
      </form>


      <script type="text/javascript">
  $(document).ready(function() {  

    $("#client_id").select2();
     $("#item_name1").select2();
     // $('#combobox').autocomplete();

     // $('#combobox').autocompleteDropdown({

     //    // placeholder for the search field
     //    customPlaceholderText: "Search...",

     //    // default CSS classes
     //    wrapperClass: 'autocomplete-dropdown',
     //    inputClass: 'acdd-input',

     //    // allows additions to the select field
     //    allowAdditions: true,

     //    // text to show when no results
     //    noResultsText: 'No results found',

     //    // callbacks
     //    onChange: function() {
     //      window.console.log('select has changed');
     //    },
     //    onSelect: function() {
     //      window.console.log('an option has been selected');
     //    },
        
     //  });
    // $("#combobox").autocomplete({
    //     source: function (request, response) { // use a function so you can trim the request and ignore ""
    //         var term = $.trim(request.term)
    //         var reg = new RegExp($.ui.autocomplete.escapeRegex(term), "i")
    //         if (term !== "") response($.grep(availableTags, function (tag) {
    //             return tag.label.match(reg)
    //         }))
    //     },
    //     select: function (e, ui) {
    //         // location.href = ui.item.the_link;
    //         //  console.log(ui.item.the_link);
    //     }
    // });


     // $('#category_id').change(function(){
    
        

     // $('.item_name').change(function(){
    


   //   $('#inventory_id').change(function(){
   //    var uom = $( "#inventory_id option:selected" ).text();
   //    // alert(uom);
   //    $('#uom').val(uom);
      
   // });

     $('#delivered').change(function(){
      var d = $( "#delivered" ).val();
      if (d==1) {
        $('.showsplit').show();
      }else{
        $('.showsplit').hide();
      }
      
   });




     // $('.new_uom').change(function(){
   


     var i=1;  

    



      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('.row'+button_id+'').remove();  

      }); 







  });
   function addmore(){
      
      // $('#add').click(function(){  
        var i = $('#number').val();
            // alert(count);
            if($('#item_name'+i).val() !=''){
           i++;  
           
           $('#tbody1').append('<tr class="row'+i+'"><td class="tdi'+i+'" style="width: 18%">Item<select name="item_name'+i+'" id="item_name'+i+'" class="form-control item_name" onchange="item_name('+i+')"><option value="">Select</option><?php foreach ($productData as  $item) { ?><option value="<?php echo $item->item_name; ?>" ><?php echo $item->item_name; ?></option><?php   } ?></select></td><td><label class="size'+i+'">UOM</label><input type="number" name="new_uom'+i+'" id="new_uom'+i+'" class="form-control new_uom" min="0"></td><td><label class="pcs'+i+'">Pcs</label><input type="number" name="quantity'+i+'" id="quantity'+i+'" class="form-control" min="0" onchange="addmore()"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'); 

            // $('#item_name1').clone().attr('id', 'item_name'+i+'').attr('name', 'item_name'+i+'').attr('onchange', 'item_name('+i+')').appendTo($('.tdi'+i+''));

             $('#item_name'+i).select2();
            // $('#category_id1').clone().attr('id', 'category_id'+i+'').attr('name', 'category_id'+i+'').attr('onchange', 'category('+i+')').appendTo($('.tdc'+i+''));

      

      $(function () {
      $('#number').val(i);
    });
      }  

    }



    function addmore2(){
      
      // $('#add').click(function(){  
        var i = $('#number').val();
           i++;  
           
           $('#tbody1').append('<tr class="row'+i+'"><td class="tdi'+i+'" style="width: 18%">Item<select name="item_name'+i+'" id="item_name'+i+'" class="form-control item_name" onchange="item_name('+i+')"><option value="">Select</option><?php foreach ($productData as  $item) { ?><option value="<?php echo $item->item_name; ?>" ><?php echo $item->item_name; ?></option><?php   } ?></select></td><td><label class="size'+i+'">UOM</label><input type="number" name="new_uom'+i+'" id="new_uom'+i+'" class="form-control new_uom" min="0"></td><td><label class="pcs'+i+'">Pcs</label><input type="number" name="quantity'+i+'" id="quantity'+i+'" class="form-control" min="0" onchange="addmore()"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>'); 

            // $('#item_name1').clone().attr('id', 'item_name'+i+'').attr('name', 'item_name'+i+'').attr('onchange', 'item_name('+i+')').appendTo($('.tdi'+i+''));

             $('#item_name'+i).select2();
            // $('#category_id1').clone().attr('id', 'category_id'+i+'').attr('name', 'category_id'+i+'').attr('onchange', 'category('+i+')').appendTo($('.tdc'+i+''));

      

      $(function () {
      $('#number').val(i);
    });
      

    }

    
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
      // alert(new1);    
      if(Selecteduom < new1){
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
          $('#lossDiv'+number).show();
          $('#gainDiv'+number).hide();
            $("#gain"+number).prop("checked", false);
      }
   }



</script>