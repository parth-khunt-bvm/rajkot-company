var SalaryIncrement = function(){
    var list = function(){
        var employee = $('#salary_incr_employee_id').val();
        var startDate = $('#salary_incr_start_date_id').val();
        var endDate = $('#salary_incr_end_date_id').val();
        var dataArr = { 'employee': employee,'startDate': startDate, 'endDate': endDate };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-salary-increment-list',
            'ajaxURL': baseurl + "admin/salary-increment/ajaxcall",
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
                url: baseurl + "admin/salary-increment/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", "#show-salary-increment-filter", function() {
            $("div .salary-increment-filter").slideToggle("slow");
        })


        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $("body").on("click", ".reset", function () {
            location.reload(true);
        });

        $("body").on("change", ".salary-incr-fill", function () {
            var target = [151, 152, 153, 154];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html = '';
            html =     '<table class="table table-bordered table-checkable" id="admin-salary-increment-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Employee Name</th>'+
            '<th>Previous Salary</th>'+
            '<th>Current Salary</th>'+
            '<th>Start From</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html +=  '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';
            $(".salary-increment-list-div").html(html);

                var employee = $('#salary_incr_employee_id').val();
                var startDate = $('#salary_incr_start_date_id').val();
                var endDate = $('#salary_incr_end_date_id').val();
                var dataArr = { 'employee': employee,'startDate': startDate, 'endDate': endDate };
                var columnWidth = { "width": "5%", "targets": 0 };
                var arrList = {
                    'tableID': '#admin-salary-increment-list',
                    'ajaxURL': baseurl + "admin/salary-increment/ajaxcall",
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

        })

    }

    var addSalaryIncrement = function(){
        var form = $('#add-salary-increment');
        var rules = {
            employee_id : {required: true},
            previous_salary : {required: true},
            current_salary : {required: true},
            start_from : {required: true}
        };

        var message = {
            employee_id : {required: "Please select employee"},
            previous_salary : {required: "Please enter previous salary"},
            current_salary : {required: "Please enter current salary"},
            start_from : {required: "Please select date"},
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


        $('body').on('change', '.employee_id', function(){
            var employee = $('#employee_id').val();
            var data = { 'employee': employee};
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/salary-increment/ajaxcall",
                data: { 'action': 'get-employee-for-salary-increment', 'data': data },
                success: function (data) {
                   var Employee=  JSON.parse(data);
                    $("#previous_salary").val(Employee[0].salary ?? "0");
                },
            });
        });
    }

    var editSalaryIncrement = function(){
        var form = $('#edit-salary-increment');
        var rules = {
            employee_id : {required: true},
            previous_salary : {required: true},
            current_salary : {required: true},
            start_from : {required: true}
        };

        var message = {
            employee_id : {required: "Please select employee"},
            previous_salary : {required: "Please enter previous salary"},
            current_salary : {required: "Please enter current salary"},
            start_from : {required: "Please select date"},
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

        $('body').on('change', '.employee_id', function(){
            var employee = $('#employee_id').val();
            var data = { 'employee': employee};
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/salary-increment/ajaxcall",
                data: { 'action': 'get-employee-for-salary-increment', 'data': data },
                success: function (data) {
                   var Employee=  JSON.parse(data);
                    $("#previous_salary").val(Employee[0].salary ?? "0");
                },
            });
        });
    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addSalaryIncrement();
        },
        edit:function(){
            editSalaryIncrement();
        },
    }
}();
