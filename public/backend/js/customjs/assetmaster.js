var AssetMaster = function(){
    var list= function(){

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
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
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
            if (isAdmin == 'Y' || intersectCount > 0 ) {
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
                }
            });
        });
    }
    var addAssetMaster= function(){
        $('.select2').select2();
        var form = $('#add-asset-master-users');
        var rules = {
            supplier_id: {required: true},
            asset_id: {required: true},
            brand_id: {required: true},
            branch_id: {required: true},
            description: {required: true},
            quantity: {required: true},
            // price: {required: true},
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
            description : {
                required : "Please Enter Description"
            },
            status : {
                required : "Please select status"
            },

        }
        handleFormValidateWithMsg(form, rules,message, function(form) {
            handleAjaxFormSubmit(form,true);
        });
    }
    var editAssetMaster= function(){
        $('.select2').select2();
        var form = $('#edit-asset-master-users');
        var rules = {
            supplier_id: {required: true},
            asset_id: {required: true},
            brand_id: {required: true},
            branch_id: {required: true},
            description: {required: true},
            // price: {required: true},
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
            description : {
                required : "Please Enter Description"
            },
            status : {
                required : "Please select status"
            },

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
            addAssetMaster();
        },
        edit:function(){
            editAssetMaster();
        },

    }
}();



