var EmployeeOverTime = function () {

    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#emp-overtime-list',
            'ajaxURL': baseurl + "admin/emp-overtime/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0],
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
                url: baseurl + "admin/emp-overtime/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".show-emp-overtime-form", function() {
            $("#show-emp-overtime-form").html('-').addClass('remove-emp-overtime-form');
            $("#show-emp-overtime-form").html('-').removeClass('show-emp-overtime-form');
            $("#add-emp-overtime").slideToggle("slow");
        })

        $("body").on("click", ".remove-emp-overtime-form", function() {
            $("#show-emp-overtime-form").html('+').removeClass('remove-emp-overtime-form');
            $("#show-emp-overtime-form").html('+').addClass('show-emp-overtime-form');
            $("#add-emp-overtime").slideToggle("slow");
        })

        $("body").on('click','.emp-overtime-view', function(){
            var id = $(this).data('id');
            console.log(id);
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/emp-overtime/ajaxcall",
                data: { 'action': 'emp-overtime-view', 'data': data },
                success: function (data) {
                   var empOvertime=  JSON.parse(data);
                   console.log(empOvertime);

                   function formatDate(inputDate) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const day = inputDate.getDate();
                    const month = months[inputDate.getMonth()];
                    const year = inputDate.getFullYear();
                    return `${day}-${month}-${year}`;
                  }

                  const inputDate = new Date(empOvertime.date);
                  const formattedDate = formatDate(inputDate);

                   $("#overtime_date").text(formattedDate);
                   $("#overtime_employee").text(empOvertime.first_name +' '+ empOvertime.last_name);
                   $("#overtime_hours").text(Number.parseFloat(empOvertime.hours).toFixed(2));
                   $("#overtime_note").text(empOvertime.note ?? "-");
                }
            });
        });

    }
    var addEmpOvertime = function () {
        var form = $('#add-emp-overtime');
        var rules = {
            date: { required: true },
            employee: { required: true },
            hours: { required: true }
        };

        var message = {
            date: { required: "Please select date" },
            employee: { required: "Please select Employee Name" },
            hours: { required: "Please enter hours" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $('.select2').select2();
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
    }
    var editEmpOvertime = function () {
        var form = $('#edit-emp-overtime');
        var rules = {
            date: { required: true },
            employee: { required: true },
            hours: { required: true }
        };

        var message = {
            date: { required: "Please select date" },
            employee: { required: "Please select Employee Name" },
            hours: { required: "Please enter hours" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $('.select2').select2();
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });
    }

    return {
        init: function () {
            list();
        },
        add: function () {
            addEmpOvertime();
        },
        edit: function () {
            editEmpOvertime();
        },
    }
}();
