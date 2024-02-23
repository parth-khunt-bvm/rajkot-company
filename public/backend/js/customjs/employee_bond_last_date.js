
var EmployeeBondLastDate = function(){

    var list = function(){
        var bondLastDateTime = $("#employee_bond_last_date").val();
        var startDate = $('#start_date_id').val();
        var endDate = $('#end_date_id').val();
        var dataArr = {'bondLastDateTime' : bondLastDateTime,'startDate' : startDate,'endDate' : endDate} ;
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
            reportVal = $(".employee_bond_last_date").val();

            console.log(reportVal);
            if(reportVal == "custom"){
                $(".bond-last-date-fill").slideDown("slow");
            } else {
                $('#start_date_id').val(" ");
                $('#end_date_id').val(" ");
                $(".bond-last-date-fill").slideUp("slow");
            }

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
            var startDate = $('#start_date_id').val();
            var endDate = $('#end_date_id').val();
            var dataArr = {'bondLastDateTime' : bondLastDateTime,'startDate' : startDate,'endDate' : endDate} ;


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

        $("body").on("change", ".date-fill", function () {
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
            var startDate = $('#start_date_id').val();
            var endDate = $('#end_date_id').val();
            var dataArr = {'bondLastDateTime' : bondLastDateTime,'startDate' : startDate,'endDate' : endDate} ;
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
        });
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
