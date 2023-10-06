var Employee = function(){
    var list = function(){
        var technology = $("#technology_id").val();
        var startDate = $("#start_date").val();
        var endDate = $("#end_date").val();
        var dataArr = {'technology': technology,'startDate': startDate,'endDate': endDate
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
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".deactive-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure-deactive:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-deactive', function() {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'deactive-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".active-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure-active:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-active', function() {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'active-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
        var importform = $('#import-employee');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
        });
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $('body').on('change', '.change-fillter', function() {
            var html = '';

            html = '<table class="table table-bordered table-checkable" id="employee-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Name</th>'+
            '<th>Department</th>'+
            '<th>Date of Joining</th>'+
            '<th>Gmail</th>'+
            '<th>Emergency Contact</th>'+
            '<th>G Pay Number</th>'+
            '<th>Experience</th>'+
            '<th>Status</th>'+
            '<th>Action</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+

            '</tbody>'+
            '</table>';

            $(".employee-list").html(html);


            var technology = $("#technology_id").val();
            var startDate = $("#start_date").val();
            var endDate = $("#end_date").val();
            var dataArr = {'technology': technology,'startDate': startDate,'endDate': endDate
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

    }
       var addEmployee = function(){
        $('.select2').select2();
        var form = $('#kt_form');
        var rules = {
            first_name : {required: true},
            last_name : {required: true},
            technology : {required: true},
            dob : {required: true},
            doj : {required: true},
            bank_name : {required: true},
            acc_holder_name : {required: true},
            account_number : {required: true},
            ifsc_code : {required: true},
            aadhar_card_number : {required: true},
            parent_name : {required: true},
            address : {required: true},
            experience  : {required: true},
            hired_by : {required: true},
            salary : {required: true},
            status : {required: true}
        };

        var message = {
            first_name : {required: "Please enter first name"},
            last_name : {required: "Please enter last name"},
            technology : {required: "Please select technology"},
            dob : {required: "Please enter date of birth"},
            doj : {required: "Please enter date of joining"},
            bank_name : {required: "Please enter bank name"},
            acc_holder_name : {required: "Please enter account holder name"},
            account_number : {required: "Please enter account number"},
            ifsc_code : {required: "Please enter ifsc code"},
            aadhar_card_number : {required: "Please enter aadhar card number"},
            parent_name : {required: "Please enter parent name"},
            address : {required: "Please enter address"},
            experience  : {required: "Please enter experience"},
            hired_by : {required: "Please enter hired by"},
            salary : {required: "Please enter salary"},
            status : {required: "Please select status"}
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

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
    var editEmployee = function(){
        $('.select2').select2();
        var form = $('#kt_form');
        var rules = {
            first_name : {required: true},
            last_name : {required: true},
            technology : {required: true},
            dob : {required: true},
            doj : {required: true},
            bank_name : {required: true},
            acc_holder_name : {required: true},
            account_number : {required: true},
            ifsc_code : {required: true},
            aadhar_card_number : {required: true},
            parent_name : {required: true},
            address : {required: true},
            experience  : {required: true},
            hired_by : {required: true},
            salary : {required: true},
            status : {required: true}
        };

        var message = {
            first_name : {required: "Please enter first name"},
            last_name : {required: "Please enter last name"},
            technology : {required: "Please select technology"},
            dob : {required: "Please enter date of birth"},
            doj : {required: "Please enter date of joining"},
            bank_name : {required: "Please enter bank name"},
            acc_holder_name : {required: "Please enter account holder name"},
            account_number : {required: "Please enter account number"},
            ifsc_code : {required: "Please enter ifsc code"},
            aadhar_card_number : {required: "Please enter aadhar card number"},
            parent_name : {required: "Please enter parent name"},
            address : {required: "Please enter address"},
            experience  : {required: "Please enter experience"},
            hired_by : {required: "Please enter hired by"},
            salary : {required: "Please enter salary"},
            status : {required: "Please select status"}
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

    }
    return {
        init:function(){
            list();
        },
        add:function(){
            addEmployee();
        },
        edit:function(){
            editEmployee();
        },
    }
}();
