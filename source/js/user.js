
function lookup(inputString) {   
        $.post("/index.php/repository/autodesc/", {queryString: ""+inputString+""}, function(data){
            if(data.length > 0) {
                var obj = $.parseJSON(data);
                $.each(obj, function (key,value){
                	  $('#sitedes').html(value); 
                	  $('#site_val').val(key); 
                });
            }
        });    
}

$(function (){
	$("#siteinfo").val($("#site_val").val()); 
}); 