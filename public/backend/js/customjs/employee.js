
var Employee = function () {
    var list = function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        var technology = $("#technology_id").val();
        var designation = $("#designation_id").val();
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();
        var dataArr = {
            'technology': technology, 'designation': designation, 'startDate': startDate, 'endDate': endDate
        };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-list',
            'ajaxURL': baseurl + "admin/employee/ajaxcall",
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

        $("body").on("click", ".deactive-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-deactive:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-deactive', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'deactive-records', _token: $('#_token').val() };
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

        $("body").on("click", ".active-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-active:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-active', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'active-records', _token: $('#_token').val() };
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

        var importform = $('#import-employee');
        var rules = {
            file: { required: true },
        };

        var message = {
            file: { required: "Please select file" },
        }
        handleFormValidateWithMsg(importform, rules, message, function (importform) {
            handleAjaxFormSubmit(importform, true);
        });
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $('body').on('change', '.change-fillter', function () {
            var target = [75, 76, 77, 78, 79, 80];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="employee-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Name</th>' +
                '<th>Department</th>' +
                '<th>Designation</th>' +
                '<th>Date of Joining</th>' +
                '<th>Gmail</th>' +
                '<th>Emergency Contact</th>' +
                '<th>G Pay Number</th>' +
                '<th>Experience</th>' +
                '<th>Status</th>';
                if (isAdmin == 'Y' || intersectCount > 0 ) {
                    html += '<th>Action</th>';
                }
                html += '</tr>' +
                '</thead>' +
                '<tbody>' +

                '</tbody>' +
                '</table>';

            $(".employee-list").html(html);


            var technology = $("#technology_id").val();
            var designation = $("#designation_id").val();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            var dataArr = {
                'technology': technology, 'designation': designation, 'startDate': startDate, 'endDate': endDate
            };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#employee-list',
                'ajaxURL': baseurl + "admin/employee/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 0],
                'noSearchApply': [0, 0],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);

        });

        $("body").on("click", "#show-employee-filter", function () {
            $("div .employee-filter").slideToggle("slow");
        })

        $("body").on("click", ".reset", function () {
            location.reload(true);
        });

    }
    var addEmployee = function () {

        var form = $('#add-employee-form');

        var rules = {
            experience: { required: true },
            hired_by: { required: true },
            salary: { required: true },
            status: { required: true }
        };

        var message = {
            experience: { required: "Please enter experience" },
            hired_by: { required: "Please enter hired by" },
            salary: { required: "Please enter salary" },
            status: { required: "Please select status" }
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        var validation = {
            first_name: {
                validators: {
                    notEmpty: { message: 'Please enter first name' },
                    textonly: { message: 'Please enter valid first name' }
                }
            },
            last_name: {
                validators: {
                    notEmpty: { message: 'Please enter last name' },
                    textonly: { message: 'Please enter valid last name' }
                }
            },
            technology: {
                validators: {
                    notEmpty: { message: 'Please select technology' },
                }
            },
            designation: {
                validators: {
                    notEmpty: { message: 'Please select designation' },
                }
            },
            dob: {
                validators: {
                    notEmpty: { message: 'Please enter date of birth' },
                }
            },
            doj: {
                validators: {
                    notEmpty: { message: 'Please enter date of joining' },
                }
            },
            gmail: {
                validators: {
                    notEmpty: { message: 'Please enter company gmail' },
                }
            },
            gmail_password: {
                validators: {
                    notEmpty: { message: 'Please enter gmail password' },
                }
            },
            personal_email: {
                validators: {
                    notEmpty: { message: 'Please enter personal email' },
                    emailonly: { message: 'Please enter a valid email' },
                }
            },
            bank_name: {
                validators: {
                    notEmpty: { message: 'Please enter bank name' },
                    textonly: { message: 'Please enter valid bank name' }
                }
            },
            acc_holder_name: {
                validators: {
                    notEmpty: { message: 'Please enter account holder name' },
                    textonly: { message: 'Please enter valid account holder name' }
                }
            },
            account_number: {
                validators: {
                    notEmpty: { message: 'Please enter account number' },
                    // numberonly: { message: 'Please enter a valid account number'},
                }
            },
            ifsc_code: {
                validators: {
                    notEmpty: { message: 'Please enter ifsc code' },
                }
            },
            pan_number: {
                validators: {
                    notEmpty: { message: 'Please enter pancard number' },
                }
            },
            aadhar_card_number: {
                validators: {
                    notEmpty: { message: 'Please enter aadhar card number' },
                    numberonly: { message: 'Please enter a valid account number' },
                }
            },
            google_pay: {
                validators: {
                    notEmpty: { message: 'Please enter g-pay number' },
                    numberonly: { message: 'Please enter a valid g-pay number' },
                }
            },
            parent_name: {
                validators: {
                    notEmpty: { message: 'Please enter parent name' },
                    textonly: { message: 'Please enter valid parent name' }
                }
            },
            personal_number: {
                validators: {
                    notEmpty: { message: 'Please enter personal number' },
                }
            },
            emergency_contact: {
                validators: {
                    notEmpty: { message: 'Please enter emergency contact' },
                }
            },
            address: {
                validators: {
                    notEmpty: { message: 'Please enter address' },
                }
            },
            experience: {
                validators: {
                    notEmpty: { message: 'Please enter experience' },
                }
            },
            hired_by: {
                validators: {
                    notEmpty: { message: 'Please select manager' },
                }
            },
            salary: {
                validators: {
                    notEmpty: { message: 'Please enter salary' },
                }
            },
            // bond_file : {
            //     validators: {
            //         notEmpty: { message: 'Please select bond file'},
            //     }
            // },
            status: {
                validators: {
                    notEmpty: { message: 'Please select status' },
                }
            }

        };

        function checkValidation(validationType, message, value) {

            switch (validationType) {
                case 'notEmpty':
                    if (value.trim() === '') {
                        return false;
                    }
                    break;

                case 'textonly':
                    if (!isValidTextOnly(value)) {
                        return false;
                    }
                    break;

                case 'emailonly':
                    if (!validateEmail(value)) {
                        return false;
                    }
                    break;

                case 'numberonly':
                    if (!validateNumber(value)) {
                        return false;
                    }
                    break;
            }
            return true;
        }

        function isValidTextOnly(value) {
            return /^[A-Za-z\s]+$/.test(value);
        }

        function validateEmail(email) {
            var regex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(email);
        }

        function validateNumber(e) {
            const pattern = /^[0-9]+$/;

            return pattern.test(e);
        }

        $("body").on("click", ".prev-step", function () {
            var prevPageNo = $(this).data('prev-page');
            var currentPageNo = $(this).data('current-page');

            $("#step" + currentPageNo).css('display', 'none');
            $("#step" + prevPageNo).css('display', 'block');
        });

        $("body").on("click", ".next-step", function () {
            var nextPageNo = $(this).data('next-page');
            var currentPageNo = $(this).data('current-page');
            var customValid = true;
            $('.input-name').each(function () {
                if ($(this).is(':visible')) {
                    var element = $(this);
                    var inputName = element.attr('name');
                    var errorElement = element.parent().find('.type_error');
                    errorElement.text('');
                    var checkValidInput = true;
                    if (validation[inputName]) {
                        $.each(validation[inputName]['validators'], function (index, value) {
                            if (checkValidInput) {
                                checkValidInput = checkValidation(index, value['message'], element.val());
                                if (checkValidInput) {
                                    errorElement.text('');
                                } else {
                                    customValid = false;
                                    errorElement.text(value['message']);
                                }
                            }
                        });
                    }
                }
            });

            if (customValid) {
                $("#step" + nextPageNo).css('display', 'block');
                $("#step" + currentPageNo).css('display', 'none');
            }

        });
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
        $(".date_of_birth").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
            endDate: new Date()
        });
    }
    var editEmployee = function () {
        $('.select2').select2();
        var form = $('#edit-employee-form');
        var rules = {
            experience: { required: true },
            hired_by: { required: true },
            salary: { required: true },
            status: { required: true }
        };

        var message = {
            experience: { required: "Please enter experience" },
            hired_by: { required: "Please enter hired by" },
            salary: { required: "Please enter salary" },
            status: { required: "Please select status" }
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
        var validation = {
            first_name: {
                validators: {
                    notEmpty: { message: 'Please enter first name' },
                    textonly: { message: 'Please enter valid first name' }
                }
            },
            last_name: {
                validators: {
                    notEmpty: { message: 'Please enter last name' },
                    textonly: { message: 'Please enter valid last name' }
                }
            },
            technology: {
                validators: {
                    notEmpty: { message: 'Please select technology' },
                }
            },
            dob: {
                validators: {
                    notEmpty: { message: 'Please enter date of birth' },
                }
            },
            doj: {
                validators: {
                    notEmpty: { message: 'Please enter date of joining' },
                }
            },
            gmail: {
                validators: {
                    notEmpty: { message: 'Please enter company gmail' },
                }
            },
            gmail_password: {
                validators: {
                    notEmpty: { message: 'Please enter gmail password' },
                }
            },
            personal_email: {
                validators: {
                    notEmpty: { message: 'Please enter personal email' },
                    emailonly: { message: 'Please enter a valid email' },
                }
            },
            bank_name: {
                validators: {
                    notEmpty: { message: 'Please enter bank name' },
                    textonly: { message: 'Please enter valid bank name' }
                }
            },
            acc_holder_name: {
                validators: {
                    notEmpty: { message: 'Please enter account holder name' },
                    textonly: { message: 'Please enter valid account holder name' }
                }
            },
            account_number: {
                validators: {
                    notEmpty: { message: 'Please enter account number' },
                    // numberonly: { message: 'Please enter a valid account number'},
                }
            },
            ifsc_code: {
                validators: {
                    notEmpty: { message: 'Please enter ifsc code' },
                }
            },
            pan_number: {
                validators: {
                    notEmpty: { message: 'Please enter pancard number' },
                }
            },
            aadhar_card_number: {
                validators: {
                    notEmpty: { message: 'Please enter aadhar card number' },
                    numberonly: { message: 'Please enter a valid account number' },
                }
            },
            google_pay: {
                validators: {
                    notEmpty: { message: 'Please enter g-pay number' },
                    numberonly: { message: 'Please enter a valid g-pay number' },
                }
            },
            parent_name: {
                validators: {
                    notEmpty: { message: 'Please enter parent name' },
                    textonly: { message: 'Please enter valid parent name' }
                }
            },
            personal_number: {
                validators: {
                    notEmpty: { message: 'Please enter pancard number' },
                }
            },
            emergency_contact: {
                validators: {
                    notEmpty: { message: 'Please enter emergency contact' },
                }
            },
            address: {
                validators: {
                    notEmpty: { message: 'Please enter address' },
                }
            },
            experience: {
                validators: {
                    notEmpty: { message: 'Please enter experience' },
                }
            },
            hired_by: {
                validators: {
                    notEmpty: { message: 'Please enter hired by' },
                }
            },
            salary: {
                validators: {
                    notEmpty: { message: 'Please enter salary' },
                }
            },
            status: {
                validators: {
                    notEmpty: { message: 'Please select status' },
                }
            }

        };

        function checkValidation(validationType, message, value) {

            switch (validationType) {
                case 'notEmpty':
                    if (value.trim() === '') {
                        return false;
                    }
                    break;

                case 'textonly':
                    if (!isValidTextOnly(value)) {
                        return false;
                    }
                    break;

                case 'emailonly':
                    if (!validateEmail(value)) {
                        return false;
                    }
                    break;

                case 'numberonly':
                    if (!validateNumber(value)) {
                        return false;
                    }
                    break;
            }
            return true;
        }

        function isValidTextOnly(value) {
            return /^[A-Za-z\s]+$/.test(value);
        }

        function validateEmail(email) {
            var regex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
            return regex.test(email);
        }

        function validateNumber(e) {
            const pattern = /^[0-9]+$/;

            return pattern.test(e);
        }

        $("body").on("click", ".prev-step", function () {
            var prevPageNo = $(this).data('prev-page');
            var currentPageNo = $(this).data('current-page');

            $("#step" + currentPageNo).css('display', 'none');
            $("#step" + prevPageNo).css('display', 'block');
        });

        $("body").on("click", ".next-step", function () {
            var nextPageNo = $(this).data('next-page');
            var currentPageNo = $(this).data('current-page');
            var customValid = true;
            $('.input-name').each(function () {
                if ($(this).is(':visible')) {
                    var element = $(this);
                    var inputName = element.attr('name');
                    var errorElement = element.parent().find('.type_error');
                    errorElement.text('');
                    var checkValidInput = true;
                    if (validation[inputName]) {
                        $.each(validation[inputName]['validators'], function (index, value) {
                            if (checkValidInput) {
                                checkValidInput = checkValidation(index, value['message'], element.val());
                                if (checkValidInput) {
                                    errorElement.text('');
                                } else {
                                    customValid = false;
                                    errorElement.text(value['message']);
                                }
                            }
                        });
                    }
                }
            });

            if (customValid) {
                $("#step" + nextPageNo).css('display', 'block');
                $("#step" + currentPageNo).css('display', 'none');
            }

        });



        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

    }
    var viewEmployee = function () {
        $('.select2').select2();
        $('body').on("click", ".user-menu", function () {
            var element = $(this);
            var type = $(this).data('type');
            var userId = $(this).data('user-id');
            var month = new Date().getMonth() + 1;
            var year = new Date().getFullYear();

            var data = { 'type': type, 'userId': userId, 'month': month, 'year': year }
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'get_employee_details', 'data': data },
                success: function (data) {
                    console.log(data);

                    if (type == 'attendance') {
                        var res = JSON.parse(data);

                        var html = "";
                        var html = '<div class="row mt-5 ml-5">' +
                            '<div class="col-md-3">' +
                            '<div class="form-group">' +
                            '<label> Month</label>' +
                            '<select class="form-control select2 month change-fillter" id="monthId" name="month">' +
                            '<option value="">Select Month</option>' +
                            '<option value="1" ' + (new Date().getMonth() + 1 === 1 ? 'selected="selected"' : '') + '>January</option>' +
                            '<option value="2" ' + (new Date().getMonth() + 1 === 2 ? 'selected="selected"' : '') + '>February</option>' +
                            '<option value="3" ' + (new Date().getMonth() + 1 === 3 ? 'selected="selected"' : '') + '>March</option>' +
                            '<option value="4" ' + (new Date().getMonth() + 1 === 4 ? 'selected="selected"' : '') + '>April</option>' +
                            '<option value="5" ' + (new Date().getMonth() + 1 === 5 ? 'selected="selected"' : '') + '>May</option>' +
                            '<option value="6" ' + (new Date().getMonth() + 1 === 6 ? 'selected="selected"' : '') + '>June</option>' +
                            '<option value="7" ' + (new Date().getMonth() + 1 === 7 ? 'selected="selected"' : '') + '>July</option>' +
                            '<option value="8" ' + (new Date().getMonth() + 1 === 8 ? 'selected="selected"' : '') + '>August</option>' +
                            '<option value="9" ' + (new Date().getMonth() + 1 === 9 ? 'selected="selected"' : '') + '>September</option>' +
                            '<option value="10" ' + (new Date().getMonth() + 1 === 10 ? 'selected="selected"' : '') + '>October</option>' +
                            '<option value="11" ' + (new Date().getMonth() + 1 === 11 ? 'selected="selected"' : '') + '>November</option>' +
                            '<option value="12" ' + (new Date().getMonth() + 1 === 12 ? 'selected="selected"' : '') + '>December</option>' +
                            '</select>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-md-3">' +
                            '<div class="form-group">' +
                            '<label> Year</label>' +
                            '<select class="form-control select2 year change-fillter" id="yearId" name="year">' +
                            '<option value="">Select Year</option>';

                        for (var i = 2019; i <= new Date().getFullYear(); i++) {
                            html += '<option value="' + i + '" ' + (i == new Date().getFullYear() ? 'selected="selected"' : '') + '>' + i + '</option>';
                        }
                        html += '</select>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="card card-custom">' +
                            '<div class="card-header">' +
                            '<div class="card-title">' +
                            '<h3 class="card-label">Attendance Calendar</h3>' +
                            '</div>' +
                            '</div>' +
                            '<div class="card-body">' +
                            '<div class="attendance-list">' +
                            '<div id="attendance_calendar"></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';

                        $(".employee-detail-view").html(html);
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
                    } else {
                        $(".employee-detail-view").html(data);
                    }

                    $('.user-menu-bar a.active').removeClass('active');
                    element.addClass('active');


                },
            });

            $("body").on("change", ".change-fillter", function(){
                console.log("change");

                var html = '';
                html = '<div id="attendance_calendar"></div>';

                $(".attendance-list").html(html);

                var month = $('#monthId').val().padStart(2, '0');
                var year = $("#yearId").val();

                var data = { 'type': type, 'userId': userId, 'month': month, 'year': year }
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/employee/ajaxcall",
                    data: { 'action': 'get_employee_details', 'data': data },
                    success: function (data) {
                        console.log("data", data);

                        if (type == 'attendance') {
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
                            // var month = 11;
                            // var year = 2023;

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
                        } else {
                            $(".employee-detail-view").html(data);
                        }

                        $('.user-menu-bar a.active').removeClass('active');
                        element.addClass('active');
                    },
                });
            });
        });

    }

    var employeeBirthdayList = function(){
        $('.select2').select2();
        var bdayTime = $("#employee_bday").val();
        var dataArr = {'bdayTime' : bdayTime} ;
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-birthday-list',
            'ajaxURL': baseurl + "admin/employee/ajaxcall",
            'ajaxAction': 'getbirthdaydatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0],
            'noSearchApply': [0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("change", ".employee_bday", function () {
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="employee-birthday-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Birth Date</th>'+
            '<th>Employee Name</th>'+
            '<th>Department</th>'+
            '<th>Designation</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".bday-list").html(html);

            var bdayTime = $("#employee_bday").val();
            var dataArr = {'bdayTime' : bdayTime} ;

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#employee-birthday-list',
                'ajaxURL': baseurl + "admin/employee/ajaxcall",
                'ajaxAction': 'getbirthdaydatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0],
                'noSearchApply': [0],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
        getDataTable(arrList);
        })
    }

    var employeeBondLastDateList = function(){
        var bondLastDateTime = $("#employee_bond_last_date").val();
        var dataArr = {'bondLastDateTime' : bondLastDateTime} ;
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-bond-last-date-list',
            'ajaxURL': baseurl + "admin/employee/ajaxcall",
            'ajaxAction': 'getbondlastdatedatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0],
            'noSearchApply': [0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("change", ".employee_bond_last_date", function () {
            var html = '';
            html ='<table class="table table-bordered table-checkable" id="employee-bond-last-date-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Bond Last Date</th>'+
            '<th>Employee Name</th>'+
            '<th>Department</th>'+
            '<th>Designation</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".bond-last-date-list").html(html);

            var bondLastDateTime = $("#employee_bond_last_date").val();
            var dataArr = {'bondLastDateTime' : bondLastDateTime} ;

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#employee-bond-last-date-list',
                'ajaxURL': baseurl + "admin/employee/ajaxcall",
                'ajaxAction': 'getbondlastdatedatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0],
                'noSearchApply': [0],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);
        })

    }
    return {
        init: function () {
            list();
        },
        add: function () {
            addEmployee();
        },
        edit: function () {
            editEmployee();
        },
        view: function () {
            viewEmployee();
        },
        employee_birthday:function(){
            employeeBirthdayList();
        },
        employee_bond_last_date:function(){
            employeeBondLastDateList();
        }
    }
}();
