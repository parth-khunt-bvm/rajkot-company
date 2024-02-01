var LeaveRequest = function(){

    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#leave-request-list',
            'ajaxURL': baseurl + "employee/admin/leave-request/ajaxcall",
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
            var data = { 'id': id, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "employee/admin/leave-request/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".show-leave-request-form", function() {
            $("#show-leave-request-form").html('-').addClass('remove-leave-request-form');
            $("#show-leave-request-form").html('-').removeClass('show-leave-request-form');
            $("#add-leave-request").slideToggle("slow");
        })

        $("body").on("click", ".remove-leave-request-form", function() {
            $("#show-leave-request-form").html('+').removeClass('remove-leave-request-form');
            $("#show-leave-request-form").html('+').addClass('show-leave-request-form');
            $("#add-leave-request").slideToggle("slow");
        })

        $("body").on('click','.leave-request-view', function(){
            var id = $(this).data('id');
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "employee/admin/leave-request/ajaxcall",
                data: { 'action': 'leave-request-view', 'data': data },
                success: function (data) {
                   var LeaveRequest =  JSON.parse(data);
                   function formatDate(inputDate) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const day = inputDate.getDate();
                    const month = months[inputDate.getMonth()];
                    const year = inputDate.getFullYear();
                    return `${day}-${month}-${year}`;
                  }
                  const inputDate = new Date(LeaveRequest.date);
                  const formattedDate = formatDate(inputDate);

                   $("#leave_date").text(formattedDate);
                   $("#leave_emp_name").text(LeaveRequest.first_name + " " + LeaveRequest.last_name);
                   $("#leave_man_name").text(LeaveRequest.manager_name);

                   var leave_type;
                   if (LeaveRequest.leave_type === "0") {
                        leave_type = "Present";
                   } else if (LeaveRequest.leave_type === "1") {
                        leave_type = "Absent";
                   } else if (LeaveRequest.leave_type === "2") {
                        leave_type = "Half Day";
                   } else if (LeaveRequest.leave_type === "3") {
                        leave_type = "Sort Leave";
                   }
                   $("#leeave_type").text(leave_type);

                   var leave_status;
                   if (LeaveRequest.leave_status === "P") {
                        leave_status = "Pending";
                   } else if (LeaveRequest.leave_status === "M") {
                        leave_status = "Approved By Manager";
                   } else if (LeaveRequest.leave_status === "H") {
                        leave_status = "Approved By Hr";
                   }
                   $("#leave_status").text(leave_status);
                   $("#leave_reason").text(LeaveRequest.reason ? LeaveRequest.reason : "-");
                }
            });
        });

    }

    var addLeaveRequest = function(){
        var form = $('#add-leave-request');
        var rules = {
            date : {required: true},
            manager : {required: true},
            leave_type : {required: true}
        };

        var message = {
            date : {required: "Please select date"},
            manager : {required: "Please select manager"},
            leave_type : {required: "Please select leave type"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = today.toLocaleString('en-US', { month: 'short' });
        var yyyy = today.getFullYear();
        today = dd + '-' + mm + '-' + yyyy;
        $("#datepicker_date").val(today);
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
            startDate: new Date()
        });

    }


    var editLeaveRequest = function(){
        var form = $('#edit-leave-request');
        var rules = {
            date : {required: true},
            manager : {required: true},
            leave_type : {required: true}
        };

        var message = {
            date : {required: "Please select date"},
            manager : {required: "Please select manager"},
            leave_type : {required: "Please select leave type"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
            startDate: new Date()
        });

    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addLeaveRequest();
        },
        edit:function(){
            editLeaveRequest();
        },
    }
}();
