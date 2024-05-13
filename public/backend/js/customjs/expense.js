var Expense = function(){
    var list= function(){

        var manager = $('#manager_id').val();
        var branch = $("#branch_id").val();
        var type = $("#type_id").val();
        var month = $('#expenseFillMonthId').val();
        var year = $('#expenseFillYearId').val();

        var dataArr = {'manager' :manager ,'branch':branch, 'type':type, 'month': month,'year': year};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-expense-list',
            'ajaxURL': baseurl + "admin/expense/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'sumOfCol': [6],
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
                url:baseurl + "admin/expense/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $('.select2').select2();

        var importform = $('#import-expense');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
        });

        $('body').on('change', '.change', function() {

            var target = [51,52,53];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html = '';
            html =   '<table class="table table-bordered table-checkable" id="admin-expense-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Manager Name</th>'+
            '<th>Branch Name</th>'+
            '<th>Type Name</th>'+
            '<th>Month</th>'+
            '<th>Amount</th>'+
            '<th>Remark</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html +='</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '<tfoot>'+
            '<tr>'+
            '<th colspan="3">Total:</th>'+
            '<th></th>'+
            '<th></th>';
                if (isAdmin == 'Y' || intersection.length > 0 ) {
                    html += "<th></th>"
                }
            html += '</tr>'+
            '</tfoot>'+
            '</table>';

            $('.expense-list').html(html);

            var manager = $('#manager_id').val();
            var branch = $("#branch_id").val();
            var type = $("#type_id").val();
            var month = $('#expenseFillMonthId').val();
            var year = $('#expenseFillYearId').val();

           var dataArr = {'manager' :manager ,'branch':branch, 'type':type, 'month': month,'year': year};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-expense-list',
                'ajaxURL': baseurl + "admin/expense/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 0],
                'noSearchApply': [0, 0],
                'defaultSortColumn': [4],
                'defaultSortOrder': 'DESC',
                'sumOfCol': [6],
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);

        });

        $("body").on("click", ".reset", function(){
            location.reload(true);
        });


        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('body').on('change', '.date', function(){
            var selecteddate = $(this).val();
            var html = '<option value="">Month of salary</option>';

            if(selecteddate == '' || selecteddate == null){
                $('.month').prop("disabled", true);
            }else{
                var months = { '1' : "January", '2' :"February", '3' : "March", '4' :"April", '5' : "May", '6' : "June", '7' : "July", '8' : "August", '9' : "September", '10' : "October", '11' : "November", '12' :"December"};
                var date = new Date(selecteddate);
                var month = date.getMonth();
                $('.month').prop("disabled", false);
                $.each(months, function( index, value ) {
                    if(month == index){
                        html = html + '<option value="'+ index +'" selected="selected">'+ value +'</option>';
                    }else{
                        html = html + '<option value="'+ index +'">'+ value +'</option>';
                    }
                });
            }
            $("#month").html(html);
        });

        $("body").on("click", ".show-expense-form", function() {
            $("#show-expense-form").html('-').addClass('remove-expense-form');
            $("#show-expense-form").html('-').removeClass('show-expense-form');
            $("#add-expense-users").slideToggle("slow");

        })

        $("body").on("click", ".remove-expense-form", function() {
            $("#show-expense-form").html('+').removeClass('remove-expense-form');
            $("#show-expense-form").html('+').addClass('show-expense-form');
            $("#add-expense-users").slideToggle("slow");

        })

        $("body").on("click", "#show-expense-filter", function() {
            $("div .expense-filter").slideToggle("slow");
        })
    }

    var trashList= function(){

        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-expense-trash-list',
            'ajaxURL': baseurl + "admin/expense/ajaxcall",
            'ajaxAction': 'get-expense-trash',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'sumOfCol': [6],
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
                url:baseurl + "admin/expense/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
    }

    var addExpense= function(){
        $('.select2').select2();
        var form = $('#add-expense-users');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            manager_id: {required: true},
            branch_id: {required: true},
            type_id: {required: true},
            date: {required: true},
            month: {required: true},
            year: {required: true},
            amount: {
                required: true,
                validateMaxValue: true,
            },
        };
        var message = {
            manager_id :{
                required : "Please select manager name",
            },
            branch_id : {
                required : "Please select branch name"
            },
            type_id : {
                required : "Please select type name"
            },
            date : {
                required : "Please enter date"
            },
            month : {
                required : "Please select month"
            },
            year : {
                required : "Please select year"
            },
            amount : {
                required : "Please enter amount"
            }
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('body').on('change', '.date', function(){
            var selecteddate = $(this).val();
            var html = '<option value="">Month of salary</option>';

            if(selecteddate == '' || selecteddate == null){
                $('.month').prop("disabled", true);
            }else{
                var months = { '1' : "January", '2' :"February", '3' : "March", '4' :"April", '5' : "May", '6' : "June", '7' : "July", '8' : "August", '9' : "September", '10' : "October", '11' : "November", '12' :"December"};
                var date = new Date(selecteddate);
                var month = date.getMonth();
                $('.month').prop("disabled", false);
                $.each(months, function( index, value ) {
                    if(month == index){
                        html = html + '<option value="'+ index +'" selected="selected">'+ value +'</option>';
                    }else{
                        html = html + '<option value="'+ index +'">'+ value +'</option>';
                    }
                });
            }
            $("#expenseMonthId").html(html);
        });
    }

    var editExpense= function(){
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('body').on('change', '.date', function(){
            var selecteddate = $(this).val();
            var html = '<option value="">Month of salary</option>';

            if(selecteddate == '' || selecteddate == null){
                $('.month').prop("disabled", true);
            }else{
                var months = { '1' : "January", '2' :"February", '3' : "March", '4' :"April", '5' : "May", '6' : "June", '7' : "July", '8' : "August", '9' : "September", '10' : "October", '11' : "November", '12' :"December"};
                var date = new Date(selecteddate);
                var month = date.getMonth();
                $('.month').prop("disabled", false);
                $.each(months, function( index, value ) {
                    if(month == index){
                        html = html + '<option value="'+ index +'" selected="selected">'+ value +'</option>';
                    }else{
                        html = html + '<option value="'+ index +'">'+ value +'</option>';
                    }
                });
            }
            $("#expenseMonthId").html(html);
        });

        $('.select2').select2();
        var form = $('#edit-expense-users');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            manager_id: {required: true},
            branch_id: {required: true},
            type_id: {required: true},
            date: {required: true},
            month: {required: true},
            year: {required: true},
            amount: {
                required: true,
                validateMaxValue: true,
            },
        };
        var message = {
            manager_id :{
                required : "Please select manager name",
            },
            branch_id : {
                required : "Please select branch name"
            },
            type_id : {
                required : "Please select type name"
            },
            date : {
                required : "Please enter date"
            },
            month : {
                required : "Please enter month"
            },
            year : {
                required : "Please select year"
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
            addExpense();
        },
        edit:function(){
            editExpense();
        },
        trash_init:function(){
            trashList();
        }
    }
}();
