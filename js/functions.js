$(function () {
    var startDate;
    var endDate;
    
    $('#siteinfo').change(function (){
    	$("#s_id").val($('#siteinfo').val());
    });
    
    $.datepicker.setDefaults({
    	 dateFormat: 'yy-mm-dd',
    	 maxDate: new Date
    }); 
    var selectCurrentWeek = function () {
        window.setTimeout(function () {
            $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active');
            }, 1);
    };
    var $weekPicker = $('.week-picker');

    function updateWeekStartEnd() {
        var date = $weekPicker.datepicker('getDate') || new Date();
        startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
        endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
    }

    updateWeekStartEnd();

    function updateDateText(inst) {
        var dateFormat = inst != 'start' &&  inst.settings.dateFormat ? inst.settings.dateFormat : $.datepicker._defaults.dateFormat;
        
        console.log( dateFormat); 
        $('#startDate').text($.datepicker.formatDate(dateFormat, startDate, inst.settings));
        $('#endDate').text($.datepicker.formatDate(dateFormat, endDate, inst.settings));
        $('.filedate').val($.datepicker.formatDate(dateFormat, endDate, inst.settings)); 
    }

    updateDateText('start');

    $weekPicker.datepicker({
    	maxDate: new Date,
        showOtherMonths: true,
        selectOtherMonths: true,
        dateFormat: 'yy-mm-dd',
        onSelect: function (dateText, inst) {
            updateWeekStartEnd();
            updateDateText(inst);
            selectCurrentWeek();
        },
        beforeShowDay: function (date) {
            var cssClass = '';
            if (date >= startDate && date <= endDate) cssClass = 'ui-datepicker-current-day';
            return [true, cssClass];
        },
        onChangeMonthYear: function (year, month, inst) {
            selectCurrentWeek();
        }
    });

    selectCurrentWeek();

    $('.week-picker .ui-datepicker-calendar tr').on('mousemove', function () {
        $(this).find('td a').addClass('ui-state-hover');
    });
    $('.week-picker .ui-datepicker-calendar tr').on('mouseleave', function () {
        $(this).find('td a').removeClass('ui-state-hover');
    });

});