var EmpAttendanceReport = function () {
    var list = function () {
        $('.select2').select2();
        var date = $('.change_date').val();
        var dataArr = { 'date': date };
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

    }
    return {
        init: function () {
            list();
        },
    }
}();
