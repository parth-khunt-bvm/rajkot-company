var UserRole = function () {
    var list = function () {
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#user-role-list',
            'ajaxURL': baseurl + "admin/user-role/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on("click", ".delete-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'delete-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/user-role/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".deactive-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-deactive:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-deactive', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'deactive-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/user-role/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".active-records", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-active:visible').attr('data-id', id);
            }, 500);
        })

        $('body').on('click', '.yes-sure-active', function () {
            var id = $(this).attr('data-id');
            var data = { 'id': id, 'activity': 'active-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/user-role/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        var importform = $('#import-user-role');
        var rules = {
            file: { required: true },
        };

        var message = {
            file: { required: "Please select file" },
        }
        handleFormValidateWithMsg(importform, rules, message, function (importform) {
            handleAjaxFormSubmit(importform, true);
        });

        $("body").on("click", ".show-user-role-form", function() {
            $("#show-user-role-form").html('-').addClass('remove-type-form');
            $("#show-user-role-form").html('-').removeClass('show-user-role-form');
            $("#add-user-role").slideToggle("slow");
        })

        $("body").on("click", ".remove-type-form", function() {
            $("#show-user-role-form").html('+').removeClass('remove-type-form');
            $("#show-user-role-form").html('+').addClass('show-user-role-form');
            $("#add-user-role").slideToggle("slow");
        })
    }
    var addUserRole = function () {
        var form = $('#add-user-role');
        var rules = {
            user_role_name: { required: true },
            status: { required: true }
        };

        var message = {
            user_role_name: { required: "Please enter user role name" },
            status: { required: "Please select status" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
    }
    var editUserRole = function () {
        var form = $('#edit-user-role');
        var rules = {
            user_role_name: { required: true },
            status: { required: true }
        };

        var message = {
            user_role_name: { required: "Please enter user role name" },
            status: { required: "Please select status" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
    }
    var viewUserRoles = function() {

        var form = $('#user-roles-permissions');
        var rules = {};
        var message = {}
        handleFormValidateWithMsg(form, rules, message, function(form) {
            handleAjaxFormSubmit(form, true);
        });

        $('body').on("change", ".module_master", function() {
            var className = $(this).attr('data-module-master-class-name');

            if ($(this).prop('checked') == true) {
                $("." + className).prop('checked', true); // Checks the box
            } else {
                $("." + className).prop('checked', false); // Checks the box
            }
        });

        $('body').on("change", ".master_check_box", function() {
            var className = $(this).attr('data-sub-menu-class-name');

            if ($(this).prop('checked') == true) {
                $("." + className).prop('checked', true); // Checks the box
            } else {
                $("." + className).prop('checked', false); // Checks the box
            }
        });

        $('body').on("change", ".sub_menu", function() {
            var data_module_class = $(this).attr('data-module-class');
            var data_module_id = $(this).attr('data-module-id');

            var temp_master = true;

            $('.' + data_module_class).each(function() {
                if ($(this).prop('checked') != true) {
                    temp_master = false;
                }
            });

            if (temp_master) {
                $("#" + data_module_id).prop('checked', true);
            } else {
                $("#" + data_module_id).prop('checked', false);
            }

            var data_module_id = $(this).attr('data-master-id');
            var data_master_class = $(this).attr('data-master-class');

            var temp_module_master = true;

            $('.' + data_master_class).each(function() {
                $(this).css('border', '1px solid red');
                if ($(this).prop('checked') != true) {
                    temp_module_master = false;
                }
            });

            if (temp_module_master) {
                $("#" + data_module_id).prop('checked', true);
            } else {
                $("#" + data_module_id).prop('checked', false);
            }

        });

        $('body').on("change", ".master_check_box", function() {

            var data_module_id = $(this).attr('data-master-id');
            var data_master_class = $(this).attr('data-master-class');

            var temp_module_master = true;

            $('.' + data_master_class).each(function() {
                $(this).css('border', '1px solid red');
                if ($(this).prop('checked') != true) {
                    temp_module_master = false;
                }
            });

            if (temp_module_master) {
                $("#" + data_module_id).prop('checked', true);
            } else {
                $("#" + data_module_id).prop('checked', false);
            }

        });

        checke_sub_menu();
        checke_module_menu();


        function checke_module_menu() {
            $(".master-menu-div").each(function() {
                var master_checkbox_class = $(this).attr('data-class');
                var master_checkbox_id = $(this).attr('data-id');
                var temp_master = true;

                $("." + master_checkbox_class).each(function() {

                    if ($(this).prop('checked') != true) {
                        temp_master = false;
                    }

                });

                if (temp_master) {
                    $("#" + master_checkbox_id).prop('checked', true);
                } else {
                    $("#" + master_checkbox_id).prop('checked', false);
                }
            });
        }

        function checke_sub_menu() {
            $(".sub-menu-div").each(function() {
                var module_checkbox_class = $(this).attr('data-class');
                var module_checkbox_id = $(this).attr('data-id');
                var temp_module = true;

                $("." + module_checkbox_class).each(function() {
                    if ($(this).prop('checked') != true) {
                        temp_module = false;
                    }
                });

                if (temp_module) {
                    $("#" + module_checkbox_id).prop('checked', true);
                } else {
                    $("#" + module_checkbox_id).prop('checked', false);
                }
            });

        }

    }
    return {
        init: function () {
            list();
        },
        add: function () {
            addUserRole();
        },
        edit: function () {
            editUserRole();
        },
        view: function() {
            viewUserRoles();
        }
    }
}();
