var SocialMediaPost = function(){

    var list = function(){
        var startDate = $('#start_date_id').val();
        var endDate = $('#end_date_id').val();
        var dataArr = { 'startDate': startDate, 'endDate': endDate };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#social-media-post-list',
            'ajaxURL': baseurl + "admin/social-media-post/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 4],
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
                url: baseurl + "admin/social-media-post/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".show-social-media-post-form", function() {
            $("#show-social-media-post-form").html('-').addClass('remove-social-media-post-form');
            $("#show-social-media-post-form").html('-').removeClass('show-social-media-post-form');
            $("#add-social-media-post").slideToggle("slow");
        })

        $("body").on("click", ".remove-social-media-post-form", function() {
            $("#show-social-media-post-form").html('+').removeClass('remove-social-media-post-form');
            $("#show-social-media-post-form").html('+').addClass('show-social-media-post-form');
            $("#add-social-media-post").slideToggle("slow");
        })

        $("body").on("click", "#show-social-media-post-filter", function() {
            $("div .social-media-post-filter").slideToggle("slow");
        })

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $("body").on("change", ".change-fillter", function () {
            var target = [120, 121, 122, 123, 124, 125];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="social-media-post-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Post Detail</th>'+
            '<th>Note</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html += '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".social-media-post-list-div").html(html);

                var startDate = $('#start_date_id').val();
                var endDate = $('#end_date_id').val();
                var dataArr = { 'startDate': startDate, 'endDate': endDate };
                var columnWidth = { "width": "5%", "targets": 0 };
                var arrList = {
                    'tableID': '#social-media-post-list',
                    'ajaxURL': baseurl + "admin/social-media-post/ajaxcall",
                    'ajaxAction': 'getdatatable',
                    'postData': dataArr,
                    'hideColumnList': [],
                    'noSortingApply': [0, 4],
                    'noSearchApply': [0],
                    'defaultSortColumn': [0],
                    'defaultSortOrder': 'DESC',
                    'setColumnWidth': columnWidth
                };
                getDataTable(arrList);

        })

        $("body").on("click", ".reset", function () {
            location.reload(true);
        });

        $("body").on('click','.social-media-post-view', function(){
            var id = $(this).data('id');
            console.log(id);
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/social-media-post/ajaxcall",
                data: { 'action': 'social-media-post-view', 'data': data },
                success: function (data) {
                    var post = JSON.parse(data);

                    function formatDate(inputDate) {
                        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                        const date = inputDate.getDate();
                        const month = months[inputDate.getMonth()];
                        const year = inputDate.getFullYear();
                        const day = days[inputDate.getDay()];
                        
                        return { date:`${date}-${month}-${year}`, day:day };
                    }

                    const inputDate = new Date(post.date);
                    const formattedDate = formatDate(inputDate);
                  
                    $("#post_date").text(formattedDate.date);
                    $("#post_day").text(formattedDate.day);
                    $("#post_detail").text(post.post_detail);
                    $("#post_note").text(post.note);
                }
            });
        });

        var importform = $('#import-social-media-post-form');
        var rules = {
            file : {required: true},
        };

        var message = {
            file : {required: "Please select file"},
        }
        handleFormValidateWithMsg(importform, rules,message, function(importform) {
            handleAjaxFormSubmit(importform,true);
        });


    }
    var addSocialMediaPost = function(){
        var form = $('#add-social-media-post');
        var rules = {
            date : {required: true},
            post_detail : {required: true}
        };

        var message = {
            date : {required: "Please select date"},
            post_detail : {required: "Please enter Post detail"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
    }

    var editSocialMediaPost = function(){
        var form = $('#edit-social-media-post');
        var rules = {
            date : {required: true},
            post_detail : {required: true}
        };

        var message = {
            date : {required: "Please select date"},
            post_detail : {required: "Please enter Post detail"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $("#datepicker_date").datepicker({
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
            addSocialMediaPost();
        },
        edit:function(){
            editSocialMediaPost();
        },
    }
}();
