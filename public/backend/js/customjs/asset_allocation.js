var AssetAllocation = function(){

    var list = function(){
        employee = $("#fil_employee_id").val();
        supplier = $("#fil_supplier_id").val();
        brand = $("#fil_brand_id").val();
        asset = $("#fil_asset_id").val();

        var dataArr = { 'supplier': supplier, 'brand': brand, 'asset': asset , 'employee': employee };
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#asset-allocation-list',
            'ajaxURL': baseurl + "admin/asset-allocation/ajaxcall",
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
                url: baseurl + "admin/asset-allocation/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });

        $("body").on("click", "#show-asset-allocation-filter", function() {
            $("div .asset-allocation-filter").slideToggle("slow");
        })

        $("body").on("change", ".change", function () {

            var target = [118, 119];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="asset-allocation-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Employee Name</th>'+
            '<th>Supplier Name</th>'+
            '<th>Brand</th>'+
            '<th>Asset</th>'+
            '<th>Asset Code</th>';
            if (isAdmin == 'Y' || intersectCount > 0 ) {
                html += '<th>Action</th>';
            }
            html += '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';

            $(".asset-allocation-list-div").html(html);

            employee = $("#fil_employee_id").val();
            supplier = $("#fil_supplier_id").val();
            brand = $("#fil_brand_id").val();
            asset = $("#fil_asset_id").val();

            var dataArr = { 'supplier': supplier, 'brand': brand, 'asset': asset , 'employee': employee };
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#asset-allocation-list',
                'ajaxURL': baseurl + "admin/asset-allocation/ajaxcall",
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
    }

    var addAssetAllocation = function(){

        var form = $('#add-asset-allocation');
        var rules = {
            employee_id : {required: true},
            branch_id : {required: true},
        };

        var message = {
            employee_id : {required: "Please select employee name"},
            branch_id : {required: "Please select branch name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });


        $('.select2').select2();

        $('body').on('click', '.add-asset-allocation-button', function () {
            var selected = true;
            var assetArray = [];
            $('.asset_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.asset_error').text('Please Select Asset code');
                        selected = false;
                    } else {
                        assetArray.push(elem.val());
                        elem.parent().find('.asset_error').text('');
                    }
                }
            });


            $('.asset_master_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.asset_master_error').text('Please Select Asset Name');
                        selected = false;
                    } else {
                        elem.parent().find('.asset_master_error').text('');
                    }
                }
            });

            if (selected) {
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/asset-allocation/ajaxcall",
                    data: { 'action': 'get_asset_master_list' },
                    success: function (data) {
                        $("#add_asset_allocation_div").append(data)
                        $('.select2').select2();
                    }
                });
            }
        });

        $('body').on("click", ".remove-asset-allocation", function () {
            $(this).closest('.remove-div').remove();
        });

        $('body').on('change', '.branch_id', function(){
            var branchId = $(this).val();
            var selectedAsset= [];
            if(branchId != '' && branchId != null){
                $('.asset_select').each(function () {
                    var elem = $(this);
                    if (elem.is(':visible')) {
                        var assetListDiv = elem.closest('.asset-list');
                        var assetTypeVal = elem.val();
                        if(assetTypeVal != '' && assetTypeVal != null){
                            $('.asset_master_select').each(function () {
                                var elem = $(this);
                                if (elem.is(':visible')) {
                                    if (elem.val() != '' || elem.val() != null) {
                                        selectedAsset.push(elem.val());
                                    }
                                }
                            });

                            $.ajax({
                                type: "POST",
                                headers: {
                                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                                },
                                url: baseurl + "admin/asset-allocation/ajaxcall",
                                data: { 'action': 'get_asset_list', 'selectedAsset': JSON.stringify(selectedAsset),'branchId': branchId,'assetTypeVal': assetTypeVal, },
                                success: function (data) {
                                    var res = JSON.parse(data);
                                    var html = '';
                                    html += '<option value="">Please select asset code</option>';
                                    for (var i = 0; i < res.length; i++) {
                                        html += '<option value="'+ res[i].id +'">'+ res[i].asset_code +'</option>';
                                    }
                                    $(elem).closest(".asset-list").find(".asset_master_select").html(html);
                                    $('.select2').select2();
                                }
                            });
                        }else{
                            var html = '';
                            html += '<option value="">Please select asset code</option>';
                            $(elem).closest(".asset-list").find(".asset_master_select").html(html);
                            $('.select2').select2();
                        }
                    }
                });
            }else {
                var html = '';
                html += '<option value="">Please select asset code</option>';
                $(".asset_master_select").html(html);
                $('.select2').select2();
            }
        });
        $('body').on('change', '.asset_select', function(){
            var elem = $(this);
            var assetTypeVal = $(this).val();
            var branchId = $("#branch_id").val();
            if(assetTypeVal != ''  && assetTypeVal != null && branch_id != ''  && branch_id != null){
                var selectedAsset= [];
                $('.asset_master_select').each(function () {
                    var elem = $(this);
                    if (elem.is(':visible')) {
                        if (elem.val() != '' || elem.val() != null) {
                            selectedAsset.push(elem.val());
                        }
                    }
                });

                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/asset-allocation/ajaxcall",
                    data: { 'action': 'get_asset_list', 'selectedAsset': JSON.stringify(selectedAsset),'branchId': branchId,'assetTypeVal': assetTypeVal, },
                    success: function (data) {
                        var res = JSON.parse(data);
                        var html = '';
                        html += '<option value="">Please select asset code</option>';
                        for (var i = 0; i < res.length; i++) {
                            html += '<option value="'+ res[i].id +'">'+ res[i].asset_code +'</option>';
                        }
                        $(elem).closest(".asset-list").find(".asset_master_select").html(html);
                        $('.select2').select2();
                    }
                });

            }else{
                var html = '';
                html += '<option value="">Please select asset code</option>';
                $(elem).closest(".asset-list").find(".asset_master_select").html(html);
                $('.select2').select2();
            }
        });
    }

    var editAssetAllocation = function(){

        var form = $('#edit-asset-allocation');
        var rules = {
            employee_id : {required: true},
        };

        var message = {
            employee_id : {required: "Please select employee name"},
        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });

        $('.select2').select2();

    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addAssetAllocation();
        },
        edit:function(){
            editAssetAllocation();
        },
    }
}();
