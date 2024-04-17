var HrExpense = function(){
    var list= function(){
        var month = $('#hr_month').val();
        var year = $('#hrExpenseYearId').val();
        var dataArr = {'month': month,'year': year};

        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#hr-expense-list',
            'ajaxURL': baseurl + "admin/hr/expense/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0],
            'defaultSortColumn': [0],
            'sumOfCol': [3],
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
                url:baseurl + "admin/hr/expense/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $('.select2').select2();
        $('body').on('change', '.change_month', function() {
            var target = [69,70,71];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html  = '';
            html ='<table class="table table-bordered table-checkable" id="hr-expense-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Month</th>'+
            '<th>Amount</th>'+
            '<th>Remark</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html +=  '</tr>'+
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

            var month = $('#hr_month').val();
            var year = $('#hrExpenseYearId').val();
            var dataArr = {'month': month,'year': year};

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#hr-expense-list',
                'ajaxURL': baseurl + "admin/hr/expense/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 5],
                'noSearchApply': [0],
                'defaultSortColumn': [0],
                'sumOfCol': [3],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);

            var data = {'month': month,'year': year, _token: $('#_token').val() };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/hr/expense/ajaxcall",
                data: { 'action': 'total-amount', 'data': data },
                success: function(data) {
                    var total_amount=  JSON.parse(data);
                    $("#total-amount").html(Number.parseFloat(total_amount).toFixed(2));
                }
            });
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
                $('.month_of').prop("disabled", true);
            }else{
                var months = { '1' : "January", '2' :"February", '3' : "March", '4' :"April", '5' : "May", '6' : "June", '7' : "July", '8' : "August", '9' : "September", '10' : "October", '11' : "November", '12' :"December"};
                var date = new Date(selecteddate);
                var month = date.getMonth();
                $('.month_of').prop("disabled", false);
                $.each(months, function( index, value ) {
                    if(month == index){
                        html = html + '<option value="'+ index +'" selected="selected">'+ value +'</option>';
                    }else{
                        html = html + '<option value="'+ index +'">'+ value +'</option>';
                    }
                });
            }
            $("#month_of").html(html);
        });

        $("body").on("click", ".show-hr-expense-form", function() {
            $("#show-hr-expense-form").html('-').addClass('remove-hr-expense-form');
            $("#show-hr-expense-form").html('-').removeClass('show-hr-expense-form');
            $("#add-hr-expense").slideToggle("slow");

        })

        $("body").on("click", ".remove-hr-expense-form", function() {
            $("#show-hr-expense-form").html('+').removeClass('remove-hr-expense-form');
            $("#show-hr-expense-form").html('+').addClass('show-hr-expense-form');
            $("#add-hr-expense").slideToggle("slow");

        })

        $("body").on("click", "#show-hr-expense-filter", function() {
            $("div .hr-expense-filter").slideToggle("slow");
        })

        var importform = $('#import-hr-expense');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
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
            $("#monthId").html(html);
        });

    }


    var trashHrExpense= function(){

        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#hr-expense-trash-list',
            'ajaxURL': baseurl + "admin/hr/expense/ajaxcall",
            'ajaxAction': 'get-hr-expense-trash',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0],
            'defaultSortColumn': [0],
            'sumOfCol': [3],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);


        $("body").on("click", ".restore-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var data = { id: id, 'activity': 'restore-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/hr/expense/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

    }


    var addHrExpense= function(){
        $('.select2').select2();
        var form = $('#add-hr-expense');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            date: {required: true},
            month: {required: true},
            amount: {
                required: true,
                validateMaxValue: true,
            },
        };
        var message = {
            date : {
                required : "Please enter date"
            },
            month : {
                required : "Please select month"
            },
            amount : {
                required : "Please enter amount",
            },

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
            $("#monthId").html(html);
        });

    }
    var editHrExpense = function(){
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('.select2').select2();
        var form = $('#edit-hr-expense');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            date: {required: true},
            month: {required: true},
            amount: {
                required: true,
                validateMaxValue: true,
            },
        };
        var message = {
            date : {
                required : "Please enter date"
            },
            month : {
                required : "Please select month"
            },
            amount : {
                required : "Please enter amount"
            },

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
            addHrExpense();
        },
        edit:function(){
            editHrExpense();
        },
        trash_init:function(){
            trashHrExpense();
        },
    }
}();
