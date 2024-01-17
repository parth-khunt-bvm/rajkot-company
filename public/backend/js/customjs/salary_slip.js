var SalarySlip = function(){

    var list= function(){

        var employee = $("#employee_id").val();
        var month = $('#monthId').val();
        var year = $("#yearId").val();

        var dataArr = { 'employee': employee, 'month': month, 'year': year };
        var columnWidth = [{"width": "5%", "targets": 0 }, {"width": "30%", "targets": 6 }];
        var arrList = {
            'tableID': '#admin-salary-slip-list',
            'ajaxURL': baseurl + "admin/employee-salaryslip/ajaxcall",
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
                url:baseurl + "admin/employee-salaryslip/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $('body').on('click', '.generate-salary-slip', function() {
            console.log("click");
            var id = $(this).attr('data-id');
            var data = { id: id, 'activity': 'generate-salary-slip', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/employee-salaryslip/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    console.log("success");
                    $("#loader").show();
                    handleAjaxResponse(data);
                },
                error: function (err) {
                    console.log("success");
                }
            });
        });

        $("body").on("click", "#show-salary-slip-filter", function() {
            $("div .salary-slip-filter").slideToggle("slow");
        })

        $("body").on("change", ".change", function () {
            $target = [128,129,130,131];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html ='<table class="table table-bordered table-checkable" id="admin-salary-slip-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Employee Name</th>'+
            '<th>Department Name</th>'+
            '<th>Designation Name</th>'+
            '<th>Month - Year</th>';
            if (isAdmin == 'Y' || intersectCount > 0 ) {
                 html += '<th>Action</th>';
             }
            html +=  ' </tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".salary-slip-list").html(html);

            var employee = $("#employee_id").val();
            var month = $('#monthId').val();
            var year = $("#yearId").val();

            var dataArr = { 'employee': employee, 'month': month, 'year': year };
            var columnWidth = [{"width": "5%", "targets": 0 }, {"width": "30%", "targets": 6 }];
            var arrList = {
                'tableID': '#admin-salary-slip-list',
                'ajaxURL': baseurl + "admin/employee-salaryslip/ajaxcall",
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

        $("body").on("click", ".reset", function () {
            location.reload(true);
        });


    }

    var addSalarySlip = function(){

        $('.select2').select2();
        var form = $('#add-salary-slip');
        var rules = {
            empDepartment:  { required: true, number: true },
            empDesignation:  { required: true, number: true },
            employee:  { required: true, number: true },
            month:  { required: true},
            year:  { required: true},
            wd:  { required: true, number: true },
            ext_tax_pr:  { required: true, number: true },
            ext_tax:  { required: true, number: true },
            hra_pr:  { required: true, number: true },
            hra:  { required: true, number: true },
            pro_tax_pr:  { required: true, number: true },
            pro_tax:  { required: true, number: true },
        };

        var message = {
            empDepartment :{
                required : "Please select department name",
            },
            empDesignation : {
                required : "Please select designation name"
            },
            employee : {
                required : "Please select employee name"
            },
            month : {
                required : "Please select month"
            },
            year : {
                required : "Please select year"
            },
            wd : {
                required : "Please enter working day"
            },
            hra_pr : {
                required : "Please enter house rent allowence percentage"
            },
            hra : {
                required : "Please enter house rent allowence "
            },
            pro_tax_pr : {
                required : "Please enter professional text percentage"
            },
            pro_tax : {
                required : "Please enter professional text percentage"
            },

        }

        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form, true);
        });

        $('body').on('change', '.employee-change', function(){
            var department = $('#empDepartment').val();
            var designation = $('#empDesignation').val();

            var data = { 'department': department, 'designation': designation,};
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee-salaryslip/ajaxcall",
                data: { 'action': 'get-employee-detail', 'data': data },
                success: function (data) {
                   var Employee=  JSON.parse(data);
                   console.log(Employee);

                   var html = '';
                   html += '<option value="">Please select Employee Name</option>';
                   for (var i = 0; i < Employee.length; i++) {
                       html += '<option value="'+ Employee[i].id +'">'+ Employee[i].first_name + ' ' + Employee[i].last_name +'</option>';
                   }
                   $(".employee").html(html);
                   $('.select2').select2();

                   $("body").on("change",".employee",function(){

                    var selectedEmployeeId = $(this).val();

                    var selectedEmployee = Employee.find(function (employee) {
                        return employee.id == selectedEmployeeId;
                    });

                    if (selectedEmployee) {
                        $("#basic").val(selectedEmployee.salary);
                        salaryCount();
                    }

                    });

                },
            });
        });

        var getDaysInMonth = function(month,year) {
        // Here January is 1 based
        //Day 0 is the last day in the previous month
        return new Date(year, month, 0).getDate();
        // Here January is 0 based
        // return new Date(year, month+1, 0).getDate();
        };

        $("body").on("change","#monthId",function(){
            var currentYear = new Date().getFullYear();
            var month = $(this).val();
            var html = '<option  value="">Select Salary Slip Year </option>';
            var temp_html = '';
            for (var i = 2015; i <= currentYear; i++) {
                temp_html = '<option value="' + i + '">' + i + '</option>';
                html = html + temp_html;
            }
            $("#yearId").html(html);

            if(month == '' || month == null){

                $("#yearId").attr("disabled","true");
            }else{
                $("#yearId").removeAttr("disabled");
            }
        });

        $("body").on("change","#yearId",function(){
            var month = $("#monthId").val();
            var year = $(this).val();
            $("#wd").val(getDaysInMonth(month, year));
        });

        function salaryCount(){
            var salary = $("#basic").val();
            var ext_tax_pr = $("#ext_tax_pr").val();
            var hra_pr = $("#hra_pr").val();
            var pro_tax_pr = $("#pro_tax_pr").val();
            var ext_tax = countAmountFromPercentage(salary, ext_tax_pr);
            var hra = countAmountFromPercentage(salary, hra_pr);
            var pro_tax = countAmountFromPercentage(salary, pro_tax_pr);

            $("#ext_tax").val(ext_tax.toFixed(2));
            $("#hra").val(hra.toFixed(2));
            $("#pro_tax").val(pro_tax.toFixed(2));
        }


        $("body").on("keyup","#hra_pr",function(){
            var salary = $("#basic").val();
            var hra_pr = $(this).val();
            $("#hra").val(countAmountFromPercentage(salary, hra_pr).toFixed(2));
        });

        $("body").on("keyup","#hra",function(){
            var salary = $("#basic").val();
            var hra = $(this).val();
            $("#hra_pr").val(countPercentageFromAmount(hra, salary).toFixed(2));
        });

        $("body").on("keyup","#income_tax_pr",function(){
            var salary = $("#basic").val();
            var income_tax_pr = $(this).val();
            $("#income_tax").val(countAmountFromPercentage(salary, income_tax_pr).toFixed(2));
        });

        $("body").on("keyup","#income_tax",function(){
            var salary = $("#basic").val();
            var income_tax = $(this).val();
            $("#income_tax_pr").val(countPercentageFromAmount(income_tax, salary).toFixed(2));
        });

        $("body").on("keyup","#pf_pr",function(){
            var salary = $("#basic").val();
            var pf_pr = $(this).val();
            $("#pf").val(countAmountFromPercentage(salary, pf_pr).toFixed(2));
        });

        $("body").on("keyup","#pf",function(){
            var salary = $("#basic").val();
            var pf = $(this).val();
            $("#pf_pr").val(countPercentageFromAmount(pf, salary).toFixed(2));
        });


        $("body").on("keyup","#pro_tax_pr",function(){
            var salary = $("#basic").val();
            var pro_tax_pr = $(this).val();
            $("#pro_tax").val(countAmountFromPercentage(salary, pro_tax_pr).toFixed(2));
        });

        $("body").on("keyup","#pro_tax",function(){
            var salary = $("#basic").val();
            var pro_tax = $(this).val();
            $("#pro_tax_pr").val(countPercentageFromAmount(pro_tax, salary).toFixed(2));
        });

        function countAmountFromPercentage(totalAmount, percentage){
            if(totalAmount == 0 || percentage == 0 || totalAmount == null || percentage == null || totalAmount == '' || percentage == '' ){
                return 0;
            }
            return (parseFloat(totalAmount) * parseFloat(percentage))/100;
        }

        function countPercentageFromAmount(amount, totalAmount){
            if(amount == 0 || totalAmount == 0 || amount == null || totalAmount == null || amount == '' || totalAmount == '' ){
                return 0;
            }
            return (parseFloat(amount) * 100) / parseFloat(totalAmount);
        }

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = today.toLocaleString('en-US', { month: 'short' });
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;

        $(".datepicker_date").val(today);

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
    }

    var editSalarySlip = function(){

        $('.select2').select2();
        var form = $('#edit-salary-slip');
        var rules = {
            empDepartment:  { required: true, number: true },
            empDesignation:  { required: true, number: true },
            employee:  { required: true, number: true },
            month:  { required: true},
            year:  { required: true},
            wd:  { required: true, number: true },
            ext_tax_pr:  { required: true, number: true },
            ext_tax:  { required: true, number: true },
            hra_pr:  { required: true, number: true },
            hra:  { required: true, number: true },
            pro_tax_pr:  { required: true, number: true },
            pro_tax:  { required: true, number: true },
        };

        var message = {
            empDepartment :{
                required : "Please select department name",
            },
            empDesignation : {
                required : "Please select designation name"
            },
            employee : {
                required : "Please select employee name"
            },
            month : {
                required : "Please select month"
            },
            year : {
                required : "Please select year"
            },
            wd : {
                required : "Please enter working day"
            },
            hra_pr : {
                required : "Please enter house rent allowence percentage"
            },
            hra : {
                required : "Please enter house rent allowence "
            },
            pro_tax_pr : {
                required : "Please enter professional text percentage"
            },
            pro_tax : {
                required : "Please enter professional text percentage"
            },

        }

        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form, true);
        });

        $('body').on('change', '.employee-change', function(){
            var department = $('#empDepartment').val();
            var designation = $('#empDesignation').val();
            var data = { 'department': department, 'designation': designation,};
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee-salaryslip/ajaxcall",
                data: { 'action': 'get-employee-detail', 'data': data },
                success: function (data) {
                    var output = JSON.parse(data);
                    console.log(output);
                    var temp_html = '';
                    var html ='<option  value="">Select Employee </option>';
                    for (var i = 0; i < output.length; i++) {
                    temp_html = '<option value="' + output[i].id + '">' + output[i].first_name + ' ' + output[i].last_name + '</option>';
                    html = html + temp_html;
                    }
                    $('.employee').html(html);
                },
            });
        });

           $("body").on("change",".employee",function(){
            console.log('employee');
            var employee = $(this).val();
            var data = { employee: employee, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/employee-salaryslip/ajaxcall",
                data: { 'action': 'changeEmployee', 'data': data },

                success: function(data) {
                    var output = JSON.parse(data);
                    $("#basic").val(output[0].salary);
                }
            });
        });

         var getDaysInMonth = function(month,year) {
           return new Date(year, month, 0).getDate();
          };

        $("body").on("change","#monthId",function(){
            var currentYear = new Date().getFullYear();
            var month = $(this).val();
            var html = '<option  value="">Select Salary Slip Year </option>';
            var temp_html = '';
            for (var i = 2015; i <= currentYear; i++) {
                temp_html = '<option value="' + i + '">' + i + '</option>';
                html = html + temp_html;
            }
            $("#yearId").html(html);

            if(month == '' || month == null){

                $("#yearId").attr("disabled","true");
            }else{
                $("#yearId").removeAttr("disabled");
            }
        });

        $("body").on("change","#yearId",function(){
            var month = $("#monthId").val();
            var year = $(this).val();
            $("#wd").val(getDaysInMonth(month, year));
        });

        function salaryCount(){
            var salary = $("#basic").val();
            var ext_tax_pr = $("#ext_tax_pr").val();
            var hra_pr = $("#hra_pr").val();
            var pro_tax_pr = $("#pro_tax_pr").val();
            var ext_tax = countAmountFromPercentage(salary, ext_tax_pr);
            var hra = countAmountFromPercentage(salary, hra_pr);
            var pro_tax = countAmountFromPercentage(salary, pro_tax_pr);

            $("#ext_tax").val(ext_tax.toFixed(2));
            $("#hra").val(hra.toFixed(2));
            $("#pro_tax").val(pro_tax.toFixed(2));
        }


        $("body").on("keyup","#hra_pr",function(){
            var salary = $("#basic").val();
            var hra_pr = $(this).val();
            $("#hra").val(countAmountFromPercentage(salary, hra_pr).toFixed(2));
        });

        $("body").on("keyup","#hra",function(){
            var salary = $("#basic").val();
            var hra = $(this).val();
            $("#hra_pr").val(countPercentageFromAmount(hra, salary).toFixed(2));
        });

        $("body").on("keyup","#income_tax_pr",function(){
            var salary = $("#basic").val();
            var income_tax_pr = $(this).val();
            $("#income_tax").val(countAmountFromPercentage(salary, income_tax_pr).toFixed(2));
        });

        $("body").on("keyup","#income_tax",function(){
            var salary = $("#basic").val();
            var income_tax = $(this).val();
            $("#income_tax_pr").val(countPercentageFromAmount(income_tax, salary).toFixed(2));
        });

        $("body").on("keyup","#pf_pr",function(){
            var salary = $("#basic").val();
            var pf_pr = $(this).val();
            $("#pf").val(countAmountFromPercentage(salary, pf_pr).toFixed(2));
        });

        $("body").on("keyup","#pf",function(){
            var salary = $("#basic").val();
            var pf = $(this).val();
            $("#pf_pr").val(countPercentageFromAmount(pf, salary).toFixed(2));
        });


        $("body").on("keyup","#pro_tax_pr",function(){
            var salary = $("#basic").val();
            var pro_tax_pr = $(this).val();
            $("#pro_tax").val(countAmountFromPercentage(salary, pro_tax_pr).toFixed(2));
        });

        $("body").on("keyup","#pro_tax",function(){
            var salary = $("#basic").val();
            var pro_tax = $(this).val();
            $("#pro_tax_pr").val(countPercentageFromAmount(pro_tax, salary).toFixed(2));
        });

        function countAmountFromPercentage(totalAmount, percentage){
            if(totalAmount == 0 || percentage == 0 || totalAmount == null || percentage == null || totalAmount == '' || percentage == '' ){
                return 0;
            }
            return (parseFloat(totalAmount) * parseFloat(percentage))/100;
        }

        function countPercentageFromAmount(amount, totalAmount){
            if(amount == 0 || totalAmount == 0 || amount == null || totalAmount == null || amount == '' || totalAmount == '' ){
                return 0;
            }
            return (parseFloat(amount) * 100) / parseFloat(totalAmount);
        }

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
    }

    var addAllEmployeeSalarySlip = function(){

        $('.select2').select2();
        var form = $('#add-all-employee-salary-slip');
        var rules = {
            empBranch:  { required: true, number: true },
            month:  { required: true},
            year:  { required: true},
            wd:  { required: true, number: true },
            ext_tax_pr:  { required: true, number: true },
            ext_tax:  { required: true, number: true },
            hra_pr:  { required: true, number: true },
            hra:  { required: true, number: true },
            pro_tax_pr:  { required: true, number: true },
            pro_tax:  { required: true, number: true },
        };

        var message = {
            empBranch :{
                required : "Please select Branch name",
            },
            month : {
                required : "Please select month"
            },
            year : {
                required : "Please select year"
            },
            wd : {
                required : "Please enter working day"
            },
            hra_pr : {
                required : "Please enter house rent allowence percentage"
            },
            hra : {
                required : "Please enter house rent allowence "
            },
            pro_tax_pr : {
                required : "Please enter professional text percentage"
            },
            pro_tax : {
                required : "Please enter professional text percentage"
            },

        }

        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form, true);
        });

        var getDaysInMonth = function(month,year) {
        // Here January is 1 based
        //Day 0 is the last day in the previous month
        return new Date(year, month, 0).getDate();
        // Here January is 0 based
        // return new Date(year, month+1, 0).getDate();
        };

        $("body").on("change","#monthId",function(){
            var currentYear = new Date().getFullYear();
            var month = $(this).val();
            var html = '<option  value="">Select Salary Slip Year </option>';
            var temp_html = '';
            for (var i = 2015; i <= currentYear; i++) {
                temp_html = '<option value="' + i + '">' + i + '</option>';
                html = html + temp_html;
            }
            $("#yearId").html(html);

            if(month == '' || month == null){

                $("#yearId").attr("disabled","true");
            }else{
                $("#yearId").removeAttr("disabled");
            }
        });

        $("body").on("change","#yearId",function(){
            var month = $("#monthId").val();
            var year = $(this).val();
            $("#wd").val(getDaysInMonth(month, year));
        });

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = today.toLocaleString('en-US', { month: 'short' });
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;

        $(".datepicker_date").val(today);

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
    }
    return {
        init:function(){
            list();
        },
        add:function(){
            addSalarySlip();
        },
        edit:function(){
            editSalarySlip();
        },
        addAll:function(){
            addAllEmployeeSalarySlip();
        },


    }
}();
