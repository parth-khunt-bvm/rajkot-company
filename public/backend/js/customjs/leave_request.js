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
                  const inputStartDate = new Date(LeaveRequest.date);
                  const formattedStartDate = formatDate(inputStartDate);

                   $("#leave_start_date").text(formattedStartDate);
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
                   $("#leaveType").text(leave_type);

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

    }

    var addLeaveRequest = function(){
        var form = $('#add-leave-request');
        var rules = {
            'date[]' : {required: true},
            'manager[]' : {required: true},
            'leave_type[]' : {required: true}
        };

        var message = {
            'date[]' : {required: "Please select date"},
            'manager[]' : {required: "Please select manager"},
            'leave_type[]' : {required: "Please select leave type"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
        
        // var today = new Date();
        // var dd = String(today.getDate()).padStart(2, '0');
        // var mm = today.toLocaleString('en-US', { month: 'short' });
        // var yyyy = today.getFullYear();
        // today = dd + '-' + mm + '-' + yyyy;
        // $(".datepicker_start_date").val(today);
        // $(".datepicker_end_date").val(today);
        $(".datepicker_start_date").datepicker({
            multidate: true,
            format: 'd-M-yyyy',
            todayHighlight: true,
            orientation: "bottom auto",
            startDate: new Date()
        }).on("changeDate", function(e) {
            var dates = $(this).val().split(',');
            
            dates.sort(function(a, b) {
                return new Date(a) - new Date(b);
            });

            $(this).val(dates.join(', '));
            updateLeaveTypeFields(dates);
        });
        function updateLeaveTypeFields(dates) {
            var $leaveDateElement = $('.leaveDate');
            var $container = $leaveDateElement.nextAll('.leave-type-container').last();

            $leaveDateElement.nextAll('.leave-type-container').remove();
    
            dates.forEach(function(date, index) {
                var leaveTypeField = `
                    <div class="col-md-2 leave-type-container">
                        <div class="form-group leave-type-group" data-date="${date}">
                            <label>Leave Type for ${date}
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 leave_type" name="leave_type[]">
                                <option value="">Please select Leave Type</option>
                                <option value="1">Full Day Leave</option>
                                <option value="2">Half Day Leave</option>
                                <option value="3">Short Leave</option>
                            </select>
                        </div>
                    </div>`;
                if (index === 0) {
                    $('.leaveDate').after(leaveTypeField);
                } else {
                    $container.after(leaveTypeField);
                }
                $container = $leaveDateElement.nextAll('.leave-type-container').last();
                $('.select2').select2();
            });
        }

        var index = 1;

        $('body').on('click', '.add-leave', function (e) {
            e.preventDefault();
            if(form.valid()){

                var add_leave_row = `<div class="row new-leave-row" style="display: none;">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Start Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="start_date[]" class="form-control date datepicker_start_date_${index}" max="${new Date().toISOString().split('T')[0]}" placeholder="Select Date" value="" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>End Date
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="end_date[]" class="form-control date datepicker_end_date_${index}" max="${new Date().toISOString().split('T')[0]}" placeholder="Select Date" value="" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Leave Type
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 leave_type leave_select" name="leave_type[]" id="leave_type_${index}">
                                <option value="">Please select Leave Type</option>
                                <option value="1">Full Day Leave</option>
                                <option value="2">Half Day Leave</option>
                                <option value="3">Short Leave</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Manager
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 manager input-name" id="manager_${index}" name="manager[]">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Reason
                            </label>
                            <textarea class="form-control" id="" cols="40" rows="1" name="reason[]" id="reason"></textarea>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center">
                        <button class="btn btn-primary font-weight-bolder mr-4 add-leave" id="">+</button>
                        <button class="btn btn-danger font-weight-bolder remove-leave" id="">-</button>
                    </div>
                </div>`;
                    $('.add-leave-body').append(add_leave_row);
                    $('.new-leave-row').last().slideDown('slow').removeClass('new-leave-row');
                    $('#leave_type_' + index).select2();
                    $('#manager_' + index).select2();
                    
                    $.ajax({
                        type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "employee/admin/leave-request/ajaxcall",
                    data: { 'action': 'get-manager-detail' },
                    success: function(data) {
                        var manager = $('.add-leave-body').find('.row').last().find('.manager');
                        $(manager).html(data);
                    }
                });

                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = today.toLocaleString('en-US', { month: 'short' });
                var yyyy = today.getFullYear();
                today = dd + '-' + mm + '-' + yyyy;
                $(".datepicker_start_date_" + index).val(today);
                $(".datepicker_end_date_" + index).val(today);
                $(".datepicker_start_date_" + index).datepicker({
                    format: 'd-M-yyyy',
                    todayHighlight: true,
                    autoclose: true,
                    orientation: "bottom auto",
                    startDate: new Date()
                });
                $(".datepicker_end_date_" + index).datepicker({
                    format: 'd-M-yyyy',
                    todayHighlight: true,
                    autoclose: true,
                    orientation: "bottom auto",
                    startDate: new Date()
                });
                
                index++;
            }
        });

        $('body').on('click', '.remove-leave', function (e) {
            e.preventDefault();
            var row = $(this).closest('.row');
            row.slideUp('slow', function() {
                $(this).remove();
            });
        });

    }


    var editLeaveRequest = function(){
        var form = $('#edit-leave-request');
        var rules = {
            start_date : {required: true},
            end_date : {required: true},
            manager : {required: true},
            leave_type : {required: true}
        };

        var message = {
            start_date : {required: "Please select date"},
            end_date : {required: "Please select date"},
            manager : {required: "Please select manager"},
            leave_type : {required: "Please select leave type"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $("#datepicker_start_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
            startDate: new Date()
        });
        $("#datepicker_end_date").datepicker({
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
