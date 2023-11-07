var Expense = function(){
    var list= function(){

        var manager = $('#manager_id').val();
        var branch = $("#branch_id").val();
        var type = $("#type_id").val();
        var month = $('#month').val();

        var dataArr = {'manager' :manager ,'branch':branch, 'type':type, 'month': month};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-expense-list',
            'ajaxURL': baseurl + "admin/expense/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 7],
            'noSearchApply': [0, 7],
            'defaultSortColumn': [4],
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

            var html = '';
            html = '<table class="table table-bordered table-checkable" id="admin-expense-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Manager Name</th>'+
            '<th>Branch Name</th>'+
            '<th>Type Name</th>'+
            '<th>Date</th>'+
            '<th>Month</th>'+
            '<th>Amount</th>'+
            '<th>Action</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $('.expense-list').html(html);

            var manager = $('#manager_id').val();
            var branch = $("#branch_id").val();
            var type = $("#type_id").val();
            var month = $('#month').val();

            var dataArr = {'manager' :manager ,'branch':branch, 'type':type, 'month': month};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-expense-list',
                'ajaxURL': baseurl + "admin/expense/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 7],
                'noSearchApply': [0, 7],
                'defaultSortColumn': [4],
                'defaultSortOrder': 'DESC',
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
            console.log("hII");
            $("div .expense-filter").slideToggle("slow");
        })
    }
    var addExpense= function(){
        $('.select2').select2();
        var form = $('#add-expense-users');
        var rules = {
            manager_id: {required: true},
            branch_id: {required: true},
            type_id: {required: true},
            date: {required: true},
            month: {required: true},
            amount: {required: true},
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
            $("#month").html(html);
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
            $("#month").html(html);
        });

        $('.select2').select2();
        var form = $('#edit-expense-users');
        var rules = {
            manager_id: {required: true},
            branch_id: {required: true},
            technology_id: {required: true},
            date: {required: true},
            month: {required: true},
            amount: {required: true},
        };
        var message = {
            manager_id :{
                required : "Please select manager name",
            },
            branch_id : {
                required : "Please select branch name"
            },
            technology_id : {
                required : "Please select technology name"
            },
            date : {
                required : "Please enter date"
            },
            month : {
                required : "Please enter month"
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
    }
}();
