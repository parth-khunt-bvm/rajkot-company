
var Employee = function () {
    var list = function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        var branch = $("#employee_branch").val();
        var technology = $("#technology_id").val();
        var designation = $("#designation_id").val();
        var status = $("#status_id").val();
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();

        var dataArr = {
            'technology': technology, 'designation': designation, 'status': status, 'startDate': startDate, 'endDate': endDate, 'branch': branch
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

        $("body").on("click", ".left-employee", function () {
            var id = $(this).data('id');

            var semi_left = false;

            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'get-employee-assets', 'data': data },
                success: function (data) {
                    var assets = JSON.parse(data);
                    console.log(assets);
                    if(assets.length > 0){
                        semi_left = true;

                        $('.left-employee-modal-body').empty();
                        $('.left-employee-modal-body').append('<p>This employee have following assets allocated :-</p>');

                        var ul = $('<ul></ul>');
                        $.each(assets, function(index, asset) {
                            ul.append('<li>' + asset.asset_type + ' (' + asset.asset_code + ')</li>');
                        });

                        $('.left-employee-modal-body').append(ul);
                        $('.left-employee-modal-body').append('<span class="text-dark-50">Please unallocate this assets to left employee or right now you can semi left the Employee.</span>');
                    } else {
                        $('.left-employee-modal-body').empty();
                        $('.left-employee-modal-body').append('<p>This employee don\'t have any assets allocated.</p>');
                    }
                    handleAjaxResponse(data);
                }
            });

            setTimeout(function () {
                $('.yes-sure-deactive:visible').attr('data-id', id);
                $('.yes-sure-deactive:visible').attr('data-activity', semi_left == false ? 'left-employee' : 'semi-left-employee');
            }, 500);
        });

        $("body").on("click", ".semi-left-employee", function () {
            var id = $(this).data('id');

            var semi_left = false;

            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'get-employee-assets', 'data': data },
                success: function (data) {
                    var assets = JSON.parse(data);
                    console.log(assets);
                    if(assets.length > 0){
                        semi_left = true;

                        $('.semi-left-employee-modal-body').empty();
                        $('.semi-left-employee-modal-body').append('<p>This employee have following assets allocated :-</p>');

                        var ul = $('<ul></ul>');
                        $.each(assets, function(index, asset) {
                            ul.append('<li>' + asset.asset_type + ' (' + asset.asset_code + ')</li>');
                        });

                        $('.semi-left-employee-modal-body').append(ul);
                        $('.semi-left-employee-modal-body').append('<span class="text-dark-50">Please unallocate this assets to left employee or right now you can semi left the Employee.</span>');
                    } else {
                        $('.semi-left-employee-modal-body').empty();
                        $('.semi-left-employee-modal-body').append('<p>This employee don\'t have any assets allocated.</p>');
                    }
                    handleAjaxResponse(data);
                }
            });

            setTimeout(function () {
                $('.yes-sure-active:visible').attr('data-id', id);
                if(semi_left == false){
                    $('.yes-sure-deactive:visible').attr('data-id', id);
                    $('.yes-sure-deactive:visible').attr('data-activity', 'left-employee');
                    $('.yes-sure-deactive:visible').enable();
                } else {
                    $('.yes-sure-deactive:visible').attr('data-id', '');
                    $('.yes-sure-deactive:visible').disable();
                }
            }, 500);
        });

        $('body').on('click', '.yes-sure-deactive', function () {
            var id = $(this).attr('data-id');
            var activity = $(this).attr('data-activity');
            var data = { 'id': id, 'activity': activity, _token: $('#_token').val() };
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

        $("body").on("click", ".working-employee", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-active:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-active', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'working-employee', _token: $('#_token').val() };
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
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html = '';

            html = '<table class="table table-bordered table-checkable" id="employee-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Name</th>' +
                '<th>Branch</th>'+
                '<th>Date of Joining</th>' +
                '<th>Experience</th>' +
                '<th>Googal pay</th>'+
                '<th>Status</th>';
                if (isAdmin == 'Y' || intersection.length > 0 ) {
                    html += '<th>Action</th>';
                }
                html += '</tr>' +
                '</thead>' +
                '<tbody>' +

                '</tbody>' +
                '</table>';

            $(".employee-list").html(html);


            var branch = $("#employee_branch").val();
            var technology = $("#technology_id").val();
            var designation = $("#designation_id").val();
            var status = $("#status_id").val();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            var dataArr = {
                'technology': technology, 'designation': designation,'status': status, 'startDate': startDate, 'endDate': endDate, 'branch': branch
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

        $("body").on('click','.add-branch-employee-import', function(){
            var data = {};
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'add-branch-employee-import', 'data': data },
                success: function (data) {
                   var Branch=  JSON.parse(data);
                   var html = '';
                   html += '<option value="">Please select Branch</option>';
                   for (var i = 0; i < Branch.length; i++) {
                       html += '<option value="'+ Branch[i].id +'">'+ Branch[i].branch_name +'</option>';
                   }
                   $(".branch").html(html);
                   $('.select2').select2();
                },


            });
        });

    }
    var trashList = function () {
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-trash-list',
            'ajaxURL': baseurl + "admin/employee/ajaxcall",
            'ajaxAction': 'get-employee-trash',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
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
                url:baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
    }
    var addEmployee = function () {

        var form = $('#add-employee-form');

        var rules = {
            hired_by: { required: true },
            cheque_status: { required: true },
        };

        var message = {
            hired_by: { required: "Please enter hired by" },
            cheque_status: { required: "Please select Cheque status" },
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
            branch: {
                validators: {
                    notEmpty: { message: 'Please select branch' },
                }
            },
            gmail: {
                validators: {
                    notEmpty: { message: 'Please enter company gmail' },
                    emailonly: {message: 'Please enter valid email'},
                }
            },
            // personal_email: {
            //     validators: {
            //         emailonly: {message: 'Please enter valid email'},
            //     }
            // },
            gmail_password: {
                validators: {
                    notEmpty: { message: 'Please enter gmail password' },
                }
            },
            status: {
                validators: {
                    myselect: { message: 'Please select status' },
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
            hired_by: {
                validators: {
                    notEmpty: { message: 'Please select manager' },
                }
            },
            // cheque_status: {
            //     validators: {
            //         notEmpty: { message: 'Please select Cheque status' },
            //     }
            // },

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
            designation: {
                validators: {
                    notEmpty: { message: 'Please select designation' },
                }
            },
            branch: {
                validators: {
                    notEmpty: { message: 'Please select branch' },
                }
            },
            gmail: {
                validators: {
                    notEmpty: { message: 'Please enter company gmail' },
                    emailonly: {message: 'Please enter valid email'},
                },
            },
            gmail_password: {
                validators: {
                    notEmpty: { message: 'Please enter gmail password' },
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
            hired_by: {
                validators: {
                    notEmpty: { message: 'Please enter hired by' },
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

        $('body').on('click', '.resetBtn', function () {
            var user_id = $(this).data('id');

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'clear_cheque_image', 'user_id': user_id },
                success: function (data) {
                    console.log(data);
                    if(data == 'true'){
                        $('.my-avatar').css('background-image', 'url(http://127.0.0.1:8000/upload/userprofile/default.jpg)');
                        $('.resetBtn').remove();
                        $('.arrow').remove();
                        $('.tooltip-inner').remove();
                        showToster("success", "Cheque Image Removed.");
                    } else {
                        showToster("warning", "Something went wrong.");
                    }
                }
            });

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
            var formattedMonth = new Date().getMonth() + 1;
            var month = formattedMonth < 10 ? '0' + formattedMonth : formattedMonth;
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

                    if (type == 'attendance') {
                        var html = '';
                        html = '<div id="attendance_calendar"></div>';

                        $(".attendance-list").html(html);

                        var res = JSON.parse(data);
                        var html = "";
                        var html = '<div class="row mt-5 ml-5">' +
                            '<div class="col-md-3">' +
                            '<div class="form-group">' +
                            '<label> Month</label>' +
                            '<select class="form-control select2 month change-fillter" id="EmpCalMonthId" name="month">' +
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
                            '<select class="form-control select2 year change-fillter" id="empCalYearId" name="year">' +
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
                            if (value.is_holiday !== null && value.is_holiday !== 'null' && typeof value.is_holiday !== 'undefined') {
                                // This is a holiday event
                                var temp2 = {
                                    title: 'Holiday ' + value.is_holiday,
                                    start: value.date,
                                    className: 'fc-event-danger'
                                };
                                eventArray.push(temp2);

                                // Add employee overtime event
                            if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined'  && value.emp_overtime != 0) {

                                var temp5 = {
                                    title: 'Emp Overtime ' +parseFloat(value.emp_overtime) ,
                                    start: value.date,
                                    className: 'fc-event-warning'
                                };
                                eventArray.push(temp5);
                            }
                            } else if (isWeekend(value.date) === true) {
                                // This is a weekend (Saturday or Sunday)
                                if(value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0){

                                var temp5 = {
                                    title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                    start: value.date,
                                    className: 'fc-event-warning'
                                };
                                eventArray.push(temp5);
                            }
                            } else {
                                // Regular attendance event
                                if(value.attendance_type !== null && value.attendance_type !== 'null' && typeof value.attendance_type !== 'undefined'){
                                    var temp = {
                                        title: value.attendance_type,
                                        start: value.date,
                                        description: value.description,
                                        className: value.class
                                    };
                                    eventArray.push(temp);
                                }

                                if(value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0){

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
                                window.location.href = baseurl +'admin/attendance/day/list?date=' + clickedDate; // Change 'another-page.html' to your desired page
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
                    } else if (type == 'asset-allocation') {

                        var userId = document.querySelector('.user-menu').getAttribute('data-user-id');

                        if ($.fn.DataTable.isDataTable('#employee-asset-allocation-list')) {
                            $('#employee-asset-allocation-list').DataTable().destroy();
                        }

                        $('.select2').select2();
                        var dataArr = {'userId': userId,};
                        var columnWidth = { "width": "5%", "targets": 0 };
                        var arrList = {
                            'tableID': '#employee-asset-allocation-list',
                            'ajaxURL': baseurl + "admin/employee/asset-allocation/ajaxcall",
                            'ajaxAction': 'getdatatable',
                            'postData': dataArr,
                            'hideColumnList': [],
                            'noSortingApply': [0],
                            'noSearchApply': [0],
                            'defaultSortColumn': [0],
                            'defaultSortOrder': 'DESC',
                            'setColumnWidth': columnWidth
                        };
                        getDataTable(arrList);
                    } else if (type == 'salary-increment') {

                        var userId = document.querySelector('.user-menu').getAttribute('data-user-id');

                        if ($.fn.DataTable.isDataTable('#employee-salary-increment-list')) {
                            $('#employee-salary-increment-list').DataTable().destroy();
                        }

                        $('.select2').select2();
                        var dataArr = {'userId': userId,};
                        var columnWidth = { "width": "5%", "targets": 0 };
                        var arrList = {
                            'tableID': '#employee-salary-increment-list',
                            'ajaxURL': baseurl + "admin/employee/salary-increment/ajaxcall",
                            'ajaxAction': 'getdatatable',
                            'postData': dataArr,
                            'hideColumnList': [],
                            'noSortingApply': [0],
                            'noSearchApply': [0],
                            'defaultSortColumn': [0],
                            'defaultSortOrder': 'DESC',
                            'setColumnWidth': columnWidth
                        };
                        getDataTable(arrList);
                    } else if (type == 'salary-slip') {

                        var userId = document.querySelector('.user-menu').getAttribute('data-user-id');

                        if ($.fn.DataTable.isDataTable('#admin-emp-salary-slip-list')) {
                            $('#admin-emp-salary-slip-list').DataTable().destroy();
                        }

                        $('.select2').select2();
                        var dataArr = {'userId': userId,};
                        var columnWidth = { "width": "5%", "targets": 0 };
                        var arrList = {
                            'tableID': '#admin-emp-salary-slip-list',
                            'ajaxURL': baseurl + "admin/employee/salary-slip/ajaxcall",
                            'ajaxAction': 'getdatatable',
                            'postData': dataArr,
                            'hideColumnList': [],
                            'noSortingApply': [0],
                            'noSearchApply': [0],
                            'defaultSortColumn': [0],
                            'defaultSortOrder': 'DESC',
                            'setColumnWidth': columnWidth
                        };
                        getDataTable(arrList);
                    }
                    else {
                        $(".employee-detail-view").html(data);
                    }

                    $('.user-menu-bar a.active').removeClass('active');
                    element.addClass('active');
                },
            });
            function isWeekend(date) {
                var day = new Date(date).getDay();
                return day === 0 || day === 6; // Sunday or Saturday
            }

            $("body").on("change", ".change-fillter", function(){

                var html = '';
                html = '<div id="attendance_calendar"></div>';

                $(".attendance-list").html(html);

                var month = $('#EmpCalMonthId').val().padStart(2, '0');
                var year = $("#empCalYearId").val();

                var data = { 'type': type, 'userId': userId, 'month': month, 'year': year }

                console.log(data);
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/employee/ajaxcall",
                    data: { 'action': 'get_employee_details', 'data': data },
                    success: function (data) {


                        if (type == 'attendance') {
                            var res = JSON.parse(data);

                            $('.select2').select2();
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
                                if (value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined'  && value.emp_overtime != 0) {

                                    var temp5 = {
                                        title: 'Emp Overtime ' +parseFloat(value.emp_overtime) ,
                                        start: value.date,
                                        className: 'fc-event-warning'
                                    };
                                    eventArray.push(temp5);
                                }
                                } else if (isWeekend(value.date) === true) {
                                    // This is a weekend (Saturday or Sunday)
                                    if(value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0){

                                    var temp5 = {
                                        title: 'Emp Overtime ' + parseFloat(value.emp_overtime),
                                        start: value.date,
                                        className: 'fc-event-warning'
                                    };
                                    eventArray.push(temp5);
                                }
                                } else {
                                    // Regular attendance event
                                    if(value.attendance_type !== null && value.attendance_type !== 'null' && typeof value.attendance_type !== 'undefined'){
                                        var temp = {
                                            title: value.attendance_type,
                                            start: value.date,
                                            description: value.description,
                                            className: value.class
                                        };
                                        eventArray.push(temp);
                                    }

                                    if(value.emp_overtime !== null && value.emp_overtime !== 'null' && typeof value.emp_overtime !== 'undefined' && value.emp_overtime != 0){

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
                                    window.location.href = baseurl +'admin/attendance/day/list?date=' + clickedDate; // Change 'another-page.html' to your desired page
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
        },
        trash_init:function(){
            trashList();
        }
    }
}();
