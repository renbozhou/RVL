$(function(){
	if ($('#site').val() != '0')
		{
			$("#mgr_sites").hide();
		}
	$("select#siteinfo").val($('#site').val()); 
	
	
});

function lookup(inputString) {   
    $.post("/index.php/repository/autodesc/", {queryString: ""+inputString+""}, function(data){
        if(data.length > 0) {
            var obj = $.parseJSON(data);
            $.each(obj, function (key,value){
            	  $('#site_num').html(key); 
            	  $('#sitedes').html(value); 
            	  $('#site').val(key);
            	  
            	  if (key == '0')
          		{
          			$("#mgr_sites").show();
          		}else{
          			$("#mgr_sites").hide();
            	}
            });
        }
    });    
}