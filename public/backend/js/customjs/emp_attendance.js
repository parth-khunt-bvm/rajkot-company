var EmpAttendance = function () {
    var empCalendar = function () {
        $('.select2').select2();
        var month = $('#empMonthId').val();
        var year = $("#empYearId").val();
        var data = { 'month': month, 'year': year };
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
                    if (value.is_holiday !== null && value.is_holiday !== 'null' && typeof value.is_holiday !== 'undefined') {
                        // This is a holiday event
                        var temp2 = {
                            title: 'Holiday ' + value.is_holiday,
                            start: value.date,
                            className: 'fc-event-danger'
                        };
                        eventArray.push(temp2);

                        // Add employee overtime event
                        if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0) {

                            var temp5 = {
                                title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                start: value.date,
                                className: 'fc-event-warning'
                            };
                            eventArray.push(temp5);
                        }
                    } else if (isWeekend(value.date) === true) {
                        // This is a weekend (Saturday or Sunday)
                        if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0) {

                            var temp5 = {
                                title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                start: value.date,
                                className: 'fc-event-warning'
                            };
                            eventArray.push(temp5);
                        }
                    } else {
                        // Regular attendance event
                        if (value.attendance_type !== null && value.attendance_type !== 'null' && typeof value.attendance_type !== 'undefined') {
                            var temp = {
                                title: value.attendance_type,
                                start: value.date,
                                description: value.description,
                                className: value.class
                            };
                            eventArray.push(temp);
                        }

                        if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0) {

                            // Add employee overtime event
                            var temp5 = {
                                title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                start: value.date,
                                className: "fc-event-warning"
                            };
                            eventArray.push(temp5);

                        }
                    }

                });
                var todayDate = moment().startOf('day');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var calendarEl = document.getElementById('emp_attendance_calendar');

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

        $("body").on("change", ".emp-cal-fillter", function () {

            var html = '';
            html = '<div id="emp_attendance_calendar"></div>';

            $(".emp-attendance-list").html(html);

            var month = $('#empMonthId').val().padStart(2, '0');
            var year = $("#empYearId").val();
            var data = { 'month': month, 'year': year };


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

                    eventArray = [];
                    $.each(res, function (key, value) {
                        if (value.is_holiday !== null && value.is_holiday !== 'null' && typeof value.is_holiday !== 'undefined') {
                            // This is a holiday event
                            var temp2 = {
                                title: 'Holiday ' + value.is_holiday,
                                start: value.date,
                                className: 'fc-event-danger'
                            };
                            eventArray.push(temp2);

                            // Add employee overtime event
                            if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0) {

                                var temp5 = {
                                    title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                    start: value.date,
                                    className: 'fc-event-warning'
                                };
                                eventArray.push(temp5);
                            }
                        } else if (isWeekend(value.date) === true) {
                            // This is a weekend (Saturday or Sunday)
                            if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0) {

                                var temp5 = {
                                    title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                    start: value.date,
                                    className: 'fc-event-warning'
                                };
                                eventArray.push(temp5);
                            }
                        } else {
                            // Regular attendance event
                            if (value.attendance_type !== null && value.attendance_type !== 'null' && typeof value.attendance_type !== 'undefined') {
                                var temp = {
                                    title: value.attendance_type,
                                    start: value.date,
                                    description: value.description,
                                    className: value.class
                                };
                                eventArray.push(temp);
                            }

                            if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0) {

                                // Add employee overtime event
                                var temp5 = {
                                    title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                    start: value.date,
                                    className: "fc-event-warning"
                                };
                                eventArray.push(temp5);

                            }
                        }

                    });
                    var todayDate = moment().startOf('day');
                    var TODAY = todayDate.format('YYYY-MM-DD');
                    var calendarEl = document.getElementById('emp_attendance_calendar');

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
