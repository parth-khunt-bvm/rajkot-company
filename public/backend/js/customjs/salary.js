var Salary = function(){
    var list= function(){
        var manager = $('#manager_id').val();
        var branch = $("#branch_id").val();
        var technology = $("#technology_id").val();
        var monthOf = $('#salary_month_of').val();
        var year = $('#yearId').val();

        var dataArr = { 'manager': manager, 'branch':branch, 'technology':technology, 'monthOf':monthOf ,'year':year};
        var columnWidth = [{"width": "5%", "targets": 0 }, {"width": "30%", "targets": 6 }];
        var arrList = {
            'tableID': '#admin-salary-list',
            'ajaxURL': baseurl + "admin/salary/ajaxcall",
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

        $('.select2').select2();
        var importform = $('#import-salary');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
        });

        $("body").on("change", ".change", function() {
            var target = [45,46,47];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html ='<table class="table table-bordered table-checkable" id="admin-salary-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Manager Name</th>'+
            '<th>Branch Name</th>'+
            '<th>Technology Name</th>'+
            '<th>Month_Of</th>'+
            '<th>Amount</th>'+
            '<th>Rmark</th>';
            if (isAdmin == 'Y' || intersectCount > 0 ) {
                html += '<th>Action</th>';
            }
            html +='</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';
            $(".salary-list").html(html);

            var manager = $('#manager_id').val();
            var branch = $("#branch_id").val();
            var technology = $("#technology_id").val();
            var monthOf = $('#salary_month_of').val();
            var year = $('#yearId').val();

            var dataArr = { 'manager': manager, 'branch':branch, 'technology':technology, 'monthOf':monthOf ,'year':year};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-salary-list',
                'ajaxURL': baseurl + "admin/salary/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 0],
                'noSearchApply': [0, 0],
                'defaultSortColumn': [4],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);
        })

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


        $("body").on("click", ".show-salary-form", function() {
            $("#show-salary-form").html('-').addClass('remove-salary-form');
            $("#show-salary-form").html('-').removeClass('show-salary-form');
            $("#add-salary-users").slideToggle("slow");

        })

        $("body").on("click", ".remove-salary-form", function() {
            $("#show-salary-form").html('+').removeClass('remove-salary-form');
            $("#show-salary-form").html('+').addClass('show-salary-form');
            $("#add-salary-users").slideToggle("slow");

        })

        $("body").on("click", "#show-salary-filter", function() {
            $("div .salary-filter").slideToggle("slow");
        })
    }
    var addSalary= function(){
        $('.select2').select2();
        var form = $('#add-salary-users');
        var rules = {
            manager_id: {required: true},
            branch_id: {required: true},
            technology_id: {required: true},
            date: {required: true},
            month_of: {required: true},
            year: {required: true},
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
            month_of : {
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

    var editSalary= function(){
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

        $('.select2').select2();
        var form = $('#edit-salary-users');
        var rules = {
            manager_id: {required: true},
            branch_id: {required: true},
            technology_id: {required: true},
            date: {required: true},
            month_of: {required: true},
            year: {required: true},
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
            month_of : {
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
