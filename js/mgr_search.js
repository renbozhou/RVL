$(function(){
	
	$(".dateinput").datepicker({
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
	
}); 