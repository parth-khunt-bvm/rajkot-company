var Attendance = function () {
    var attendanceList = function () {
        $('.select2').select2();
        var date = $('.change_date').val();
        var dataArr = { 'date': date };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#attendance-list',
            'ajaxURL': baseurl + "admin/attendance/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0, 5],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("click", ".delete-records", function() {
            var id = $(this).data('id');
            var dataAttr = $(this).data('attribute');
            setTimeout(function() {
                $('.yes-sure:visible').attr({
                    'data-attribute': dataAttr,
                    'data-id': id
                });
            }, 500);
        })

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var dataAttr = $(this).data('attribute');
            var data = { 'id': id,'dataAttr': dataAttr, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/attendance/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("change", ".change_date", function () {

            var html = '';
            html = '<table class="table table-bordered table-checkable" id="attendance-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Date</th>' +
                '<th>Employee</th>' +
                '<th>Attendance Type</th>' +
                '<th>Minutes</th>'+
                '<th>reason</th>' +
                '<th>Action</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>';

            $(".attendance-list").html(html);

            var html2 = '';
            html2 =  '<table class="table table-bordered table-checkable" id="emp-overtime-day-list">'+
                    '<thead>'+
                    '<tr>'+
                    '<th>#</th>'+
                    '<th>Date</th>'+
                    '<th>Employee</th>'+
                    '<th>Hours</th>'+
                    '<th>Note</th>'+
                    '<th>Action</th>'+
                    '</tr>'+
                    '</thead>'+
                    '<tbody>'+
                    '</tbody>'+
                    '</table>';

            $(".emp-overtime-day-list").html(html2);



            var date = $('.change_date').val();
            var dataArr = { 'date': date };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#attendance-list',
                'ajaxURL': baseurl + "admin/attendance/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 5],
                'noSearchApply': [0, 5],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);

            var date = $('.change_date').val();
            var dataArr = { 'date': date };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#emp-overtime-day-list',
                'ajaxURL': baseurl + "admin/emp-overtime/ajaxcall",
                'ajaxAction': 'get-emp-overtime-detail',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 0],
                'noSearchApply': [0, 0],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);
        })
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $("body").on("click", ".show-emp-attendance-form", function() {
            $("#show-emp-attendance-form").html('-').addClass('remove-branch-form');
            $("#show-emp-attendance-form").html('-').removeClass('show-emp-attendance-form');
            $("#add-emp-attendance-form").slideToggle("slow");
        })

        $("body").on("click", ".remove-branch-form", function() {
            $("#show-emp-attendance-form").html('+').removeClass('remove-branch-form');
            $("#show-emp-attendance-form").html('+').addClass('show-emp-attendance-form');
            $("#add-emp-attendance-form").slideToggle("slow");
        })

        var form = $('#add-emp-attendance-form');
        var rules = {
            date: { required: true },
            'employee_id[]': { required: true },
            'leave_type[]': {required: true}
        };

        var message = {
            date: { required: "Please enter date" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $('.select2').select2();
        $('body').on('click', '.add-attendance-button', function () {
            
            var selected = true;
            var emaployeeArray = [];
            $('.employee_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.attendance_error').text('Please Select Employee Name');
                        selected = false;
                    } else {
                        emaployeeArray.push(elem.val());
                        elem.parent().find('.attendance_error').text('');
                    }
                }
            });

            $('.leave_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.leave_error').text('Please Select Leave Type');
                        selected = false;
                    } else {
                        emaployeeArray.push(elem.val());
                        elem.parent().find('.leave_error').text('');
                    }
                }
            });

            $('.minutes').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.minute_error').text('Please Enter minute');
                        selected = false;
                    } else {
                        emaployeeArray.push(elem.val());
                        elem.parent().find('.minute_error').text('');
                    }
                }
            });

            if (selected) {
                var data = { employee: JSON.stringify(emaployeeArray) };
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/attendance/ajaxcall",
                    data: { 'action': 'get_employee_list', 'data': data },
                    success: function (data) {
                        $("#add_attendance_div").append(data)
                        $('.select2').select2();
                    }
                });
            }
        });
        $('body').on("click", ".remove-attendance", function () {
            $(this).closest('.removediv').remove();
        });
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = today.toLocaleString('en-US', { month: 'short' });
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('body').on('change', '.leave_select', function () {
            var leaveType = $(this).val(); // Get the selected leave type for this specific employee
            var minutesInput = $(this).closest('.row').find('.minutes'); // Find the corresponding minutes input for this employee

            if (leaveType === "0") {
                minutesInput.val("0").prop("disabled", false);
            } else if (leaveType === "1") {
                minutesInput.val("480").prop("disabled", false);
            } else if (leaveType === "2") {
                minutesInput.val("240").prop("disabled", false);
            } else if (leaveType === "3") {
                minutesInput.val("120").prop("disabled", false);
            }
        });

    }
    var trashList = function () {
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
        var date = $('.change_date').val();
        var dataArr = {  };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#attendance-list',
            'ajaxURL': baseurl + "admin/attendance/ajaxcall",
            'ajaxAction': 'get-attendance-data',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0, 5],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("click", ".restore-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        });

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var data = { id: id, 'activity': 'restore-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/attendance/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
    }
    var calendar = function () {
        $('.select2').select2();
        var leaveType = $("#leave_type").val();
        var month = $('#calendarMonthId').val();
        var year = $("#calendaryearId").val();
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
            var month = $('#calendarMonthId').val().padStart(2, '0');
            var year = $("#calendaryearId").val();
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
    var addAttendance = function () {
        var form = $('#add-attendance-form');
        var rules = {
            date: { required: true },
        };

        var message = {
            date: { required: "Please enter date" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
        $('.select2').select2();
        $('body').on('click', '.add-attendance-button', function () {
            var selected = true;
            var emaployeeArray = [];
            $('.employee_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.attendance_error').text('Please Select Employee Name');
                        selected = false;
                    } else {
                        emaployeeArray.push(elem.val());
                        elem.parent().find('.attendance_error').text('');
                    }
                }
            });

            $('.leave_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.leave_error').text('Please Select Leave Type');
                        selected = false;
                    } else {
                        emaployeeArray.push(elem.val());
                        elem.parent().find('.leave_error').text('');
                    }
                }
            });

            $('.minutes').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.minute_error').text('Please Enter minute');
                        selected = false;
                    } else {
                        emaployeeArray.push(elem.val());
                        elem.parent().find('.minute_error').text('');
                    }
                }
            });

            if (selected) {
                var data = { employee: JSON.stringify(emaployeeArray) };
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/attendance/ajaxcall",
                    data: { 'action': 'get_employee_list', 'data': data },
                    success: function (data) {
                        $("#add_attendance_div").append(data)
                        $('.select2').select2();
                    }
                });
            }

        });
        $('body').on("click", ".remove-attendance", function () {
            $(this).closest('.removediv').remove();
        });
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = today.toLocaleString('en-US', { month: 'short' });
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;

        $("#datepicker_date").val(today);
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        // $(".datepicker_date").val(today);
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
        $('#all_present').change(function () {
            if (this.checked) {
                var returnVal = $('#add_attendance_div').slideToggle('slow');
                $(this).prop("checked", returnVal);
            } else {
                var returnVal = $('#add_attendance_div').slideToggle('slow');
                $(this).prop("checked=disabled", returnVal);
            }
        });

        $('body').on('change', '.leave_select', function () {
            var leaveType = $(this).val(); // Get the selected leave type for this specific employee
            var minutesInput = $(this).closest('.row').find('.minutes'); // Find the corresponding minutes input for this employee

            if (leaveType === "0") {
                minutesInput.val("0").prop("disabled", false);
            } else if (leaveType === "1") {
                minutesInput.val("480").prop("disabled", false);
            } else if (leaveType === "2") {
                minutesInput.val("240").prop("disabled", false);
            } else if (leaveType === "3") {
                minutesInput.val("120").prop("disabled", false);
            }
        });


    }
    var editAttendance = function () {
        var form = $('#edit-attendance-form');
        var rules = {
            leave_type: { required: true },
            minutes: { required: true },
        };

        var message = {
            leave_type: { required: "Please select leave" },
            minutes: { required: "Please enter minute" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $('.select2').select2();

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
        $("body").on("click", ".delete-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/attendance/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $('body').on('change', '.leave_select', function () {
            var leaveType = $(this).val(); // Get the selected leave type for this specific employee
            var minutesInput = $(this).closest('.row').find('.minutes'); // Find the corresponding minutes input for this employee

            if (leaveType === "0") {
                minutesInput.val("0").prop("disabled", false);
            } else if (leaveType === "1") {
                minutesInput.val("480").prop("disabled", false);
            } else if (leaveType === "2") {
                minutesInput.val("240").prop("disabled", false);
            } else if (leaveType === "3") {
                minutesInput.val("120").prop("disabled", false);
            }
        });

    }

    return {
        init: function () {
            calendar();
        },
        add: function () {
            addAttendance();
        },
        edit: function () {
            editAttendance();
        },
        list: function () {
            calendar();
            attendanceList();
        },
        attendance_list: function () {
            attendanceReportList();
        },
        trash_init:function(){
            trashList();
        }
    }
}();
