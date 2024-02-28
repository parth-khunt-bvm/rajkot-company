var User = function(){
    var list = function(){

        $('.select2').select2();
        var userType = $("#user_role").val();
        var userStatus = $("#user_status").val();
        var branch = $("#user_branch").val();
        var dataArr = { 'userType': userType, 'userStatus': userStatus,'branch': branch, };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#user-list',
            'ajaxURL': baseurl + "admin/user/ajaxcall",
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

        $("body").on("click", ".delete-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/user/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".deactive-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure-deactive:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-deactive', function() {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'deactive-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/user/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".active-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure-active:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-active', function() {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'active-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/user/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", "#show-user-filter", function() {
            $("div .user-filter").slideToggle("slow");
        })

        $('body').on('change', '.user-filter', function() {
            var target = [3, 4, 5];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));

            var html = '<table class="table table-bordered table-checkable" id="user-list">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>First Name</th>' +
                '<th>Last Name</th>' +
                '<th>Email</th>' +
                '<th>Branch</th>' +
                '<th>User Type</th>' +
                '<th>Status</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {

                html += '<th>Action</th>';
            }

            html += '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>';

            $('.user-list-div').html(html);

            var userType = $("#user_role").val();
            var userStatus = $("#user_status").val();
            var branch = $("#user_branch").val();
            var dataArr = { 'userType': userType, 'userStatus': userStatus,'branch': branch, };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#user-list',
                'ajaxURL': baseurl + "admin/user/ajaxcall",
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
        $("body").on("click", ".reset", function () {
            location.reload(true);
        });
    }

    var addUser = function(){
        $('.select2').select2();
        var form = $('#add-user');

        $.validator.addMethod("strongPassword", function(value, element) {
            // Example: at least one uppercase letter, one lowercase letter, one number, and one special character
            return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
          },);

        var rules = {
            first_name : {required: true},
            last_name : {required: true},
            email : {required: true},
            password: {
                required: true,
                minlength: 8,
                strongPassword: true
            },
            confirm_password: {required: true,equalTo: "#password"},
            user_role : {required: true},
            "branch[]": {required: true},
        };

        var message = {
            first_name : {required: "Please enter first name"},
            last_name : {required: "Please enter last name"},
            email : {required: "Please enter email"},
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long",
                strongPassword: "Your password must contain at least one uppercase letter, one lowercase letter, one number, and one special character"
            },
            confirm_password: {
                required: "Please enter confirm password",
                equalTo: "New Password and confirmn password not match"
            },
            user_role : {required: "Please select User"},
            "branch[]" : {required: "Please select Branch Name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    var EditUser = function(){
        $('.select2').select2();
        var form = $('#edit-user');
        var rules = {
            first_name : {required: true},
            last_name : {required: true},
            email : {required: true},
            user_role : {required: true},
            branch_id : {required: true},
        };

        var message = {
            first_name : {required: "Please enter first name"},
            last_name : {required: "Please enter last name"},
            email : {required: "Please enter email"},
            user_role : {required: "Please select User"},
            branch_id : {required: "Please select Branch Name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addUser();
        },
        edit:function(){
            EditUser();
        },
    }
}();
