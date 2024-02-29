var EmpAttendance = function () {
    var empCalendar = function () {
    $('.select2').select2();
    var leaveType = $("#leave_type").val();
    var month = $('#monthId').val();
    var year = $("#yearId").val();
    // var data = { 'leaveType': leaveType, 'month': month, 'year': year };
    var data = {};

    $.ajax({
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('input[name="_token"]').val(),
        },
        url: baseurl + "employee/emp-attendances/ajaxcall",
        data: { 'action': 'get_emp_attendance_list', 'data': data },

        success: function (data) {
            $('.select2').select2();
            var res = JSON.parse(data);
            console.log("cal", res);
            eventArray = [];
            $.each(res, function (key, value) {
                if (typeof value.is_holiday !== 'undefined') {
                    var temp = {
                        title: 'Holiday ' + value.is_holiday,
                        start: value.date,
                        className: 'fc-event-danger'
                    };
                    eventArray.push(temp);

                    var temp5 = {
                        title: 'Employee Overtime ' + value.emp_overtime,
                        start: value.date,
                        className: 'fc-event-primary'
                    };
                    eventArray.push(temp5);

                }
                else if (isWeekend(value.date) == true) {
                    var temp5 = {
                        title: 'Employee Overtime ' + value.emp_overtime,
                        start: value.date,
                        className: 'fc-event-warning'
                    };
                    eventArray.push(temp5);
                }
                else {
                    var temp = {
                        title: 'Present ' + value.present,
                        start: value.date,
                        className: 'fc-event-danger'
                    };
                    eventArray.push(temp);
                    var temp2 = {
                        title: 'Absent ' + value.absent,
                        start: value.date,
                        className: 'fc-event-success'
                    };
                    eventArray.push(temp2);
                    var temp3 = {
                        title: 'Half Day ' + value.half_day,
                        start: value.date,
                        className: 'fc-event-info'
                    };
                    eventArray.push(temp3);
                    var temp4 = {
                        title: 'Short Leave ' + value.sort_leave,
                        start: value.date,
                        className: 'fc-event-warning'
                    };
                    eventArray.push(temp4);
                    var temp5 = {
                        title: 'Employee Overtime ' + value.emp_overtime,
                        start: value.date,
                        className: 'fc-event-primary'
                    };
                    eventArray.push(temp5);
                }
            });
            var todayDate = moment().startOf('day');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var calendarEl = document.getElementById('attendance_calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                themeSystem: 'bootstrap',

                isRTL: KTUtil.isRTL(),

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay'
                },

                selectable: true,
                selectHelper: true,
                dateClick: function (info) {
                    // Redirect to another page with the clicked date information
                    var clickedDate = new Date(info.dateStr);
                    var dd = String(clickedDate.getDate()).padStart(2, '0');
                    var mm = clickedDate.toLocaleString('en-US', { month: 'short' });
                    var yyyy = clickedDate.getFullYear();
                    clickedDate = dd + '-' + mm + '-' + yyyy;
                    window.location.href = baseurl + 'admin/attendance/day/list?date=' + clickedDate; // Change 'another-page.html' to your desired page
                },
                height: 800,
                contentHeight: 1500,
                aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + 'T09:25:00', // just for demo
                defaultView: 'dayGridMonth',
                defaultDate: TODAY,
                editable: true,
                eventLimit: true, // allow "more" link when too many events
                navLinks: true,
                firstDay: 1,
                // weekends: true,
                events: eventArray,
                eventRender: function (info) {
                    var element = $(info.el);
                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                }
            });
            calendar.render();
        },
    });

    $("body").on("change", ".change-fillter", function () {

        var html = '';
        html = '<div id="attendance_calendar"></div>';

        $(".attendance-list").html(html);

        var leaveType = $("#leave_type").val();
        var month = $('#monthId').val().padStart(2, '0');
        var year = $("#yearId").val();
        var data = { 'leaveType': leaveType, 'month': month, 'year': year };
        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            url: baseurl + "admin/attendance/ajaxcall",
            data: { 'action': 'get_attendance_list', 'data': data },
            success: function (data) {
                $('.select2').select2();
                var res = JSON.parse(data);

                eventArray = [];
                $.each(res, function (key, value) {

                    if (typeof value.is_holiday !== 'undefined') {
                        var temp = {
                            title: 'Holiday ' + value.is_holiday,
                            start: value.date,
                            className: 'fc-event-danger'
                        };
                        eventArray.push(temp);
                        var temp5 = {
                            title: 'Employee Overtime ' + value.emp_overtime,
                            start: value.date,
                            className: 'fc-event-primary'
                        };
                        eventArray.push(temp5);
                    } else if (isWeekend(value.date) === true ) {
                        var temp5 = {
                            title: 'Employee Overtime ' + value.emp_overtime,
                            start: value.date,
                            className: 'fc-event-warning'
                        };
                        eventArray.push(temp5);
                    }
                    else {
                        var temp = {
                            title: 'Present ' + value.present,
                            start: value.date,
                            className: 'fc-event-danger'
                        };
                        eventArray.push(temp);
                        var temp2 = {
                            title: 'Absent ' + value.absent,
                            start: value.date,
                            className: 'fc-event-success'
                        };
                        eventArray.push(temp2);
                        var temp3 = {
                            title: 'Half Day ' + value.half_day,
                            start: value.date,
                            className: 'fc-event-info'
                        };
                        eventArray.push(temp3);
                        var temp4 = {
                            title: 'Short Leave ' + value.sort_leave,
                            start: value.date,
                            className: 'fc-event-warning'
                        };
                        eventArray.push(temp4);
                        var temp5 = {
                            title: 'Employee Overtime ' + value.emp_overtime,
                            start: value.date,
                            className: 'fc-event-primary'
                        };
                        eventArray.push(temp5);
                    }
                });
                var todayDate = moment().startOf('day');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var calendarEl = document.getElementById('attendance_calendar');

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                    themeSystem: 'bootstrap',

                    isRTL: KTUtil.isRTL(),

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridDay'
                    },

                    selectable: true,
                    selectHelper: true,
                    dateClick: function (info) {
                        // Redirect to another page with the clicked date information
                        var clickedDate = new Date(info.dateStr);
                        var dd = String(clickedDate.getDate()).padStart(2, '0');
                        var mm = clickedDate.toLocaleString('en-US', { month: 'short' });
                        var yyyy = clickedDate.getFullYear();
                        clickedDate = dd + '-' + mm + '-' + yyyy;
                        window.location.href = baseurl + 'admin/attendance/day/list?date=' + clickedDate; // Change 'another-page.html' to your desired page
                    },
                    height: 800,
                    contentHeight: 1500,
                    aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                    nowIndicator: true,
                    now: TODAY + 'T09:25:00', // just for demo
                    defaultView: 'dayGridMonth',
                    defaultDate: year + '-' + month + '-01',
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    navLinks: true,
                    firstDay: 1,
                    // weekends: false,
                    // initialDate: year + '-' + month + '-01',
                    events: eventArray,
                    eventRender: function (info) {
                        var element = $(info.el);
                        if (info.event.extendedProps && info.event.extendedProps.description) {
                            if (element.hasClass('fc-day-grid-event')) {
                                element.data('content', info.event.extendedProps.description);
                                element.data('placement', 'top');
                                KTApp.initPopover(element);
                            } else if (element.hasClass('fc-time-grid-event')) {
                                element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                            } else if (element.find('.fc-list-item-title').lenght !== 0) {
                                element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                            }
                        }
                    }
                });
                calendar.render();
            },
        });

    });

    function isWeekend(date) {
        var day = new Date(date).getDay();
        return day === 0 || day === 6; // Sunday or Saturday
    }

}
return {
    init: function () {
        empCalendar();
    },
}
}();
