var ChangeRequest = function () {
    var list = function () {
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#change-request-list',
            'ajaxURL': baseurl + "admin/change-request/ajaxcall",
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

        $("body").on("click", ".change-requests", function () {
            var id = $(this).data('id');
            setTimeout(function () {
                $('.yes-sure-approved:visible').attr('data-id', id);
            }, 500);
        })


        $('body').on('click', '.yes-sure-approved', function () {
            var id = $(this).attr('data-id');
            console.log(id);
            var data = { 'id': id, 'activity': 'change-request-update', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/change-request/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

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
                url: baseurl + "admin/change-request/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });


        $("body").on('click', '.change-requests', function () {
            var id = $(this).data('id');
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/change-request/ajaxcall",
                data: { 'action': 'change-request-view', 'data': data },
                success: function (data) {
                    var oldHtml = '';
                    var newHtml = '';
                    var details = JSON.parse(data);
                    var newData = details.changeRequestData;
                    var oldData = details.oldEmployeeData;
                    var data = JSON.parse(newData);
                    $.each(oldData, function (index, value) {
                        console.log(index, value);

                        if (index === "id") {
                            return;
                        }
                        var temp = '';
                        var displayIndex = index.replace(/_/g, ' ');
                        displayIndex = displayIndex.replace(/\b\w/g, function (char) {
                            return char.toUpperCase();
                        });

                        // Date formatting for DOB and DOJ
                        // if (index === "DOB" || index === "DOJ") {
                        //     var dateParts = value.split('-');
                        //     var formattedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                        //     var day = formattedDate.getDate() < 10 ? '0' + formattedDate.getDate() : formattedDate.getDate();
                        //     value = day + '-' +
                        //         formattedDate.toLocaleString('default', { month: 'short' }) + '-' +
                        //         formattedDate.getFullYear();
                        // }

                        if (data[index] != value) {
                            temp = "<span style='color: red;'>" + displayIndex + " </span> : <span style='color: red;'>" + value + "</span><br>"; // If value doesn't match, color it red
                        } else {
                            temp = displayIndex + " : " + value + "<br>";
                        }
                        oldHtml = oldHtml + temp;
                    });

                    $.each(data, function (index, value) {

                        console.log(index, value);
                        if (index === "id") {
                            return;
                        }
                        var temp = '';
                        var displayIndex = index.replace(/_/g, ' ');
                        displayIndex = displayIndex.replace(/\b\w/g, function (char) {
                            return char.toUpperCase();
                        });

                        // Date formatting for DOB and DOJ
                        // if (index === "DOB" || index === "DOJ") {
                        //     var dateParts = value.split('-');
                        //     var formattedDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2]);
                        //     var day = formattedDate.getDate() < 10 ? '0' + formattedDate.getDate() : formattedDate.getDate();
                        //     value = day + '-' +
                        //         formattedDate.toLocaleString('default', { month: 'short' }) + '-' +
                        //         formattedDate.getFullYear();
                        // }

                        if (oldData[index] != value) {
                            temp = "<span style='color: red;'>" + displayIndex + "</span> : <span style='color: red;'>" + value + "</span><br>"; // If value doesn't match, color it red
                        } else {
                            temp = displayIndex + " : " + value + "<br>";
                        }
                        newHtml = newHtml + temp;
                    });


                    $("#old-data").html(oldHtml);
                    $("#new-data").html(newHtml);
                    $("#emp_id").val(oldData.id);
                }
            });
        });


        var form = $('#change-request-approved');
        var rules = {
            emp_id: { required: true },
        };
        var message = {
            emp_id: { required: 'Please enter id' },
        }
        handleFormValidateWithMsg(form, rules, message, function (form) {
            handleAjaxFormSubmit(form, true);
        });

    }
    return {
        init: function () {
            list();
        },

    }
}();
