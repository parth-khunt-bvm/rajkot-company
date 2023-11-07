var Employee = function () {
    var list = function () {
        var technology = $("#technology_id").val();
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();
        var dataArr = {
            'technology': technology, 'startDate': startDate, 'endDate': endDate
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
            var html = '';

            html = '<table class="table table-bordered table-checkable" id="employee-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Name</th>' +
                '<th>Department</th>' +
                '<th>Date of Joining</th>' +
                '<th>Gmail</th>' +
                '<th>Emergency Contact</th>' +
                '<th>G Pay Number</th>' +
                '<th>Experience</th>' +
                '<th>Status</th>' +
                '<th>Action</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +

                '</tbody>' +
                '</table>';

            $(".employee-list").html(html);


            var technology = $("#technology_id").val();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            var dataArr = {
                'technology': technology, 'startDate': startDate, 'endDate': endDate
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

        });

        $("body").on("click", "#show-employee-filter", function() {
            console.log("hII");
            $("div .employee-filter").slideToggle("slow");
        })

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
            first_name : {
                validators: {
                    notEmpty: { message: 'Please enter first name'},
                    textonly: { message: 'Please enter valid first name'}
                }
            },
            last_name : {
                validators: {
                    notEmpty: { message: 'Please enter last name'},
                    textonly: { message: 'Please enter valid last name'}
                }
            },
            technology : {
                validators: {
                    notEmpty: { message: 'Please select technology'},
                }
            },
            dob : {
                validators: {
                    notEmpty: { message: 'Please enter date of birth'},
                }
            },
            doj : {
                validators: {
                    notEmpty: { message: 'Please enter date of joining'},
                }
            },
            personal_email : {
                validators: {
                    notEmpty: { message: 'Please enter personal email'},
                    emailonly: { message: 'Please enter a valid email'},
                }
            },
            bank_name : {
                validators: {
                    notEmpty: { message: 'Please enter bank name'},
                    textonly: { message: 'Please enter valid bank name'}
                }
            },
            acc_holder_name : {
                validators: {
                    notEmpty: { message: 'Please enter account holder name'},
                    textonly: { message: 'Please enter valid account holder name'}
                }
            },
            account_number : {
                validators: {
                    notEmpty: { message: 'Please enter account number'},
                    // numberonly: { message: 'Please enter a valid account number'},
                }
            },
            ifsc_code : {
                validators: {
                    notEmpty: { message: 'Please enter ifsc code'},
                }
            },
            aadhar_card_number : {
                validators: {
                    notEmpty: { message: 'Please enter aadhar card number'},
                    numberonly: { message: 'Please enter a valid account number'},
                }
            },
            google_pay : {
                validators: {
                    notEmpty: { message: 'Please enter g-pay number'},
                    numberonly: { message: 'Please enter a valid g-pay number'},
                }
            },
            parent_name : {
                validators: {
                    notEmpty: { message: 'Please enter parent name'},
                    textonly: { message: 'Please enter valid parent name'}
                }
            },
            address : {
                validators: {
                    notEmpty: { message: 'Please enter address'},
                }
            },
             experience : {
                validators: {
                    notEmpty: { message: 'Please enter experience'},
                }
            },
            hired_by : {
                validators: {
                    notEmpty: { message: 'Please enter hired by'},
                }
            },
            salary : {
                validators: {
                    notEmpty: { message: 'Please enter salary'},
                }
            },
            status : {
                validators: {
                    notEmpty: { message: 'Please select status'},
                }
            }

        };

        function checkValidation(validationType , message, value){

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

        $("body").on("click", ".prev-step", function(){
            var prevPageNo  = $(this).data('prev-page');
            var currentPageNo  = $(this).data('current-page');

            $("#step"+currentPageNo).css('display', 'none');
            $("#step"+prevPageNo).css('display', 'block');
        });

        $("body").on("click", ".next-step", function () {
            var nextPageNo  = $(this).data('next-page');
            var currentPageNo  = $(this).data('current-page');
            var customValid = true;
            $('.input-name').each(function () {
                if ($(this).is(':visible')) {
                    var element = $(this);
                    var inputName = element.attr('name');
                    var errorElement = element.parent().find('.type_error');
                    errorElement.text('');
                    var checkValidInput = true;
                    if(validation[inputName]){
                        $.each(validation[inputName]['validators'], function( index, value ) {
                            if(checkValidInput){
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

            if(customValid){
                $("#step"+nextPageNo).css('display', 'block');
                $("#step"+currentPageNo).css('display', 'none');
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
            first_name : {
                validators: {
                    notEmpty: { message: 'Please enter first name'},
                    textonly: { message: 'Please enter valid first name'}
                }
            },
            last_name : {
                validators: {
                    notEmpty: { message: 'Please enter last name'},
                    textonly: { message: 'Please enter valid last name'}
                }
            },
            technology : {
                validators: {
                    notEmpty: { message: 'Please select technology'},
                }
            },
            dob : {
                validators: {
                    notEmpty: { message: 'Please enter date of birth'},
                }
            },
            doj : {
                validators: {
                    notEmpty: { message: 'Please enter date of joining'},
                }
            },
            personal_email : {
                validators: {
                    notEmpty: { message: 'Please enter personal email'},
                    emailonly: { message: 'Please enter a valid email'},
                }
            },
            bank_name : {
                validators: {
                    notEmpty: { message: 'Please enter bank name'},
                    textonly: { message: 'Please enter valid bank name'}
                }
            },
            acc_holder_name : {
                validators: {
                    notEmpty: { message: 'Please enter account holder name'},
                    textonly: { message: 'Please enter valid account holder name'}
                }
            },
            account_number : {
                validators: {
                    notEmpty: { message: 'Please enter account number'},
                    // numberonly: { message: 'Please enter a valid account number'},
                }
            },
            ifsc_code : {
                validators: {
                    notEmpty: { message: 'Please enter ifsc code'},
                }
            },
            aadhar_card_number : {
                validators: {
                    notEmpty: { message: 'Please enter aadhar card number'},
                    numberonly: { message: 'Please enter a valid account number'},
                }
            },
            google_pay : {
                validators: {
                    notEmpty: { message: 'Please enter g-pay number'},
                    numberonly: { message: 'Please enter a valid g-pay number'},
                }
            },
            parent_name : {
                validators: {
                    notEmpty: { message: 'Please enter parent name'},
                    textonly: { message: 'Please enter valid parent name'}
                }
            },
            address : {
                validators: {
                    notEmpty: { message: 'Please enter address'},
                }
            },
             experience : {
                validators: {
                    notEmpty: { message: 'Please enter experience'},
                }
            },
            hired_by : {
                validators: {
                    notEmpty: { message: 'Please enter hired by'},
                }
            },
            salary : {
                validators: {
                    notEmpty: { message: 'Please enter salary'},
                }
            },
            status : {
                validators: {
                    notEmpty: { message: 'Please select status'},
                }
            }

        };

        function checkValidation(validationType , message, value){

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

        $("body").on("click", ".prev-step", function(){
            var prevPageNo  = $(this).data('prev-page');
            var currentPageNo  = $(this).data('current-page');

            $("#step"+currentPageNo).css('display', 'none');
            $("#step"+prevPageNo).css('display', 'block');
        });

        $("body").on("click", ".next-step", function () {
            var nextPageNo  = $(this).data('next-page');
            var currentPageNo  = $(this).data('current-page');
            var customValid = true;
            $('.input-name').each(function () {
                if ($(this).is(':visible')) {
                    var element = $(this);
                    var inputName = element.attr('name');
                    var errorElement = element.parent().find('.type_error');
                    errorElement.text('');
                    var checkValidInput = true;
                    if(validation[inputName]){
                        $.each(validation[inputName]['validators'], function( index, value ) {
                            if(checkValidInput){
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

            if(customValid){
                $("#step"+nextPageNo).css('display', 'block');
                $("#step"+currentPageNo).css('display', 'none');
            }

        });



        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

    }

    // var nextStep = function (step) {
    //     let currentStep = 1;
    //     if (step === currentStep) {
    //         return;
    //     }

    //     const currentStepElement = document.getElementById(`step${currentStep}`);
    //     const nextStepElement = document.getElementById(`step${step}`);

    //     if (currentStepElement && nextStepElement) {
    //         currentStepElement.style.display = "none";
    //         nextStepElement.style.display = "block";
    //         currentStep = step;
    //     }

    // }

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
    }
}();
