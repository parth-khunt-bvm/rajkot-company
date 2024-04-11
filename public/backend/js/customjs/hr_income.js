var HrIncome = function(){
    var list= function(){
        var manager = $('#hr_manager_id').val();
        var monthOf = $('#hr_month_of').val();
        var year = $('#hrIncomeFillYearId').val();
        var dataArr = {'manager':manager, 'monthOf': monthOf, 'year': year};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#hr-income-list',
            'ajaxURL': baseurl + "admin/hr/income/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 7],
            'noSearchApply': [0],
            'defaultSortColumn': [0],
            'sumOfCol': [5],
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
                url:baseurl + "admin/hr/income/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $('.select2').select2();

        $('body').on('change', '.change', function() {
            var target = [63,64,65];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html  = '';
            html = '<table class="table table-bordered table-checkable" id="hr-income-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Manager Name</th>'+
            '<th>Payment Mode</th>'+
            '<th>Salary Month</th>'+
            '<th>Amount</th>'+
            '<th>Remark</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html += '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '<tfoot>'+
            '<tr>'+
            '<th colspan="5">Total:</th>'+
            '<th></th>'+
            '<th></th>';
                if (isAdmin == 'Y' || intersection.length > 0 ) {
                    html += "<th></th>"
                }
            html += '</tr>'+
            '</tfoot>'+
            '</table>';

            $('.income-list').html(html);

            var manager = $('#hr_manager_id').val();
            var monthOf = $('#hr_month_of').val();
            var year = $('#hrIncomeFillYearId').val();
            var dataArr = {'manager':manager, 'monthOf': monthOf, 'year': year};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#hr-income-list',
                'ajaxURL': baseurl + "admin/hr/income/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 0],
                'noSearchApply': [0, 0],
                'defaultSortColumn': [0],
                'sumOfCol': [5],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };

            getDataTable(arrList);
            var data = {'manager':manager, 'monthOf': monthOf, 'year': year , _token: $('#_token').val() };

            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/hr/income/ajaxcall",
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
            var html = '<option value="">Month of</option>';

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

        $("body").on("click", ".show-hr-income-form", function() {
            $("#show-hr-income-form").html('-').addClass('remove-hr-income-form');
            $("#show-hr-income-form").html('-').removeClass('show-hr-income-form');
            $("#add-hr-income").slideToggle("slow");

        })

        $("body").on("click", ".remove-hr-income-form", function() {
            $("#show-hr-income-form").html('+').removeClass('remove-hr-income-form');
            $("#show-hr-income-form").html('+').addClass('show-hr-income-form');
            $("#add-hr-income").slideToggle("slow");

        })

        $("body").on("click", "#show-hr-income-filter", function() {
            $("div .hr-income-filter").slideToggle("slow");
        })

        var importform = $('#import-hr-income');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
        });

    }
    var addHrIncome= function(){
        $('.select2').select2();
        var form = $('#add-hr-income');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            manager_id: {required: true},
            payment_mode: {required: true},
            date: {required: true},
            month_of: {required: true},
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
            payment_mode : {
                required : "Please select Payment Mode"
            },
            date : {
                required : "Please enter date"
            },
            month_of : {
                required : "Please select month"
            },
            year : {
                required : "Please select year"
            },
            amount : {
                required : "Please enter amount"
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
            var html = '<option value="">Month of</option>';

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
    }

    var editHrIncome= function(){
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('body').on('change', '.date', function(){
            console.log("hii");
            var selecteddate = $(this).val();
            var html = '<option value="">Month of</option>';

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

        $('.select2').select2();
        var form = $('#edit-hr-income');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            manager_id: {required: true},
            payment_mode: {required: true},
            date: {required: true},
            month_of: {required: true},
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
            payment_mode : {
                required : "Please select Payment Mode"
            },
            date : {
                required : "Please enter date"
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
            addHrIncome();
        },
        edit:function(){
            editHrIncome();
        },
    }
}();
