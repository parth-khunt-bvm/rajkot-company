var Audittrails = function(){
    var list = function() {
        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#audit-trails-list',
            'ajaxURL': baseurl + "audittrails/audit-trails-ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 6, 8],
            'noSearchApply': [0, 6, 8],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $('body').on("click", ".viewdata", function() {
            var id = $(this).attr('data-id');
            var data = { id: id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "audittrails/audit-trails-ajaxcall",
                data: { 'action': 'viewdata', 'data': data },
                success: function(data) {
                    var html = '';
                    var details = JSON.parse(data);
                    console.log(details);
                    if(details.oldData == null){
                        $.each(details, function( index, value ) {
                            var temp = '';
                            temp  = index + " : " + value + "<br>";
                            html = html + temp;
                        });
                    } else {
                        html += "Employee ID: " + details.employee_id + "<br>";
                        html += "First Name: " + details.newData.first_name + "<br>";
                        html += "Last Name: " + details.newData.last_name + "<br>";

                        var editedFieldsFound = false;

                        for (var key in details.oldData) {
                            // Check if the value in oldData is different from newData
                            if (details.oldData.hasOwnProperty(key) && details.oldData[key] !== details.newData[key]) {
                                if (!editedFieldsFound) {
                                    html += "<h4>Edited Fields :-</h4>";
                                    editedFieldsFound = true;
                                }
                                // If different, append the key and new value to html
                                var temp = key + " : " + details.oldData[key] + "<br>";
                                html += temp;
                            }
                        }
                        
                    }
                    $("#view-audit-trails").html(html);
                }
            });
        });
    }

    return {
        init:function(){
            list();
        }
    }
}();
