var AssetAllocation = function(){

    var addAssetAllocation = function(){


        var form = $('#add-asset-allocation');
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
        $('body').on('click', '.add-asset-allocation-button', function () {
            console.log("hiii");
            var selected = true;
            var assetMasterArray = [];
            $('.asset_select').each(function () {
                var elem = $(this);
                if (elem.is(':visible')) {
                    if (elem.val() == '' || elem.val() == null) {
                        elem.parent().find('.asset_error').text('Please Select Asset Name');
                        selected = false;
                    } else {
                        assetMasterArray.push(elem.val());
                        elem.parent().find('.asset_error').text('');
                    }
                }
            });

            if (selected) {
                var data = { assetMaster: JSON.stringify(assetMasterArray) };
                console.log("dddd",data);
                $.ajax({
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    },
                    url: baseurl + "admin/asset-allocation/ajaxcall",
                    data: { 'action': 'get_asset_master_list', 'data': data },
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
    }

    return {
        add:function(){
            addAssetAllocation();
        },
    }
}();
