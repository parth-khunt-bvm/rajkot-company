var EmployeeOverTimeDay = function () {

    var list = function(){
        var date = $('.change_date').val();
        var dataArr = { 'date': date };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#emp-overtime-day-list',
            'ajaxURL': baseurl + "admin/emp-overtime/ajaxcall",
            'ajaxAction': 'get-emp-overtime-detail',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);

        $("body").on('click','.emp-overtime-view', function(){
            var id = $(this).data('id');
            console.log(id);
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/emp-overtime/ajaxcall",
                data: { 'action': 'emp-overtime-view', 'data': data },
                success: function (data) {
                   var empOvertime=  JSON.parse(data);
                   console.log(empOvertime);

                   function formatDate(inputDate) {
                    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    const day = inputDate.getDate();
                    const month = months[inputDate.getMonth()];
                    const year = inputDate.getFullYear();
                    return `${day}-${month}-${year}`;
                  }

                  const inputDate = new Date(empOvertime.date);
                  const formattedDate = formatDate(inputDate);

                   $("#overtime_date").text(formattedDate);
                   $("#overtime_employee").text(empOvertime.first_name +' '+ empOvertime.last_name);
                   $("#overtime_hours").text(Number.parseFloat(empOvertime.hours).toFixed(2));
                   $("#overtime_note").text(empOvertime.note ?? "-");
                }
            });
        });
    }

    return {
        init: function () {
            list();
        },
    }
}();
