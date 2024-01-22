var LeaveRequest = function(){

    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#leave-request-list',
            'ajaxURL': baseurl + "employee/admin/leave-request/ajaxcall",
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
                url: baseurl + "admin/branch/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        var importform = $('#import-branch');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
        });

        $("body").on("click", ".show-branch-form", function() {
            $("#show-branch-form").html('-').addClass('remove-branch-form');
            $("#show-branch-form").html('-').removeClass('show-branch-form');
            $("#add-branch").slideToggle("slow");
        })

        $("body").on("click", ".remove-branch-form", function() {
            $("#show-branch-form").html('+').removeClass('remove-branch-form');
            $("#show-branch-form").html('+').addClass('show-branch-form');
            $("#add-branch").slideToggle("slow");
        })

    }

    var addLeaveRequest = function(){
        var form = $('#add-leave-request');
        var rules = {
            date : {required: true},
            manager : {required: true},
            leave_type : {required: true}

        };

        var message = {
            date : {required: "Please select date"},
            manager : {required: "Please select manager"},
            leave_type : {required: "Please select leave type"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
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
            orientation: "bottom auto",
            startDate: new Date()
        });

    }


    var editLeaveRequest = function(){
        var form = $('#edit-leave-request');
        var rules = {
            date : {required: true},
            manager : {required: true},
            leave_type : {required: true}

        };

        var message = {
            date : {required: "Please select date"},
            manager : {required: "Please select manager"},
            leave_type : {required: "Please select leave type"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
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
            orientation: "bottom auto",
            startDate: new Date()
        });

    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addLeaveRequest();
        },
        edit:function(){
            editLeaveRequest();
        },
    }
}();
