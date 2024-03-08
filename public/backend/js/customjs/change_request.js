var ChangeRequest = function(){
    var list = function(){
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


        $("body").on('click','.change-request-view', function(){
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
                    var html = '';
                    var details = JSON.parse(data);
                    console.log("details",details);

                    $.each(details, function( index, value ) {
                        var temp = '';
                        temp  = index + " : " + value + "<br>";
                        html = html + temp;
                    });
                    $("#change-request-view-data").html(html);

                }
            });
        });

    }
    return {
        init:function(){
            list();
        },

    }
}();
