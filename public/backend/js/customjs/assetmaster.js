var AssetMaster = function(){
    var list= function(){
        var suplier = $('#supplier_id').val();
        var branch = $("#branch_id").val();
        var asset = $("#asset").val();
        var brand = $("#brand").val();
        var status = $("#status").val();
        var price = $("#price").val();
        var description = $("#description").val();

        var dataArr = { 'suplier': suplier, 'branch':branch, 'asset':asset, 'brand':brand ,'status':status,'price':price,'description':description};

        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#admin-asset-master-list',
            'ajaxURL': baseurl + "admin.asset-master.ajaxcall",
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


        $("body").on("change", ".change", function() {
            var target = [111, 112,113,114,115,116];
            const permissionValues = permission.length > 0 ? permission.split(",") : [];
            const intersectCount = permissionValues.filter(value => target.includes(value.trim())).length;
            var html = '';
            html ='<table class="table table-bordered table-checkable" id="admin-asset-master-list">'+
            '<thead>'+
            '<tr>'+
            '<th>#</th>'+
            '<th>Suplier Name</th>'+
            '<th>Asset Name</th>'+
            '<th>Branch Name</th>'+
            '<th>Brand Name</th>'+
            '<th>Description</th>'+
            '<th>status</th>'+
            '<th>Price</th>';
            if (isAdmin == 'Y' || intersectCount > 0 ) {
                html += '<th>Action</th>';
            }
            html +='</tr>'+
            '</thead>'+
            '<tbody>'+
            '</tbody>'+
            '</table>';
            $(".asset-master-list").html(html);

            var suplier = $('#supplier_id').val();
            var branch = $("#branch_id").val();
            var asset = $("#asset").val();
            var brand = $("#brand").val();
            var status = $("#status").val();
            var price = $("#price").val();
            var description = $("#description").val();

            var dataArr = { 'suplier': suplier, 'branch':branch, 'asset':asset, 'brand':brand ,'status':status,'price':price,'description':description};
            var columnWidth = { "width": "5%", "targets": 0 };
            var arrList = {
                'tableID': '#admin-asset-master-list',
                'ajaxURL': baseurl + "admin.asset-master.ajaxcall",
                'ajaxAction': 'getdatatable',
                'postData': dataArr,
                'hideColumnList': [],
                'noSortingApply': [0, 0],
                'noSearchApply': [0, 0],
                'defaultSortColumn': [4],
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
            $("div .assets-master-filter").slideToggle("slow");
        })
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
                required : "Please Brand name"
            },
            description : {
                required : "Please Enter Description"
            },
            status : {
                required : "Please add Status"
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

    }
}();



