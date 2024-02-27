var LatterTemplate = function(){

    var list = function(){
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#latter-template-list',
            'ajaxURL': baseurl + "admin/latter-templates/ajaxcall",
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
                url: baseurl + "admin/latter-templates/ajaxcall",
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
                url: baseurl + "admin/latter-templates/ajaxcall",
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
                url: baseurl + "admin/latter-templates/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

    }

    var addLatterTemplate = function(){

        ClassicEditor
        .create( document.querySelector( '#template' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );

        var form = $('#add-latter-template');
        var rules = {
            template_name : {required: true},
            status : {required: true},
            template : {
                // required: function() {
                //     CKEDITOR.instances.editor.updateElement();
                //     var editorContent = $('#template').val().trim();
                //     return editorContent.length === 0;
                //   }
                required: true
            }
        };

        var message = {
            template_name : {required: "Please enter template name"},
            status : {required: "Please select status"},
            template : {required: "Please enter template"}

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

    }

    var editLatterTemplate = function(){

        ClassicEditor
        .create( document.querySelector( '#template' ) )
        .then( editor => {
            console.log( editor );
        } )
        .catch( error => {
            console.error( error );
        } );

        var form = $('#edit-latter-template');
        var rules = {
            template_name : {required: true},
            status : {required: true},
            template : {
                // required: function() {
                //     CKEDITOR.instances.editor.updateElement();
                //     var editorContent = $('#template').val().trim();
                //     return editorContent.length === 0;
                //   }
                required: true
            }
        };

        var message = {
            template_name : {required: "Please enter template name"},
            status : {required: "Please select status"},
            template : {required: "Please enter template"}

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
            addLatterTemplate();
        },
        edit:function(){
            editLatterTemplate();
        },
    }
}();
