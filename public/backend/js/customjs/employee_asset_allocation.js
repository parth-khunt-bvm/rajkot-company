var EmployeeAssetAllocation = function(){

    var list = function(){
        $('.select2').select2();
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#asset-allocation-list',
            'ajaxURL': baseurl + "admin/employee/asset-allocation/ajaxcall",
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

    }

    return {
        init:function(){
            list();
        }
    }
}();
