var EmployeeBirthday = function(){

    var list = function(){
        $('.select2').select2();
        var bdayTime = $("#employee_bday").val();
        var dataArr = {'bdayTime' : bdayTime} ;
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-birthday-list',
            'ajaxURL': baseurl + "admin/employee/birthday/ajaxcall",
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

        $("body").on("change", ".employee_bday", function () {
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="employee-birthday-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Birth Date</th>'+
            '<th>Employee Name</th>'+
            '<th>Department</th>'+
            '<th>Designation</th>'+
            '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".bday-list").html(html);

            var bdayTime = $("#employee_bday").val();
            var dataArr = {'bdayTime' : bdayTime} ;

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#employee-birthday-list',
                'ajaxURL': baseurl + "admin/employee/birthday/ajaxcall",
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
