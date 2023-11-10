var Attendance = function () {
    var list = function () {
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#attendence-list',
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
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });



        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

    }

    var calendar = function () {

        var leaveType = $("#leave_type").val();
        var data = {'leaveType' : leaveType} ;

        $.ajax({
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val(),
            },
            url: baseurl + "admin/attendance/ajaxcall",
            data: { 'action': 'get_attendance_list', 'data' : data },
            success: function (data) {
                var res = JSON.parse(data);
                console.log(res);
                console.log(res.amount.present);
                var todayDate = moment().startOf('day');
                var YM = todayDate.format('YYYY-MM');
                var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');
                var dynamicTitle = '3';

                var calendarEl = document.getElementById('kt_calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list'],
                    themeSystem: 'bootstrap',

                    isRTL: KTUtil.isRTL(),

                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },

                    height: 800,
                    contentHeight: 1200,
                    aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

                    nowIndicator: true,
                    now: TODAY + 'T09:25:00', // just for demo

                    views: {
                        dayGridMonth: { buttonText: 'month' },
                        timeGridWeek: { buttonText: 'week' },
                        timeGridDay: { buttonText: 'day' }
                    },

                    defaultView: 'dayGridMonth',
                    defaultDate: TODAY,

                    editable: true,
                    eventLimit: true, // allow "more" link when too many events
                    navLinks: true,
                    events: [
                        {
                            title: 'Present ' + res.amount.present,
                            start: YM + '-01',
                            description: 'Description for Event 1',
                            className: 'fc-event-danger fc-event-solid-warning'
                        },
                        {
                            title: 'Absent ' + res.amount.absent,
                            start: YM + '-01',
                            description: 'Description for Event 2',
                            className: 'fc-event-success fc-event-solid-info'
                        },
                        {
                            title: 'Half Leave ' + res.amount.half_day,
                            start: YM + '-01',
                            description: 'Description for Event 3',
                            className: 'fc-event-info fc-event-solid-success'
                        },
                        {
                            title: 'Sort Leave ' + res.amount.sort_leave,
                            start: YM + '-01',
                            description: 'Description for Event 4',
                            className: 'fc-event-warning fc-event-solid-danger'
                        },
                        //     {
                        //         title: 'Reporting',
                        //         start: YM + '-14T13:30:00',
                        //         description: 'Lorem ipsum dolor incid idunt ut labore',
                        //         end: YM + '-14',
                        //         className: "fc-event-success"
                        //     },
                        //     {
                        //         title: 'Company Trip',
                        //         start: YM + '-02',
                        //         description: 'Lorem ipsum dolor sit tempor incid',
                        //         end: YM + '-03',
                        //         className: "fc-event-primary"
                        //     },
                        //     {
                        //         title: 'ICT Expo 2017 - Product Release',
                        //         start: YM + '-03',
                        //         description: 'Lorem ipsum dolor sit tempor inci',
                        //         end: YM + '-05',
                        //         className: "fc-event-light fc-event-solid-primary"
                        //     },
                        //     {
                        //         title: 'Dinner',
                        //         start: YM + '-12',
                        //         description: 'Lorem ipsum dolor sit amet, conse ctetur',
                        //         end: YM + '-10'
                        //     },
                        //     {
                        //         id: 999,
                        //         title: 'Repeating Event',
                        //         start: YM + '-09T16:00:00',
                        //         description: 'Lorem ipsum dolor sit ncididunt ut labore',
                        //         className: "fc-event-danger"
                        //     },
                        //     {
                        //         id: 1000,
                        //         title: 'Repeating Event',
                        //         description: 'Lorem ipsum dolor sit amet, labore',
                        //         start: YM + '-16T16:00:00'
                        //     },
                        //     {
                        //         title: 'Conference',
                        //         start: YESTERDAY,
                        //         end: TOMORROW,
                        //         description: 'Lorem ipsum dolor eius mod tempor labore',
                        //         className: "fc-event-primary"
                        //     },
                        //     {
                        //         title: 'Meeting',
                        //         start: TODAY + 'T10:30:00',
                        //         end: TODAY + 'T12:30:00',
                        //         description: 'Lorem ipsum dolor eiu idunt ut labore'
                        //     },
                        //     {
                        //         title: 'Lunch',
                        //         start: TODAY + 'T12:00:00',
                        //         className: "fc-event-info",
                        //         description: 'Lorem ipsum dolor sit amet, ut labore'
                        //     },
                        //     {
                        //         title: 'Meeting',
                        //         start: TODAY + 'T14:30:00',
                        //         className: "fc-event-warning",
                        //         description: 'Lorem ipsum conse ctetur adipi scing'
                        //     },
                        //     {
                        //         title: 'Happy Hour',
                        //         start: TODAY + 'T17:30:00',
                        //         className: "fc-event-info",
                        //         description: 'Lorem ipsum dolor sit amet, conse ctetur'
                        //     },
                        //     {
                        //         title: 'Dinner',
                        //         start: TOMORROW + 'T05:00:00',
                        //         className: "fc-event-solid-danger fc-event-light",
                        //         description: 'Lorem ipsum dolor sit ctetur adipi scing'
                        //     },
                        //     {
                        //         title: 'Birthday Party',
                        //         start: TOMORROW + 'T07:00:00',
                        //         className: "fc-event-primary",
                        //         description: 'Lorem ipsum dolor sit amet, scing'
                        //     },
                        //     {
                        //         title: 'Click for Google',
                        //         url: 'http://google.com/',
                        //         start: YM + '-28',
                        //         className: "fc-event-solid-info fc-event-light",
                        //         description: 'Lorem ipsum dolor sit amet, labore'
                        //     }
                    ],

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
            error: function () {
                console.log('err');
            }
        });


    }


    var addAttendance = function () {
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
                        var employeeList = JSON.parse(data);
                    }
                });
            }
        });

        $('body').on("click", ".remove-attendance", function () {
            $(this).closest('.removediv').remove();
        });

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
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
    }

    return {
        init: function () {
            // list();
            calendar();
        },
        add: function () {
            addAttendance();
        },
        edit: function () {
            editAttendance();
        },
    }
}();
