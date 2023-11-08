var Type = function () {
    var list = function () {
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#type-list',
            'ajaxURL': baseurl + "admin/type/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 3],
            'noSearchApply': [0, 3],
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
                url: baseurl + "admin/type/ajaxcall",
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
                url: baseurl + "admin/type/ajaxcall",
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
                url: baseurl + "admin/type/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        var importform = $('#import-type');
        var rules = {
            file: { required: true },
        };

        var message = {
            file: { required: "Please select file" },
        }
        handleFormValidateWithMsg(importform, rules, message, function (importform) {
            handleAjaxFormSubmit(importform, true);
        });

        $('body').on('click', '.add-type-button', function () {

            var html = "";
            html = '<div class="row removediv">' +
                '<div class="col-md-10">' +
                '<div class="form-group">' +
                '<input type="text" name="type_name[]" class="form-control typeinput" placeholder="Enter type name">' +
                '<span class="type_error text-danger"></span>'+
                '</div>' +
                '</div>' +
                '<div class="col-md-2 padding-left-5 padding-right-5">' +
                '<div class="form-group">' +
                '<a href="javascript:;" class="my-btn btn btn-success add-type-button mr-2"><i class="my-btn fa fa-plus"></i></a>' +
                '<a href="javascript:;" class="my-btn btn btn-danger remove-type"><i class="my-btn fa fa-minus"></i></a>' +
                '</div>' +
                '</div>' +
                '</div>';

            $("#addTypeDiv").append(html)
        });

        $('body').on("click", ".remove-type", function () {
            $(this).closest('.removediv').remove();
        });

        var customValid = true;
        $('#add-type-modal').validate({
            debug: true,
            errorElement: 'span', //default input error message container
            errorClass: 'help-block', // default input error message class
            rules: {
                status: { required: true }
            },
            messages: {
                status: { required: "Please select status" },
            },

            invalidHandler: function (event, validator) {
                validateTrip = false;
                customValid = customerInfoValid();
            },

            submitHandler: function (form) {
                $(".submitbtn:visible").attr("disabled", "disabled");
                $("#loader").show();
                customValid = customerInfoValid();
                if (customValid)
                {
                    var options = {
                        resetForm: false, // reset the form after successful submit
                        success: function (output) {
                            handleAjaxResponse(output);
                        }
                    };
                    $(form).ajaxSubmit(options);
                }else{
                    $(".submitbtn:visible").prop("disabled",false);
                    $("#loader").hide();
                }
            },

            errorPlacement: function(error, element) {
                customValid = customerInfoValid();
                var elem = $(element);
                if (elem.hasClass("select2-hidden-accessible")) {
                    element = $("#select2-" + elem.attr("id") + "-container").parent();
                    error.insertAfter(element);
                }else {
                    if (elem.hasClass("radio-btn")) {
                        element = elem.parent().parent();
                        error.insertAfter(element);
                    }else{
                        error.insertAfter(element);
                    }
                }
            },
        });

        function customerInfoValid() {
            var customValid = true;
            $('.typeinput').each(function () {
                var elem = $(this);
                if ($(this).is(':visible')) {
                    if ($(this).val() == '' || $(this).val() == null) {
                        $(this).parent().find('.type_error').text('Please add type');
                        customValid = false;
                    } else {
                        $(this).parent().find('.type_error').text('');
                    }
                }
            });
            return customValid;
        }

        $("body").on("click", ".show-type-form", function() {
            $("#show-type-form").html('-').addClass('remove-type-form');
            $("#show-type-form").html('-').removeClass('show-type-form');
            $("#add-type").slideToggle("slow");
        })

        $("body").on("click", ".remove-type-form", function() {
            $("#show-type-form").html('+').removeClass('remove-type-form');
            $("#show-type-form").html('+').addClass('show-type-form');
            $("#add-type").slideToggle("slow");
        })
    }
    var addType = function () {
        var form = $('#add-type');
        var rules = {
            type_name: { required: true },
            status: { required: true }
        };

        var message = {
            type_name: { required: "Please enter Type name" },
            status: { required: "Please select status" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
    }
    var editType = function () {
        var form = $('#edit-type');
        var rules = {
            type_name: { required: true },
            status: { required: true }
        };

        var message = {
            type_name: { required: "Please enter Type name" },
            status: { required: "Please select status" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });
    }
    return {
        init: function () {
            list();

        },
        add: function () {
            addType();
        },
        edit: function () {
            editType();
        },
    }
}();
