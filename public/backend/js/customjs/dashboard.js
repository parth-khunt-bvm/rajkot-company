var Dashboard = function () {
   

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

    var password = function () {
        var form = $('#change-password');
        var rules = {
            old_password: { required: true },
            new_password: { required: true },
            new_confirm_password: { required: true, equalTo: "#password" },

        };

        var message = {
            old_password: { required: "Please enter your password" },
            new_password: { required: "Please enter your new password" },
            new_confirm_password: {
                required: "Please enter confirm password",
                equalTo: "New Password and confirmn password not match"
            },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
    }

    var EmployeeBirthdayList = function () {
        $('.select2').select2();
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#dash-employee-birthday-list',
            'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
            'ajaxAction': 'employees-birthday-list',
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

    var EmployeeBondLastDateList = function () {
        $('.select2').select2();
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#dash-employee-bond-last-date-list',
            'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
            'ajaxAction': 'employees-bond-last-date-list',
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

    var absentEmployeeList = function () {
        $('.select2').select2();
        var dataArr = {};
        var columnWidth = {};
        var arrList = {
            'tableID': '#absent-emp-list',
            'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
            'ajaxAction': 'absent-emp-list',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [],
            'noSearchApply': [],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);
    }

    var socialMediaPostList = function () {
        $('.select2').select2();
        var dataArr = {};
        var columnWidth = {};
        var arrList = {
            'tableID': '#social-media-post-list',
            'ajaxURL': baseurl + "admin/dashboard/ajaxcall",
            'ajaxAction': 'social-media-post-list',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [],
            'noSearchApply': [],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'ASC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);
    }


    return {
        edit_profile: function () {
            editProfile()
        },
        change_password: function () {
            password();
        },
        employee_birthday: function () {
            EmployeeBirthdayList();
        },
        employee_bond_last_date: function () {
            EmployeeBondLastDateList();
        },
        absent_employee_list: function () {
            absentEmployeeList();
        },
        social_media_post_list: function () {
            socialMediaPostList();
        },
    }
}();
