var Countersheet = function(){
    var countersheetList = function () {
        $('.select2').select2();
        var branch = $('#att_report_branch_id').val();
        var technology = $('#att_report_technology_id').val();
        var month = $('#att_report_month_id').val();
        var year = $('#att_report_year_id').val();
        var dataArr = {'branch': branch,'technology': technology,'month': month,'year': year,};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#attendance-report-list',
            'ajaxURL': baseurl + "admin/countersheet/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 9],
            'noSearchApply': [0, 9],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("change", ".counter-sheet-filter", function () {

            var html = '';
            html ='<table class="table table-bordered table-checkable" id="attendance-report-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Employee</th>'+
            '<th>Department</th>'+
            '<th>Total Working Day</th>'+
            '<th>Present Day</th>'+
            '<th>Absent Day</th>'+
            '<th>Half leave</th>'+
            '<th>Sort Leave</th>'+
            '<th>total</th>'+
            '<th>Action</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".attendance-report-list").html(html);

            var branch = $('#att_report_branch_id').val();
            var technology = $('#att_report_technology_id').val();
            var month = $('#att_report_month_id').val();
            var year = $('#att_report_year_id').val();
            var dataArr = {'branch': branch,'technology': technology,'month': month,'year': year,};

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#attendance-report-list',
                'ajaxURL': baseurl + "admin/countersheet/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 9],
                'noSearchApply': [0, 9],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);

        })
    }

    var countersheetcalender = function () {

        $('body').on("click",".counter-sheet",function(){
            $('.select2').select2();
            var element = $(this);
            var userId = $(this).data('user-id');
            var month = new Date().getMonth() + 1;
            var year = new Date().getFullYear();

            var data = { 'month': month, 'year': year, 'userId': userId }
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/countersheet/ajaxcall",
                data: { 'action': 'get_employee_details', 'data': data },
                success: function (data) {

                        var res = JSON.parse(data);
                        $('.select2').select2();

                        eventArray = [];
                        $.each(res, function (key, value) {
                            console.log(value);

                            var temp = {
                                title: value.attendance_type,
                                start: value.date,
                                description: value.description,
                                className: value.class
                            };

                            eventArray.push(temp);
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
            $("body").on("change", ".change-fillter", function(){
                console.log("change");

                var html = '';
                html = '<div id="attendance_calendar"></div>';

                $(".attendance-list").html(html);

                var month = $('#monthId').val().padStart(2, '0');
                var year = $("#yearId").val();
                console.log(month, year);

                var data = {'userId': userId, 'month': month, 'year': year }
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/countersheet/ajaxcall",
                    data: { 'action': 'get_employee_details', 'data': data },
                    success: function (data) {
                            var res = JSON.parse(data);
                            console.log("res", res);
                            $('.select2').select2();
                            eventArray = [];
                            $.each(res, function (key, value) {
                                var temp = {
                                    title: value.attendance_type,
                                    start: value.date,
                                    description: value.description,
                                    className: value.class
                                };
                                eventArray.push(temp);
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
        });
    }

    return {
        list:function(){
            countersheetList();
        },
        counterlist_calender:function(){
            countersheetcalender();
        }
    }
}();
