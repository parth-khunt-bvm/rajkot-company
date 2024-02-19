var AdminLeaveRequest = function(){

    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-leave-request-list',
            'ajaxURL': baseurl + "admin/leave-request/ajaxcall",
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
                url: baseurl + "admin/leave-request/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on('click','.admin-leave-request-view', function(){
            var id = $(this).data('id');
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/leave-request/ajaxcall",
                data: { 'action': 'admin-leave-request-view', 'data': data },
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
                        leave_type = "Short Leave";
                   }
                   $("#leeave_type").text(leave_type);

                   var leave_status;
                   if (LeaveRequest.leave_status === "P") {
                        leave_status = "Pending";
                   } else if (LeaveRequest.leave_status === "R") {
                        leave_status = "Rejected";
                   } else if (LeaveRequest.leave_status === "A") {
                        leave_status = "Approved";
                   }
                   $("#leave_status").text(leave_status);
                   $("#leave_reason").text(LeaveRequest.reason ? LeaveRequest.reason : "-");
                }
            });
        });

        $("body").on('click','.admin-leave-request-reject', function(){
            var id = $(this).data('id');
            $(".leave-request-id").val(id);
        });

        var form = $('#reject-leave-reuest');
        var rules = {
            reason : {required: true},
        };

        var message = {
            reason : {required: "Please enter reason"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
        $("body").on("click", ".leave-request-approved", function() {
            var id = $(this).data('id');
            console.log(id);
            setTimeout(function() {
                $('.yes-approved:visible').attr('data-id', id);
            }, 500);
        })
        $('body').on('click', '.yes-approved', function() {
            var id = $(this).attr('data-id');
            console.log(id);
            var data = { 'id': id, 'activity': 'approved-leave-request', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/leave-request/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
    }
    return {
        init:function(){
            list();
        },
    }
}();
