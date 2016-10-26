$(function(){
	$('#pw_form').submit(function (){
		if ($("#password").val() == $("#password_con").val() && ($("#password").val().length != 0))
			{
				return; 
			}
		if ($("#password").val().length != 0)
			{
				$("#warn").text("PASSWORD MUST MATCH").show().fadeOut(1000); 
			}else {
				$("#warn").text("PASSWORD MUST NOT BE BLANK").show().fadeOut(1000); 
			}
		event.preventDefault(); 
	});
}); 