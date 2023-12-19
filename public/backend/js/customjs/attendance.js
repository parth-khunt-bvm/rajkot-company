var Attendance = function () {
    var attendanceList = function () {
        $('.select2').select2();
        var date = $('.change_date').val();
        var dataArr = {'date': date};
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

        $("body").on("change", ".change_date", function() {

            var html = '';
            html =  '<table class="table table-bordered table-checkable" id="attendance-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Employee</th>'+
            '<th>Attendance Type</th>'+
            '<th>reason</th>'+
            '<th>Action</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".attendance-list").html(html);

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
        })
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
    }
    var calendar = function () {
        $('.select2').select2();
        var leaveType = $("#leave_type").val();
        var month = $('#monthId').val();
        var year = $("#yearId").val();
        var data = {'leaveType' : leaveType, 'month':month, 'year': year} ;

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            url: baseurl + "admin/attendance/ajaxcall",
            data: { 'action': 'get_attendance_list', 'data' : data },
            success: function (data) {
                $('.select2').select2();
                var res = JSON.parse(data);
                eventArray = [];
                $.each( res, function( key, value ) {
                    var temp =  {
                        title: 'Present ' + value.present ,
                        start: value.date ,
                        // description: 'Present Employee',
                        className: 'fc-event-danger'
                    } ;
                    eventArray.push(temp);
                    var temp2 =  {
                        title: 'Absent ' + value.absent  ,
                        start: value.date ,
                        // description: 'Absent Employee',
                        className: 'fc-event-success'
                    } ;
                    eventArray.push(temp2);
                    var temp3 =  {
                        title: 'Half Day ' + value.half_day  ,
                        start: value.date ,
                        // description: 'Half Day Leave Employee',
                        className: 'fc-event-info'
                    } ;
                    eventArray.push(temp3);
                    var temp4 =  {
                        title: 'Sort Leave ' + value.sort_leave,
                        start: value.date ,
                        // description: 'Sort Leave Employee',
                        className: 'fc-event-warning'
                    } ;
                    eventArray.push(temp4);
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
                    selectHelper : true,
                    dateClick: function(info) {
                        // Redirect to another page with the clicked date information
                        var clickedDate = new Date(info.dateStr);
                        var dd = String(clickedDate.getDate()).padStart(2, '0');
                        var mm = clickedDate.toLocaleString('en-US', { month: 'short' });
                        var yyyy = clickedDate.getFullYear();
                        clickedDate = dd + '-' + mm + '-' + yyyy;
                        window.location.href = 'http://127.0.0.1:8000/admin/attendance/day/list?date=' + clickedDate; // Change 'another-page.html' to your desired page
                      },
                    height: 800,
                    contentHeight: 1200,
                    aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                    nowIndicator: true,
                    now: TODAY + 'T09:25:00', // just for demo
                    defaultView: 'dayGridMonth',
                    defaultDate: TODAY,
                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    navLinks: true,
                    firstDay: 1,
                    weekends: false,
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

        $("body").on("change", ".change-fillter", function(){

            var html = '';
            html = '<div id="attendance_calendar"></div>';

            $(".attendance-list").html(html);

            var leaveType = $("#leave_type").val();
            var month = $('#monthId').val().padStart(2, '0');
            var year = $("#yearId").val();
            var data = {'leaveType' : leaveType, 'month':month, 'year': year} ;
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/attendance/ajaxcall",
                data: { 'action': 'get_attendance_list', 'data' : data },
                success: function (data) {
                    console.log(data);
                    $('.select2').select2();
                    var res = JSON.parse(data);
                    eventArray = [];
                    $.each( res, function( key, value ) {
                        var temp =  {
                            title: 'Present ' + value.present ,
                            start: value.date ,
                            // description: 'Present Employee',
                            className: 'fc-event-danger'
                        } ;
                        eventArray.push(temp);
                        var temp2 =  {
                            title: 'Absent ' + value.absent  ,
                            start: value.date ,
                            // description: 'Absent Employee',
                            className: 'fc-event-success'
                        } ;
                        eventArray.push(temp2);
                        var temp3 =  {
                            title: 'Half Day ' + value.half_day  ,
                            start: value.date ,
                            // description: 'Half Day Leave Employee',
                            className: 'fc-event-info'
                        } ;
                        eventArray.push(temp3);
                        var temp4 =  {
                            title: 'Sort Leave ' + value.sort_leave,
                            start: value.date ,
                            // description: 'Sort Leave Employee',
                            className: 'fc-event-warning'
                        } ;
                        eventArray.push(temp4);
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
                        selectHelper : true,
                        dateClick: function(info) {
                            // Redirect to another page with the clicked date information
                            var clickedDate = new Date(info.dateStr);
                            var dd = String(clickedDate.getDate()).padStart(2, '0');
                            var mm = clickedDate.toLocaleString('en-US', { month: 'short' });
                            var yyyy = clickedDate.getFullYear();
                            clickedDate = dd + '-' + mm + '-' + yyyy;
                            window.location.href = 'http://127.0.0.1:8000/admin/attendance/day/list?date=' + clickedDate; // Change 'another-page.html' to your desired page
                          },
                        height: 800,
                        contentHeight: 1200,
                        aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                        nowIndicator: true,
                        now: TODAY + 'T09:25:00', // just for demo
                        defaultView: 'dayGridMonth',
                        defaultDate: year + '-' + month + '-01',
                        editable: true,
                        eventLimit: true, // allow "more" link when too many events
                        navLinks: true,
                        firstDay: 1,
                        weekends: false,
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
        $("body").on("click", ".show-type-form", function () {
            $("#show-type-form").html('-').addClass('remove-type-form');
            $("#show-type-form").html('-').removeClass('show-type-form');
            $("#add-type").slideToggle("slow");
        })
        $("body").on("click", ".remove-type-form", function () {
            $("#show-type-form").html('+').removeClass('remove-type-form');
            $("#show-type-form").html('+').addClass('show-type-form');
            $("#add-type").slideToggle("slow");
        })

        $('#all_present').change(function() {
            if(this.checked) {
                var returnVal = $('#add_attendance_div').slideToggle('slow');
                $(this).prop("checked", returnVal);
            } else {
                var returnVal = $('#add_attendance_div').slideToggle('slow');
                $(this).prop("checked=disabled", returnVal);
            }
        });
    }
    var editAttendance = function () {
        var form = $('#edit-attendance-form');
        var rules = {
            leave_type: { required: true },
        };

        var message = {
            leave_type: { required: "Please select leave" },
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
        $("body").on("click", ".delete-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'delete-records', _token: $('#_token').val() };
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
    }
}();
