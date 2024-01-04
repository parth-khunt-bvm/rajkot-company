
var EmployeeBondLastDate = function(){

    var list = function(){
        var bondLastDateTime = $("#employee_bond_last_date").val();
        var dataArr = {'bondLastDateTime' : bondLastDateTime} ;
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-bond-last-date-list',
            'ajaxURL': baseurl + "admin/employee/bond/last/date/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0],
            'noSearchApply': [0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("change", ".employee_bond_last_date", function () {
            var html = '';
            html ='<table class="table table-bordered table-checkable" id="employee-bond-last-date-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Bond Last Date</th>'+
            '<th>Employee Name</th>'+
            '<th>Department</th>'+
            '<th>Designation</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".bond-last-date-list").html(html);

            var bondLastDateTime = $("#employee_bond_last_date").val();
            var dataArr = {'bondLastDateTime' : bondLastDateTime} ;

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#employee-bond-last-date-list',
                'ajaxURL': baseurl + "admin/employee/bond/last/date/ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0],
                'noSearchApply': [0],
                'defaultSortColumn': [0],
                'defaultSortOrder': 'DESC',
                'setColumnWidth': columnWidth
            };
            getDataTable(arrList);
        })
    }

    return {
        init:function(){
            list();
        }
    }
}();
