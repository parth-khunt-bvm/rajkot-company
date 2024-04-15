var DocumentType = function(){
    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#document-type-list',
            'ajaxURL': baseurl + "admin/document-type/ajaxcall",
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
                url: baseurl + "admin/document-type/ajaxcall",
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
                url: baseurl + "admin/document-type/ajaxcall",
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
                url: baseurl + "admin/document-type/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".show-document-type-form", function() {
            $("#show-document-type-form").html('-').addClass('remove-document-type-form');
            $("#show-document-type-form").html('-').removeClass('show-document-type-form');
            $("#add-document-type").slideToggle("slow");
        })

        $("body").on("click", ".remove-document-type-form", function() {
            $("#show-document-type-form").html('+').removeClass('remove-document-type-form');
            $("#show-document-type-form").html('+').addClass('show-document-type-form');
            $("#add-document-type").slideToggle("slow");
        })
    }

    var addDocumentType = function(){
        var form = $('#add-document-type');
        var rules = {
            document_name : {required: true},
            image_requirement : {required: true},
            status : {required: true}
        };
        var message = {
            document_name : {required: "Please enter document name"},
            image_requirement : {required: "please enter requirement image number"},
            status : {required: "Please select status"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    var editDocumentType = function(){
        var form = $('#edit-document-type');
        var rules = {
            document_name : {required: true},
            image_requirement : {required: true},
            status : {required: true}
        };
        var message = {
            document_name : {required: "Please enter document name"},
            image_requirement : {required: "please enter requirement image number"},
            status : {required: "Please select status"},
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
            addDocumentType();
        },
        edit:function(){
            editDocumentType();
        },
    }
}();
