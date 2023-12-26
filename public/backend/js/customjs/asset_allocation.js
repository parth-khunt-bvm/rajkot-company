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

            var selected = true;
            var assetMasterArray = [];
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
                        assetMasterArray.push(elem.val());
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

        $('body').on("change", ".asset_select", function () {
            var element = $(this);
            var id = $(this).val();
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
                data: { 'action': 'get_asset_list', 'id': id, 'selectedAsset': JSON.stringify(selectedAsset) },
                success: function (data) {
                    var res = JSON.parse(data);
                    var html = '';
                    html += '<option value="">Please select asset Name</option>';
                    for (var i = 0; i < res.length; i++) {
                        html += '<option value="'+ res[i].id +'">'+ res[i].asset_code +'</option>';
                    }
                    $(element).closest(".asset-list").find(".asset_master_select").html(html);
                    $('.select2').select2();
                }
            });
        });
    }

    return {
        add:function(){
            addAssetAllocation();
        },
    }
}();
