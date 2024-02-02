var PublicHoliday = function(){

    var list = function(){
        var startDate = $('#start_date_id').val();
        var endDate = $('#end_date_id').val();
        var dataArr = { 'startDate': startDate, 'endDate': endDate };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#public-holiday-list',
            'ajaxURL': baseurl + "admin/public-holiday/ajaxcall",
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
                url: baseurl + "admin/public-holiday/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".show-public-holiday-form", function() {
            $("#show-public-holiday-form").html('-').addClass('remove-public-holiday-form');
            $("#show-public-holiday-form").html('-').removeClass('show-public-holiday-form');
            $("#add-public-holiday").slideToggle("slow");
        })

        $("body").on("click", ".remove-public-holiday-form", function() {
            $("#show-public-holiday-form").html('+').removeClass('remove-public-holiday-form');
            $("#show-public-holiday-form").html('+').addClass('show-public-holiday-form');
            $("#add-public-holiday").slideToggle("slow");
        })

        $("body").on("click", "#show-public-holiday-filter", function() {
            $("div .public-holiday-filter").slideToggle("slow");
        })

        $(".datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $("body").on("change", ".change-fillter", function () {
            var target = [120, 121, 122, 123, 124, 125];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="public-holiday-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Date</th>'+
            '<th>Holiday Name</th>'+
            '<th>Note</th>';
            if (isAdmin == 'Y' || intersectCount > 0 ) {
                html += '<th>Action</th>';
            }
            html += '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".public-holiday-list-div").html(html);

                var startDate = $('#start_date_id').val();
                var endDate = $('#end_date_id').val();
                var dataArr = { 'startDate': startDate, 'endDate': endDate };
                var columnWidth = { "width": "5%", "targets": 0 };
                var arrList = {
                    'tableID': '#public-holiday-list',
                    'ajaxURL': baseurl + "admin/public-holiday/ajaxcall",
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

        })

        $("body").on("click", ".reset", function () {
            location.reload(true);
        });

        $("body").on('click','.public-holiday-view', function(){
            var id = $(this).data('id');
            console.log(id);
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/public-holiday/ajaxcall",
                data: { 'action': 'public-holiday-view', 'data': data },
                success: function (data) {
                   var PublicHoliday=  JSON.parse(data);

                   function formatDate(inputDate) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const day = inputDate.getDate();
                    const month = months[inputDate.getMonth()];
                    const year = inputDate.getFullYear();
                    return `${day}-${month}-${year}`;
                  }

                  const inputDate = new Date(PublicHoliday.date);
                  const formattedDate = formatDate(inputDate);

                   $("#holiday_date").text(formattedDate);
                   $("#holiday_name").text(PublicHoliday.holiday_name);
                   $("#holiday_note").text(PublicHoliday.note);
                }
            });
        });

        var importform = $('#import-public-holidays');
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
    var addPublicHoliday = function(){
        var form = $('#add-public-holiday');
        var rules = {
            date : {required: true},
            public_holiday_name : {required: true}
        };

        var message = {
            date : {required: "Please select date"},
            public_holiday_name : {required: "Please enter public holiday name"},
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

    var editPublicHoliday = function(){
        var form = $('#edit-public-holiday');
        var rules = {
            date : {required: true},
            public_holiday_name : {required: true}
        };

        var message = {
            date : {required: "Please select date"},
            public_holiday_name : {required: "Please enter public holiday name"},
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
            addPublicHoliday();
        },
        edit:function(){
            editPublicHoliday();
        },
    }
}();
