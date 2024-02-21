var EmployeeBirthday = function(){

    var list = function(){
        $('.select2').select2();
        var bdayTime = $("#employee_bday").val();
        var startDate = $('#start_date_id').val();
        var endDate = $('#end_date_id').val();
        var dataArr = {'bdayTime' : bdayTime,'startDate' : startDate,'endDate' : endDate} ;
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

            reportVal = $(".employee_bday").val();
            console.log(reportVal);
            if(reportVal == "custom"){
                $(".bday-fill").slideDown("slow");
            } else {
                $('#start_date_id').val(" ");
                $('#end_date_id').val(" ");
                $(".bday-fill").slideUp("slow");
            }

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
            var startDate = $('#start_date_id').val();
            var endDate = $('#end_date_id').val();
            var dataArr = {'bdayTime' : bdayTime,'startDate' : startDate,'endDate' : endDate} ;

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

        $("body").on("change", ".date-fill", function () {
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
            var startDate = $('#start_date_id').val();
            var endDate = $('#end_date_id').val();
            var dataArr = {'bdayTime' : bdayTime,'startDate' : startDate,'endDate' : endDate} ;

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

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto",
        });

        $("body").on("click", ".reset", function(){
            location.reload(true);
        });
    }

    return {
        init:function(){
            list();
        }
    }
}();
