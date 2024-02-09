var Supplier = function(){

    var list = function () {
        $('.select2').select2();
        var Priority = $('#priorityId').val();
        var status = $("#statusId").val();
        var dataArr = {  'Priority': Priority, 'status': status};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-supplier-list',
            'ajaxURL': baseurl + "admin/supplier/ajaxcall",
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
                url: baseurl + "admin/supplier/ajaxcall",
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
                url: baseurl + "admin/supplier/ajaxcall",
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
                url: baseurl + "admin/supplier/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function (data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", ".show-supplier-form", function() {
            $("#show-supplier-form").html('-').addClass('remove-supplier-form');
            $("#show-supplier-form").html('-').removeClass('show-supplier-form');
            $("#add-supplier").slideToggle("slow");
        })

        $("body").on("click", ".remove-supplier-form", function() {
            $("#show-supplier-form").html('+').removeClass('remove-supplier-form');
            $("#show-supplier-form").html('+').addClass('show-supplier-form');
            $("#add-supplier").slideToggle("slow");
        })

        $("body").on("click", "#show-supplier-filter", function() {
            $("div .supplier-filter").slideToggle("slow");
        })

        $("body").on("change", ".supplier-filter", function () {

            var target = [101,102,103,104];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html = '';
            html =  '<table class="table table-bordered table-checkable" id="admin-supplier-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Supplier Name</th>'+
            '<th>Shop Name</th>'+
            '<th>Shop Contact</th>'+
            '<th>Personal Contact </th>'+
            '<th>Priority </th>'+
            '<th>Short Name </th>'+
            '<th>Status</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html += '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".supplier-list").html(html);

            var Priority = $('#priorityId').val();
            var status = $("#statusId").val();
            var dataArr = {  'Priority': Priority, 'status': status};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-supplier-list',
                'ajaxURL': baseurl + "admin/supplier/ajaxcall",
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

        $("body").on('click','.supplier-view', function(){
            var id = $(this).data('id');
            console.log(id);
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/supplier/ajaxcall",
                data: { 'action': 'supplier-view', 'data': data },
                success: function (data) {
                   var supplier=  JSON.parse(data);
                   console.log(supplier);
                   $("#md_supplier_name").text(supplier.suppiler_name);
                   $("#md_shop_name").text(supplier.supplier_shop_name);
                   $("#md_shop_contact").text(supplier.shop_contact);
                   $("#md_personal_contact").text(supplier.personal_contact);

                   var priority;
                   if (supplier.priority === "0") {
                        priority = "Low";
                   } else if (supplier.priority === "1") {
                        priority = "Medium";
                   } else if (supplier.priority === "2") {
                        priority = "High";
                   }
                    $("#md_priority").text(priority);
                    $("#md_short_name").text(supplier.sort_name);

                    var status;
                    if(supplier.status == "A"){
                        status = "Active";
                    } else {
                        status = "DeActive";
                    }
                    $("#md_status").text(status);
                    $("#md_address").text(supplier.address);
                }
            });
        });
    }

    var addSupplier = function(){
        $('.select2').select2();
        var form = $('#add-supplier');
        var rules = {
            supplier_name: {required: true},
            shop_name: {required: true},
            personal_contact: {required: true},
            shop_contact: {required: true},
            address: {required: true},
            priority: {required: true},
            short_name: {required: true},
            status: {required: true},
        };
        var message = {
            supplier_name: {required: 'Please enter supplier name'},
            shop_name: {required: 'Please enter Shop name'},
            personal_contact: {required: 'Please enter personal contact'},
            shop_contact: {required: 'Please enter shop contact'},
            address: {required: 'Please enter address'},
            priority: {required: 'Please select priority'},
            short_name: {required: 'Please enter sort name'},
            status: {required: 'Please select supplier name status'},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    var editSupplier = function(){
        $('.select2').select2();
        var form = $('#edit-supplier');
        var rules = {
            supplier_name: {required: true},
            shop_name: {required: true},
            personal_contact: {required: true},
            shop_contact: {required: true},
            address: {required: true},
            priority: {required: true},
            status: {required: true},
        };
        var message = {
            supplier_name: {required: 'Please enter supplier name'},
            shop_name: {required: 'Please enter Shop name'},
            personal_contact: {required: 'Please enter personal contact'},
            shop_contact: {required: 'Please enter shop contact'},
            address: {required: 'Please enter address'},
            priority: {required: 'Please select priority'},
            status: {required: 'Please select supplier name status'},
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
            addSupplier();
        },
        edit:function(){
            editSupplier();
        },

    }
}();
