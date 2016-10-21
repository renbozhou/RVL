$(function(){
	$("select#customertype").val($('#ct').val()); 
	var rma = {}; 
	 rma.types = {
		        "distributor": [
		            { title: "- Select -", value: "" },
		            { title: "Credit", value: "credit" },
		            { title: "Return Only", value: "return" }
		        ],
		        "end_user": [
		            { title: "- Select -", value: "" },
		            { title: "Advance", value: "advance" },
		            { title: "Exchange", value: "exchange" },
		            { title: "Return Only", value: "return" },
		            { title: "Ship Only", value: "ship" }
		        ]
		    };
	if ($("#ct").val() == '2'){
	  var arr = rma.types.distributor;
	}
	else 
	{
		var arr = rma.types.end_user;
	}
	    var options = '';
	    for (var ii = 0; ii < arr.length; ii++) {
	        options += '<option value="' + arr[ii].value + '">' + arr[ii].title + '</option>';
	    }

	    $("select#rma_type").html(options);
	    
	    // Set the Select boxes to the hidden values
	    
	    $("select#rma_type").val($('#rt').val()); 
	    $("select#product_type").val($('#pt').val()); 
	    $("select#status").val($('#st').val()); 
	    $("select#product_dis").val($('#pd').val()); 
	    $("select#facausecode").val($('#facc').val()); 
	    $("select#rtvcat").val($('#rtc').val()); 
	    $("select#supplier").val($('#ss').val()); 
	    
	    // set the manager site
	    $('#site_sel').val($('#site').val());
	
	    $('#site_sel').change(function (){
	    	$("#site").val($('#site_sel').val());
	    });
	    
	    $('#ossb').click(function() {
			val_rma(); 
	    	val_return(); 
	    	val_shipping();
		  $('#formElem').submit(); });
	    
	    // auto populate rma type based on customer type,
	    // repopulate when customer type is changed
	    
	    $("#customertype").change(function () {
	        var type = $(this).val();
	        var arr = '';
	        if (type == 1)
	            arr = rma.types.end_user
	        else if (type == 2)
	            arr = rma.types.distributor
	        var options = '';

	        for (var ii = 0; ii < arr.length; ii++) {
	            options += '<option value="' + arr[ii].value + '">' + arr[ii].title + '</option>';
	        }
	        $("select#rma_type").html(options);	       
	    });
	    $("#rma_type").change(function () {
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping();
	    	
	    });
	    
	    $("#rma_number").change(function () {
	    	val_rma(); 
	        
	    }); 
	    // datepicker for the mulitple date selectors
	    
	    $(".date").datepicker({
	    	maxDate: new Date, 
	        showOn: "button",
	        buttonImage: "/images/icons/calendar.png",
	        buttonImageOnly: true,
	        dateFormat: 'yy-mm-dd',
	        dayNamesMin: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
	        onSelect: function (text) {
	            $("#show_screen_date").html(text);
	        }
	    });
	    
	   // call back for the autopoulate
	    $("#iomegasn").keyup(function () {
	        var $val = $(this).val();

	        if ($val.length > 1) {
	        	 $.post("/index.php/repository/model_code/", {queryString: $val}, function(data){
	                 if(data.length > 0) {
	                	 var obj = $.parseJSON(data);
	                	   
	                	  $("#partnumber").val(obj.PART_NUMBER);
	                	  $("#partdesc").val(obj.DESCRIPTION);
	                 }
	                    }); 
	                 
	             }   

	    });

	    $("#replacesn").keyup(function () {
	        var $val = $(this).val();

	        if ($val.length > 1) {
	        	 $.post("/index.php/repository/model_code/", {queryString: $val}, function(data){
	                 if(data.length > 0) {
	                	 var obj = $.parseJSON(data);
	                	   
	                	  $("#replacenum").val(obj.PART_NUMBER);
	                	  $("#replacedesc").val(obj.DESCRIPTION);
	                 }
	                    }); 
	                 
	             }   

	    });
	    
	    // validator for submitting the form
	    $('#formElem').submit(function() {
	    	var e = true; 
	    	if (!val_rma())
	    		e=false; 
	    	if (!val_return())
	    		e=false; 
	    	if (!val_shipping())
	    		e=false; 
	    	if (!e) 
	    		alert('Please correct the errors in the Form');
	    	return e;
	    	});
	    
	    $('#basicbtn').click(function(){
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping(); 
	    }); 
	    
	    $('#retbtn').click(function(){
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping(); 
	    }); 
	    
	    $('#screenbtn').click(function(){
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping(); 
	    }); 
	    
	    $('#rtvbtn').click(function(){
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping(); 
	    }); 
	    
	    $('#shipbtn').click(function(){
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping(); 
	    });
	    
	    $('#savebtn').click(function(){
	    	val_rma(); 
	    	val_return(); 
	    	val_shipping(); 
	    }); 
	    
}); 

function val_rma(){
	var r = $('#rma_type').val(); 
	if (r == "")
		{
			$("#error_div").html('Basic Info -> RMA Type Must Be Selected');	
   	 		$("#rma_type").addClass('requiredfield'); 
   	 		return false; 
		}
	else
		{
			$("#error_div").html('');	
	 		$("#rma_type").removeClass('requiredfield'); 
	 		
		}
	var v = $("#customertype").val();	        
    if (v == "2"){ //distributor not validated
    	$("#error_div").html(' ');
    	$("#rma_number").removeClass('requiredfield');   
        return true;
    }
    var value = $("#rma_number").val(); 
    var pattern = /^[a-zA-Z]{2}[0-9]{10}$/; 
    if (!pattern.test(value))
	    {
	    	 $("#error_div").html('Basic Info -> RMA Number must be format AA9999999999');	
	    	 $("#rma_number").addClass('requiredfield'); 
	    	 return false; 
	    }
    else
    	{ 
	    	$("#error_div").html('');
	    	$("#rma_number").removeClass('requiredfield');  
	    	return true; 
    	}
	
}

function val_return()
{
	var e = true; 
	var v = $('#rma_type').val();
	var rma_id = $('#rma_id').val();
	 if (v == "credit" || v == "advance" || v =="ship" || rma_id == "new"){ 
		 // no part returned	
		 $("#receipt_date").removeClass('requiredfield');
		 $("#iomegasn").removeClass('requiredfield');
		 $("#bhddsn").removeClass('requiredfield');
		 $("#partnumber").removeClass('requiredfield');	
		 $("#error_rec").html('');	
	      return true;
	 }
	 // get values of required fields
	 var date = $('#receipt_date').val(); 
	 var inum = $('#iomegasn').val(); 
	 var hdn = $('#bhddsn').val(); 
	 var pn = $('#partnumber').val();
	 if (date == '')// check date,serial nunber and part number 
	 {
		 e = false; 
		 $("#receipt_date").addClass('requiredfield'); 
	 }else
	 {
		 $("#receipt_date").removeClass('requiredfield');
	 }
	 if ( inum == '')// check date,serial nunber and part number 
	 {
		 $("#iomegasn").addClass('requiredfield');
		 if ( hdn == '')
			 {
			 	$("#bhddsn").addClass('requiredfield');
			 	e = false; 
			 }
		 else {
			 $("#iomegasn").removeClass('requiredfield');
			 $("#bhddsn").removeClass('requiredfield');
		 }
	 }
	else
	 {
		 $("#iomegasn").removeClass('requiredfield');
		 $("#bhddsn").removeClass('requiredfield');
	 }
	 if (pn == '')
	 {
		 $("#partnumber").addClass('requiredfield');
		 e = false; 
	 }
	 else
	 {
		 $("#partnumber").removeClass('requiredfield');	
	 }
	 if (!e)
		 {
		  $("#error_rec").html('Returned Info -> Missing Fields');	
		 }
	 else 
		 {
		 $("#error_rec").html('');	
		 }
	return e; 	
}

function val_shipping()
{
	var e = true; 
	var v = $('#rma_type').val();
	var rma_id = $('#rma_id').val();
	$("#shipped_date").removeClass('requiredfield'); //shipped date no longer required
	$("#couriertrack").removeClass('requiredfield');
	 if (rma_id == "new" || (v != "exchange" && v != "advance" && v != "ship")) { 
		 $("#error_shp").html('');	
		 $("#shipped_date").removeClass('requiredfield');		 
		 $("#couriertrack").removeClass('requiredfield');
	        return true;
	 }
	// get values of required fields
	 var date = $('#shipped_date').val(); 
	 
	 var pn = $('#replacenum').val(); 
	 var tn = $('#couriertrack').val();
	 //if (date == '')// check date,serial nunber and part number 
	 //{
		 //e = false; 
		 //$("#shipped_date").addClass('requiredfield'); 
	 //}else
	 //{
		 $("#shipped_date").removeClass('requiredfield');
	 //}
	 //if (pn == '')
	 //{
	 //    $("#replacenum").addClass('requiredfield');
	 //    e = false; 
	 //}
	 //else
	 //{
		 $("#replacenum").removeClass('requiredfield');	
	 //}
	 //if (tn == '')
	 //{
	 //    $("#couriertrack").addClass('requiredfield');
	 //    e = false; 
	 //}
	 //else
	 //{
		 $("#couriertrack").removeClass('requiredfield');	
	 //}
	 if (!e)
	 {
	  $("#error_shp").html('Shipping Info -> Missing Fields');	
	 }
	 else 
	 {
	 $("#error_shp").html('');	
	 }
	 
	 return e;
}
	
	