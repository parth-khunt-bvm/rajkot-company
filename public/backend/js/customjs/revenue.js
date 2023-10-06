var Revenue = function(){
    var list= function(){
        var manager = $('#manager_id').val();
        var technology = $("#technology_id").val();
        var receivedMonth = $("#received_month").val();
        var monthOf = $('#month_of').val();

        var dataArr = {'manager':manager, 'technology':technology, 'receivedMonth':receivedMonth, 'monthOf': monthOf};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-revenue-list',
            'ajaxURL': baseurl + "admin/revenue/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 9],
            'noSearchApply': [0, 9],
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
                url:baseurl + "admin/revenue/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        var importform = $('#import-revenue');
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


        $('body').on('change', '.change', function() {

            var html  = '';
            html = '<table class="table table-bordered table-checkable" id="admin-revenue-list">'+
            '<thead>' +
            '<tr>' +
            '<th>#</th>'+
            '<th>Manager Name</th>'+
            '<th>Technology Name</th>'+
            '<th>Date</th>'+
            '<th>Received Month  </th>'+
            '<th>Month_Of</th>'+
            '<th>Amount</th>'+
            '<th>Bank Name</th>'+
            '<th>Holder Name</th>'+
            '<th>Action</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>' +
            '</tbody>'+
            '</table>' ;

            $('.revenue-list').html(html);
            var manager = $('#manager_id').val();
            var technology = $("#technology_id").val();
            var receivedMonth = $("#received_month").val();
            var monthOf = $('#month_of').val();

            var dataArr = {'manager':manager, 'technology':technology, 'receivedMonth':receivedMonth, 'monthOf': monthOf};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-revenue-list',
                'ajaxURL': baseurl + "admin/revenue/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 9],
                'noSearchApply': [0, 9],
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
    var addRevenue= function(){
        $('.select2').select2();
        var form = $('#add-revenue-users');
        var rules = {
            manager_id: {required: true},
            technology_id: {required: true},
            date: {required: true},
            received_month: {required: true},
            month_of: {required: true},
            amount: {required: true},
            bank_name: {required: true},
            holder_name: {required: true},
        };
        var message = {
            manager_id :{
                required : "Please select manager name",
            },
            technology_id : {
                required : "Please select technology name"
            },
            date : {
                required : "Please enter date"
            },
            received_month : {
                required : "Please select received month"
            },
            month_of : {
                required : "Please select month"
            },
            amount : {
                required : "Please enter amount"
            },
            bank_name : {
                required : "Please enter bank name"
            },
            holder_name : {
                required : "Please enter holder name"
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

    var editRevenue= function(){
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('body').on('change', '.date', function(){
            var selecteddate = $(this).val();
            var html = '<option value="">Month of Revenue</option>';

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
        var form = $('#edit-revenue-users');
        var rules = {
            manager_id: {required: true},
            technology_id: {required: true},
            date: {required: true},
            received_month: {required: true},
            month_of: {required: true},
            amount: {required: true},
            bank_name: {required: true},
            holder_name: {required: true},
        };
        var message = {
            manager_id :{
                required : "Please select manager name",
            },
            technology_id : {
                required : "Please select technology name"
            },
            date : {
                required : "Please enter date"
            },
            received_month : {
                required : "Please select received month"
            },
            month_of : {
                required : "Please select month"
            },
            amount : {
                required : "Please enter amount"
            },
            bank_name : {
                required : "Please enter bank name"
            },
            holder_name : {
                required : "Please enter holder name"
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
            addRevenue();
        },
        edit:function(){
            editRevenue();
        },
    }
}();
