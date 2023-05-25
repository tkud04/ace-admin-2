   
$(document).ready(function(){
	$('#add-discount-input').hide();
	$('#result-box').hide();
	$('#finish-box').hide();
	
	$('#settings-delivery-side2').hide();
	$('#settings-delivery-loading').hide();
	$('#settings-bank-side2').hide();
	$('#settings-bank-loading').hide();
	
	$('#settings-discount-nud-error').hide();
	$('#settings-discount-side2').hide();
	$('#settings-discount-loading').hide();
	
	$('#as-other').hide();
	
	$('#analytics-1-period-error').hide();
	$('#analytics-1-num-error').hide();
	$('#analytics-1-loading').hide();
	
	let ccvg = $('#ac-coverage').val();
	if(ccvg != "individual") $('#ac-coverage-individual').hide();
	$('#ac-validation-error').hide();
	
	hideUnselects();
	hideSelectErrors();
	if($("#add-discount-type").val() == "single"){} 
	else {
		$('#sku-form-row').hide();
		$('#category-form-row').hide();
		}
	
        $("select.customer-type").change((e) =>{
			e.preventDefault();
			let ct = $(this).val();
			console.log("ct: ",ct);
		});
		
		$('#spp-show').click((e) => {
	   e.preventDefault();
	   let spps = $('#spp-s').val();
	   
	   if(spps == "hide"){
		   $('#as-password').attr('type',"password");
		   $('#spp-show').html("Show");
		   $('#spp-s').val("show");
	   }
	   else{
		   $('#as-password').attr('type',"text");
		   $('#spp-show').html("Hide");
		   $('#spp-s').val("hide");
	   }
   });
		
		$("#server").change((e) =>{
			e.preventDefault();
			let server = $("#server").val();
			console.log("server: ",server);
			
			if(server == "other"){
				$('#as-other').fadeIn();     
            }
            else{
				$('#as-other').hide();     
            }
			
		});
		 $("#add-sender-submit").click(function(e){            
		       e.preventDefault();
			   let valid = true;
			   let name = $('#as-name').val(), username = $('#as-username').val(),
			   pass = $('#as-password').val(), s = $('#server').val(),
			   ss = $('#as-server').val(), sp = $('#as-sp').val(), sec = $('#as-sec').val();
			   
			   if(name == "" || username == "" || pass == "" || s == "none"){
				   valid = false;
			   }
			   else{
				   if(s == "other"){
					   if(ss == "" || sp == "" || sec == "nonee") valid = false;
				   }
			   }
			   
			   if(valid){
				 $('#add-sender-form'). submit();
			    //updateDeliveryFees({d1: d1, d2: d2});  
			   }
			   else{
				   alert("Please fill all required fields");
			   }
             
		  });
		
		$("#update-tracking-btn").change((e) =>{
			e.preventDefault();
			let vv = $("#update-tracking-btn").val();
			trackingAction = vv;
		});
		$("#cp-btn").change((e) =>{
			e.preventDefault();
			let cc = $("#cp-btn").val();
			cpAction = cc;
		});
		
		$("input.form-control.images").change((e) =>{
			e.preventDefault();
			let cc = $(this)[0].files;
			console.log(cc);
		});
		
        $("#toggle-discount-btn").click(function(e){            
		   e.preventDefault();
            let hasDiscountField = $('#add_discount');
            let hasDiscount = hasDiscountField.val();
            
			if(hasDiscount == "yes"){
			 hasDiscountField.val("no");
             $('#toggle-discount-btn').html("Add discount");			 
             $('#add-discount-button').fadeIn();			 
             $('#discount').val("");			 
			}
			else if(hasDiscount == "no"){
			 hasDiscountField.val("yes");
             $('#toggle-discount-btn').html("Remove discount");
             $('#add-discount-button').hide();			 
             //$('#discount').val("");			 
			}
			
            $('#add-discount-input').fadeToggle();            
			});
			
			$("#add-discount-type").change(function(e){            
		       e.preventDefault();
               let dtype = $(this).val();
            
			   if(dtype == "single"){			 
                $('#category-form-row').hide();			 
                $('#sku-form-row').fadeIn();			 
			   }
			   else if(dtype == "category"){
			    $('#category-form-row').hide();			 
			    $('#category-form-row').fadeIn();			 
			   }
			   else{
			    $('#sku-form-row').hide();			 
			    $('#category-form-row').hide();			 
			   }
		  });
		  
		  $("#settings-delivery-btn").click(function(e){            
		       e.preventDefault();
              $('#settings-delivery-side1').hide();
              $('#settings-delivery-side2').fadeIn();
		  });

		  $("#settings-delivery-form").submit(function(e){            
		       e.preventDefault();
			   let d1 = $('#settings-delivery-d1').val(), d2 = $('#settings-delivery-d2').val();
			   
			   if(d1 == "" || parseInt(d1) < 1 || d2 == "" || parseInt(d2) < 1){
				   alert("All fields are required");
			   }
			   else{
				   
			   }
             $('#settings-delivery-submit').hide();
		     $('#settings-delivery-loading').fadeIn();
			 updateDeliveryFees({delivery1: d1, delivery2: d2});
		  }); 
		  
		  $("#settings-discount-btn").click(function(e){            
		       e.preventDefault();
              $('#settings-discount-side1').hide();
              $('#settings-discount-side2').fadeIn();
		  });

		  $("#settings-discount-form").submit(function(e){ 		  
		       e.preventDefault();
			   $('#settings-discount-nud-error').hide();
			   let nud = $('#settings-discount-nud').val();
			   
			   if(nud == "" || parseInt(nud) < 1){
				  $('#settings-discount-nud-error').fadeIn();
			   }
			   else{
				   
			   }
             $('#settings-discount-submit').hide();
		     $('#settings-discount-loading').fadeIn();
			 updateDiscounts({type: "nud", value: nud});
		  });
		  
		  $("#settings-bank-btn").click(function(e){            
		       e.preventDefault();
              $('#settings-bank-side1').hide();
              $('#settings-bank-side2').fadeIn();
		  });

		  $("#settings-bank-form").submit(function(e){            
		       e.preventDefault();
			   let bname = $('#settings-bank-bname').val(), acname = $('#settings-bank-acname').val(), acnum = $('#settings-bank-acnum').val();
			   
			   if(bname == "none" || parseInt(acnum) < 1 || acname == ""){
				   alert("All fields are required");
			   }
			   else{
				   $('#settings-bank-submit').hide();
		           $('#settings-bank-loading').fadeIn();
			       updateBank({bname: bname, acname: acname, acnum: acnum});   
			   }

		  });

		  $("#analytics-1-btn").click(function(e){            
		       e.preventDefault();
			   $('#analytics-1-period-error').hide();
	           $('#analytics-1-num-error').hide();
			   
			   let period = $('#analytics-1-period').val(), num = $('#analytics-1-num').val();
			   
			   if(period == "none" || num == "" || parseInt(num) < 1){
				   if(period == "none") $('#analytics-1-period-error').fadeIn();
				   if(num == "" || parseInt(num) < 1) $('#analytics-1-num-error').fadeIn();
			   }
			   else{
				   $('#analytics-1-submit').hide();
		           $('#analytics-1-loading').fadeIn();
			       fetchAnalytics({type: "most-visited-pages", period: period, num: num});   
			   }

		  });

		  $("#ac-coverage").change(function(e){            
		       e.preventDefault();
			   
			   let n = $(this).val();
			   
			   if(n == "individual"){
				    $('#ac-coverage-individual').fadeIn();
			   }
			   else{
				   $('#ac-coverage-individual').val("none");
				   $('#ac-coverage-individual').hide();
		          
			   }

		  });
		  
		  $("#ac-submit").click(function(e){            
		       e.preventDefault();
			   $('#ac-validation-error').hide();
			   
			   let n = $('#ac-name').val(), nn = $('#ac-nickname').val(),
			              t = $('#ac-type').val(), ti = $('#ac-coverage-individual').val(),
						  p = $('#ac-price').val(), c = $('#ac-coverage').val();
			   
			   if(t == "none" || (c == "individual" && ti == "none") || c == "none" || n == "" || nn == "" || p == "" || parseInt(p) < 1){
				    $('#ac-validation-error').fadeIn();
			   }
			   else{
				   $('#ac-form').submit();
		          
			   }

		  });

		  $("#reports-btn").click(function(e){            
		       e.preventDefault();
			   
			   let from = $('#reports-from').val(), to = $('#reports-to').val(),
			              range = $('#reports-range').val();
			   
			   if(from == "" || to == "" || range == "none"){
				    Swal.fire({
			            icon: 'error',
                        title: "Please fill in the required fields."
                    })
			   }
			   else{
				    $('#reports-btn').hide();
				    $('#reports-loading').fadeIn();
				   fetchReport({type: "total-revenue", from: from, to: to, range: range});
		          
			   }

		  });
		  
		  $("#reports-2-btn").click(function(e){            
		       e.preventDefault();
			   
			   let from = $('#reports-2-from').val(), to = $('#reports-2-to').val(),
			              range = $('#reports-2-range').val();
			   
			   if(from == "" || to == ""){
				    Swal.fire({
			            icon: 'error',
                        title: "Please fill in the required fields."
                    })
			   }
			   else{
				    $('#reports-2-btn').hide();
				    $('#reports-2-loading').fadeIn();
				   fetchReport({type: "best-selling-products", from: from, to: to, range: "afff"});
		          
			   }

		  });
		  
});
