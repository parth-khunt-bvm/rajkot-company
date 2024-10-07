var AssetMaster = function(){
    var list= function(){

        var supplier = $("#asset_supplier_id").val();
        var asset = $("#asset_id").val();
        var brand = $("#brand_id").val();
        var branch = $("#branch_id").val();
        var dataArr = {  'supplier': supplier, 'asset': asset, 'brand': brand, 'branch': branch};

        
        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-asset-master-list',
            'ajaxURL': baseurl + "admin/asset-master/ajaxcall",
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
                url: baseurl + "admin/asset-master/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });


        $("body").on("change", ".asset_filter_master", function () {

            var supplier = $("#asset_supplier_id").val();
            var asset = $("#asset_id").val();
            var brand = $("#brand_id").val();
            var branch = $("#branch_id").val();
            var dataArr = {  'supplier': supplier, 'asset': asset, 'brand': brand, 'branch': branch};

            var target = [101,102,103,104];
            const permissionArray = permission.split(",").map(numString => +numString);
            const intersection = permissionArray.filter(value => target.includes(value));
            var html = '';
            html = '<table class="table table-bordered table-checkable" id="admin-asset-master-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Asset Code</th>'+
            '<th>Suplier Name</th>'+
            '<th>Asset Name</th>'+
            '<th>Branch Name</th>'+
            '<th>Brand Name</th>'+
            '<th>Price</th>'+
            '<th>status</th>'+
            '<th>Description</th>';
            if (isAdmin == 'Y' || intersection.length > 0 ) {
                html += '<th>Action</th>';
            }
            html += '</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';
            $(".asset-master-list").html(html);

            var supplier = $("#asset_supplier_id").val();
            var asset = $("#asset_id").val();
            var brand = $("#brand_id").val();
            var branch = $("#branch_id").val();
            var dataArr = {  'supplier': supplier, 'asset': asset, 'brand': brand, 'branch': branch};

            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-asset-master-list',
                'ajaxURL': baseurl + "admin/asset-master/ajaxcall",
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

        $("body").on("click", ".reset", function(){
            location.reload(true);
        });

        $("body").on("click", ".show-assets-master-form", function() {
            $("#show-assets-master-form").html('-').addClass('remove-assets-master-form');
            $("#show-assets-master-form").html('-').removeClass('show-assets-master-form');
            $("#add-asset-master-users").slideToggle("slow");

        })

        $("body").on("click", ".remove-assets-master-form", function() {
            $("#show-assets-master-form").html('+').removeClass('remove-assets-master-form');
            $("#show-assets-master-form").html('+').addClass('show-assets-master-form');
            $("#add-asset-master-users").slideToggle("slow");

        })

        $("body").on("click", "#show-assets-master-filter", function() {
            $("div .asset-master-filter").slideToggle("slow");
        })

        $("body").on('click','.asset-master-view', function(){
            var id = $(this).data('id');
            console.log(id);
            var data = { 'id': id, _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url: baseurl + "admin/asset-master/ajaxcall",
                data: { 'action': 'asset-master-view', 'data': data },
                success: function (data) {
                   var assetMaster=  JSON.parse(data);
                   console.log(assetMaster);

                   $("#as_supplier_name").text(assetMaster.suppiler_name);
                   $("#as_asset_name").text(assetMaster.asset_type);
                   $("#as_branch_name").text(assetMaster.branch_name);
                   $("#as_brand_name").text(assetMaster.brand_name);
                   $("#as_price").text(Number.parseFloat(assetMaster.price).toFixed(2));

                   var status;
                   if (assetMaster.status === "1") {
                        status = "Working";
                   } else if (assetMaster.status === "2") {
                        status = "Need To Service";
                   } else if (assetMaster.status === "3") {
                        status = "Not Working";
                   }
                   $("#as_status").text(status);
                   $("#as_description").text(assetMaster.description);

                    var $allocationList = $("#allocation_history"); // Assuming you have a <ul> with id "allocation_history"
                    $allocationList.empty(); // Clear any previous list items
                    
                    // Assuming assetMaster.allocationData contains the concatenated string like "employeeId|fullName|allocationDate"
                    var allocationData = assetMaster.allocationData || ""; // Fallback to empty string if allocationData is undefined
                    var allocations = allocationData.split(","); // Split the allocations by comma
                    
                    // Check if allocations have any entries
                    if (allocations.length > 0 && allocations[0] !== "" && allocations[0] !== "0|0") {
                        allocations.forEach((allocation, i) => {
                            var parts = allocation.split("|");
                            var employeeId = parts[0] || '0';
                            var fullName = parts[1] || 'Not Allocated';
                            var allocationDate = parts[2] || '';

                            if (employeeId === '0') {
                                fullName = '<b>Not Allocated</b>';
                            }

                            var listItem = $("<li></li>").html(i == 0 
                                ? `<span class="label label-lg label-light-success label-inline">Now</span> - ${fullName}` 
                                : `${humanReadableDateTime(allocationDate)} - ${fullName}`);
                    
                            $allocationList.append(listItem);
                        });
                    } else {
                        $allocationList.text('-');
                    }
                }
            });
        });
    }

    var trashList= function(){

        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-asset-master-trash-list',
            'ajaxURL': baseurl + "admin/asset-master/ajaxcall",
            'ajaxAction': 'get-asset-master-trash',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };

        getDataTable(arrList);

        $("body").on("click", ".restore-records", function() {
            var id = $(this).data('id');
            setTimeout(function() {
                $('.yes-sure:visible').attr('data-id', id);
            }, 500);
        });

        $('body').on('click', '.yes-sure', function() {
            var id = $(this).attr('data-id');
            var data = { id: id, 'activity': 'restore-records', _token: $('#_token').val() };
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                },
                url:baseurl + "admin/asset-master/ajaxcall",
                data: { 'action': 'common-activity', 'data': data },
                success: function(data) {
                    $("#loader").show();
                    handleAjaxResponse(data);
                }
            });
        });
    }
    var addAssetMaster= function(){
        $('.select2').select2();

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var form = $('#add-asset-master-users');
        var rules = {
            supplier_id: {required: true},
            asset_id: {required: true},
            brand_id: {required: true},
            branch_id: {required: true},
            // description: {required: true},
            quantity: {required: true},
            // price: {required: true},
            price: {
                validateMaxValue: true,
            },
            // purchase_date: {required: true},
            // warranty_guarantee: {required: true},
            // agreement: {required: true},
            status: {required: true},

        };
        var message = {
            supplier_id :{
                required : "Please select Suplier name",
            },
            branch_id : {
                required : "Please select branch name"
            },
            asset_id : {
                required : "Please select asset name"
            },
            brand_id : {
                required : "Please select Brand name"
            },
            quantity : {
                required : "Please enter quantity"
            },
            // price : {
            //     required : "Please enter price"
            // },
            // description : {
            //     required : "Please Enter Description"
            // },
            // purchase_date : {
            //     required : "Please select Purchase Date"
            // },
            // warranty_guarantee : {
            //     required : "Please enter Warranty/Guarantee"
            // },
            // agreement : {
            //     required : "Please select Agreement"
            // },
            status : {
                required : "Please select status"
            },

        }
        handleFormValidateWithMsg(form, rules, message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    var editAssetMaster= function(){
        $('.select2').select2();

        $("#datepicker_date").datepicker({
            format: 'd-M-yyyy',
            todayHighlight: true,
            autoclose: true,
            orientation: "bottom auto"
        });
        var form = $('#edit-asset-master-users');

        $.validator.addMethod("validateMaxValue", function(value, element) {
            return parseFloat(value.replace(/,/g, '')) <= 999999999999.9999;
        }, "Please enter a valid amount");

        var rules = {
            supplier_id: {required: true},
            asset_id: {required: true},
            brand_id: {required: true},
            branch_id: {required: true},
            // description: {required: true},
            // price: {required: true},
            price: {
                validateMaxValue: true,
            },
            // purchase_date: {required: true},
            // warranty_guarantee: {required: true},
            // agreement: {required: true},
            status: {required: true},

        };
        var message = {
            supplier_id :{
                required : "Please select Suplier name",
            },
            branch_id : {
                required : "Please select branch name"
            },
            asset_id : {
                required : "Please select asset name"
            },
            brand_id : {
                required : "Please select Brand name"
            },
            // price : {
            //     required : "Please enter price"
            // },
            // description : {
            //     required : "Please Enter Description"
            // },
            // purchase_date : {
            //     required : "Please select Purchase Date"
            // },
            // warranty_guarantee : {
            //     required : "Please enter Warranty/Guarantee"
            // },
            // agreement : {
            //     required : "Please select Agreement"
            // },
            status : {
                required : "Please select status"
            },

        }
        handleFormValidateWithMsg(form, rules, message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }

    return {
        init:function(){
            list();
        },
        add:function(){
            addAssetMaster();
        },
        edit:function(){
            editAssetMaster();
        },
        trash_init:function(){
            trashList();
        }
    }
}();



