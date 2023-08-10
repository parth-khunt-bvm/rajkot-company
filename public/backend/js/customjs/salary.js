var Salary = function(){
    var list= function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-salary-list',
            'ajaxURL': baseurl + "admin/salary/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 6],
            'noSearchApply': [0, 6],
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
            var data = { id: id, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/salary/ajaxcall",
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
            var data = { id: id, 'activity': 'deactive-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/salary/ajaxcall",
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

            var data = { id: id, 'activity': 'active-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/salary/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
    }
    var addSalary= function(){
        $('.select2').select2();
        var form = $('#add-salary');
        var rules = {
            manager_name: {required: true},
            branch_name: {required: true},
            technology_name: {required: true},
            date: {required: true},
            month_of: {required: true},
            remarks: {required: true},
            amount: {required: true},
        };
        var message = {
            manager_name :{
                required : "Please select manager name",
            },
            branch_name : {
                required : "Please select branch name"
            },
            technology_name : {
                required : "Please select technology name"
            },
            date : {
                required : "Please enter date"
            },
            month_of : {
                required : "Please enter month"
            },
            remarks : {
                required : "Please enter remarks"
            },
            amount : {
                required : "Please enter amount"
            }
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    var editSalary= function(){
        $('.select2').select2();
        var form = $('#edit-salary-users');
        var rules = {
            manager_name: {required: true},
            branch_name: {required: true},
            technology_name: {required: true},
            date: {required: true},
            month_of: {required: true},
            remarks: {required: true},
            amount: {required: true},
        };
        var message = {
            manager_name :{
                required : "Please select manager name",
            },
            branch_name : {
                required : "Please select branch name"
            },
            technology_name : {
                required : "Please select technology name"
            },
            date : {
                required : "Please enter date"
            },
            month_of : {
                required : "Please enter month"
            },
            remarks : {
                required : "Please enter remarks"
            },
            amount : {
                required : "Please enter amount"
            }
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    return {
        init:function(){
            list();
        },
        add:function(){
            addSalary();
        },
        edit:function(){
            editSalary();
        },
    }
}();
