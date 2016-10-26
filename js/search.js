$(function() {
	$('#filter_start').datepicker({
		showOn: "button",
		buttonImage: "/images/icons/calendar.png",
		buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		dayNamesMin: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
		onSelect: function(text) {
		    $("#filter_start_date").html(text);
		}
	});
	$('#filter_end').datepicker({
		showOn: "button",
		buttonImage: "/images/icons/calendar.png",
		buttonImageOnly: true,
		dateFormat: 'yy-mm-dd',
		dayNamesMin: ['S', 'M', 'T', 'W', 'Th', 'F', 'S'],
		onSelect: function(text) {
		    $("#filter_end_date").html(text);
		}
	});

	$("#filter_search").submit(function(event) {
		$fd = $("#filter_date");
		if( $fd.val() == "" ) {
			event.preventDefault();
			$fd.addClass('rma_conflict').change(function() {
				if( $(this).val() != '' )
					$(this).removeClass('rma_conflict');
			});
		}
	});
});