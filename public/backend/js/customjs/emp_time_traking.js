var EmpTimeTraking = function () {
    var list = function () {

        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-tracker-list      ',
            'ajaxURL': baseurl + "employee/time-tracking/ajaxcall",
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
    }

    var time_tracking_list = function () {

        var date = $('.change_date').val();
        var dataArr = { 'date': date };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#emp-time-tracking-list',
            'ajaxURL': baseurl + "admin/attendance/ajaxcall",
            'ajaxAction': 'get_time_tracking_datatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 5],
            'noSearchApply': [0, 5],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("change", ".change_date", function () {

            var html = '';
            html = '<table class="table table-bordered table-checkable" id="emp-time-tracking-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Date</th>' +
                '<th>Employee</th>' +
                '<th>In Time</th>' +
                '<th>Out Time</th>'+
                '<th>Working Time</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>';

            $(".emp-time-tracking-list").html(html);

            var date = $('.change_date').val();
            var dataArr = { 'date': date };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#emp-time-tracking-list',
                'ajaxURL': baseurl + "admin/attendance/ajaxcall",
                'ajaxAction': 'get_time_tracking_datatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 5],
                'noSearchApply': [0, 5],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);

        });

    }

    return {
        init: function () {
            list();
        },
        admin_list: function () {
            time_tracking_list();
        }
    }
}();
