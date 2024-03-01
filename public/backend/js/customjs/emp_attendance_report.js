var EmpAttendanceReport = function () {
    var list = function () {
        $('.select2').select2();
        var month = $('#reportMonthId').val();
        var year = $('#reportYearId').val();
        var LeaveType = $('#reportLeaveType').val()
        var dataArr = { 'month': month, 'year': year, 'LeaveType': LeaveType };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#emp-attendance-list',
            'ajaxURL': baseurl + "employee/emp-attendance-reports/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0, 5],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("change", ".att-report-fill", function () {

            var html = '';
            html = '<table class="table table-bordered table-checkable" id="emp-attendance-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Employee</th>'+
            '<th>Attendance Type</th>'+
            '<th>Minutes</th>'+
            '<th>reason</th>'+
            // '<th>Action</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".emp-attendance-list").html(html);

            var month = $('#reportMonthId').val();
            var year = $('#reportYearId').val();
            var LeaveType = $('#reportLeaveType').val()
            var dataArr = { 'month': month, 'year': year, 'LeaveType': LeaveType };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#emp-attendance-list',
                'ajaxURL': baseurl + "employee/emp-attendance-reports/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 5],
                'noSearchApply': [0, 5],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);
        })

    }
    return {
        init: function () {
            list();
        },
    }
}();
