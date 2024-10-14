var Interview = function(){
    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#interview-list',
            'ajaxURL': baseurl + "admin/interviews/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 10],
            'noSearchApply': [0, 10],
            'defaultSortColumn': [1],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);
    }

    var addInterview = function(){
        $('.select2').select2();
        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addInterview();
        }
    }
}();
