var Document = function () {

    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#document-list',
            'ajaxURL': baseurl + "admin/document/ajaxcall",
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
                url: baseurl + "admin/document/ajaxcall",
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
            console.log(id);
            var data = { 'id': id, 'activity': 'deactive-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/document/ajaxcall",
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
                url: baseurl + "admin/document/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

    }


    var addDocument = function () {
        var form = $('#add-document');
        var rules = {
            employee_id: { required: true },
            document_type_id: { required: true },
            status: { required: true }
        };
        var message = {
            employee_id: { required: "Please enter document name" },
            document_type_id: { required: "Please enter document name" },
            status: { required: "Please select status" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $('body').on('change', '.document_type_id', function () {
            var document_type = $('#document_type_id').val();

            var data = { 'document_type': document_type };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/document/ajaxcall",
                data: { 'action': 'get-image-requirement-number', 'data': data },
                success: function (data) {
                    var imageRequirementcount = JSON.parse(data)[0]['image_requirement'];

                    var html = '';
                    for (var i = 0; i < imageRequirementcount; i++) {
                        html += '<div class="col-md-2">';
                        html += '<div class="form-group">';
                        html += '<label>Attachment ' + (i + 1) + '</label>';
                        html += '<div>';
                        html += '<div class="image-input image-input-outline" id="kt_image_' + (i + 1) + '">';
                        html += '<div class="image-input-wrapper"></div>';
                        html += '<label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="Change Attachment ' + (i + 1) + '">';
                        html += '<i class="fa fa-pencil icon-sm text-muted"></i>';
                        html += '<input type="file" name="attachment[]" accept=".png, .jpg, .jpeg"/>';
                        html += '<input type="hidden" name="profile_avatar_remove"/>';
                        html += '</label>';
                        html += '<span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Attachment ' + (i + 1) + '">';
                        html += '<i class="ki ki-bold-close icon-xs text-muted"></i>';
                        html += '</span>';
                        html += '</div>';
                        html += '<span class="form-text text-muted">Allowed file types: png, jpg, jpeg. (Max Size For Upload 2MB)</span>';
                        html += '</div>';
                        html += '</div>';
                        html += '</div>';
                    }

                    $('#attachment_fields_container').html(html);

                    new KTImageInput('kt_image_1');
                    new KTImageInput('kt_image_2');
                    new KTImageInput('kt_image_3');
                    new KTImageInput('kt_image_4');
                    new KTImageInput('kt_image_5');
                    new KTImageInput('kt_image_6');
                },
            });
        });
    }

    var editDocument = function () {
        var form = $('#edit-document');
        var rules = {
            employee_id: { required: true },
            document_type_id: { required: true },
            status: { required: true }
        };
        var message = {
            employee_id: { required: "Please enter document name" },
            document_type_id: { required: "Please enter document name" },
            status: { required: "Please select status" },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

    }


    return {
        init:function(){
            list();
        },
        add: function () {
            addDocument();
        },
        edit:function(){
            editDocument();
        },

    }
}();
