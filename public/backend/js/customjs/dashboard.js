var Dashboard = function(){
    var editProfile = function(){
        var form = $('#update-profile');
        var rules = {
            first_name : {required: true},
            last_name : {required: true},
            email: {required: true,email:true},
        };

        var message = {
            first_name : {required: "Please enter your first name"},
            last_name : {required: "Please enter your last name"},
            email :{
                required : "Please enter your register email address",
                email: "Please enter valid email address"
            },

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    var password = function(){
        var form = $('#change-password');
        var rules = {
            old_password: {required: true},
            new_password: {required: true},
            new_confirm_password: {required: true,equalTo: "#password"},

        };

        var message = {
            old_password: {required: "Please enter your password"},
            new_password: {required: "Please enter your new password"},
            new_confirm_password: {
                required: "Please enter confirm password",
                equalTo: "New Password and confirmn password not match"
            },
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    var employeeBirthdayList = function(){
        $('.select2').select2();
        var bdayTime = $("#employee_bday").val();
        var dataArr = {'bdayTime' : bdayTime} ;
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-birthday-list',
            'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
            'ajaxAction': 'getbirthdaydatatable',
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
                'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
                'ajaxAction': 'getbirthdaydatatable',
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

    var employeeBondLastDateList = function(){
        var bondLastDateTime = $("#employee_bond_last_date").val();
        var dataArr = {'bondLastDateTime' : bondLastDateTime} ;
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-bond-last-date-list',
            'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
            'ajaxAction': 'getbondlastdatedatatable',
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
                'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
                'ajaxAction': 'getbondlastdatedatatable',
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
        edit_profile:function(){
            editProfile()
        },
        change_password:function(){
            password();
        },
        employee_birthday:function(){
            employeeBirthdayList();
        },
        employee_bond_last_date:function(){
            employeeBondLastDateList();
        }
    }
}();
