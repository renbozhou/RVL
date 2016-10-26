$(function() {

	$('#start_date').datepicker({
		maxDate: '0', 
		showOn: "button",
		buttonImage: "/images/icons/calendar.png",
		buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		dayNamesMin: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
		onSelect: function(text) {
		    $("#show_start_date").html(text);
		}
	});
	$('#end_date').datepicker({
		maxDate: '0', 
		showOn: "button",
		buttonImage: "/images/icons/calendar.png",
		buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		dayNamesMin: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
		onSelect: function(text) {
		    $("#show_end_date").html(text);
		}
	});

	$('#site_selection').button({icons: {
		secondary: "ui-icon-triangle-1-s"
	}}).click(function() {
		$("#sites").toggle();
	});

	$('#build_report').button();
});

