var Counter = function () {
    var list = function () {
        var month = $('#monthId').val();
        var year = $("#yearId").val();
        var employee = $("#employee_id").val();
        var technology = $('#technology_id').val();

        var dataArr = { 'month': month, 'year': year, 'employee': employee, 'technology': technology };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-counter-list',
            'ajaxURL': baseurl + "admin/counter/ajaxcall",
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


        $("body").on("click", ".salary-not-counted", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-not-counted:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-not-counted', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'salary-not-counted', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/counter/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".salary-counted", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-counted:visible').attr('data-id', id);
            }, 500);
        });

        $('body').on('click', '.yes-sure-counted', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'salary-counted', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/counter/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".delete-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function () {
            var id = $(this).attr('data-id');
            var data = { id: id, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/counter/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $('.select2').select2();
        var importform = $('#import-counter');
        var rules = {
            file: { required: true },
            month: { required: true },
            year: { required: true },
        };

        var message = {
            file: { required: "Please select file" },
            month: { required: "Please select month" },
            year: { required: "Please select year" },
        }
        handleFormValidateWithMsg(importform, rules, message, function (importform) {
            handleAjaxFormSubmit(importform, true);
        });

        $("body").on("change", ".change", function () {
            var target = [75, 76, 77, 78, 79, 80];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="admin-counter-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Month</th>' +
                '<th>Year</th>' +
                '<th>Employee Name</th>' +
                '<th>Department</th>' +
                '<th>Present Day</th>' +
                '<th>Half Leaves</th>' +
                '<th>Full Leaves</th>' +
                '<th>Paid Leave Details</th>' +
                '<th>Total Days</th>'+
                '<th>Salary Counted</th>';
                if (isAdmin == 'Y' || intersectCount > 0 ) {
                    html += '<th>Action</th>';
                }
                html += '</tr>' +
                '</thead>' +
                '<tbody>' +
                ' </tbody>' +
                '</table>';

            $(".counter-list").html(html);

            var month = $('#monthId').val();
            var year = $("#yearId").val();
            var employee = $("#employee_id").val();
            var technology = $('#technology_id').val();

            var dataArr = { 'month': month, 'year': year, 'employee': employee, 'technology': technology };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-counter-list',
                'ajaxURL': baseurl + "admin/counter/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 10],
                'noSearchApply': [0, 10],
                'defaultSortColumn': [4],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);
        })

        $("body").on("click", ".reset", function () {
            location.reload(true);
        });

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $("body").on("click", "#show-counter-filter", function() {
            $("div .counter-filter").slideToggle("slow");
        })
    }
    var addCounter = function () {
        $('.select2').select2();
        var form = $('#add-counter-users');
        var rules = {
            month: { required: true },
            year: { required: true },
            employee_id: { required: true },
            technology_id: { required: true },
            present_day: { required: true },
            half_leaves: { required: true },
            full_leaves: { required: true },
            paid_leaves_details: { required: true },
        };
        var message = {
            month: {
                required: "Please select month",
            },
            year: {
                required: "Please enter year"
            },
            technology_id: {
                required: "Please select technology name"
            },
            employee_id: {
                required: "Please select employee name"
            },
            present_day: {
                required: "Please enter present day"
            },
            half_leaves: {
                required: "Please enter half leave"
            },
            full_leaves: {
                required: "Please enter full leave"
            },
            paid_leaves_details: {
                required: "Please enter paid leave detail"
            }
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
    }

    var editCounter = function () {
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $('.select2').select2();
        var form = $('#edit-counter-users');
        var rules = {
            month: { required: true },
            year: { required: true },
            employee_id: { required: true },
            technology_id: { required: true },
            present_day: { required: true },
            half_leaves: { required: true },
            full_leaves: { required: true },
            paid_leaves_details: { required: true },
        };
        var message = {
            month: {
                required: "Please select month",
            },
            year: {
                required: "Please enter year"
            },
            technology_id: {
                required: "Please select technology name"
            },
            employee_id: {
                required: "Please select employee name"
            },
            present_day: {
                required: "Please enter present day"
            },
            half_leaves: {
                required: "Please enter half leave"
            },
            full_leaves: {
                required: "Please enter full leave"
            },
            paid_leaves_details: {
                required: "Please enter paid leave detail"
            }
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
    }
    return {
        init: function () {
            list();
        },
        add: function () {
            addCounter();
        },
        edit: function () {
            editCounter();
        },
    }
}();
