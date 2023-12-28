<div class="row asset-list remove-div">
    <div class="col-md-5">
        <div class="form-group">
            <label>Asset
                <span class="text-danger">*</span>
            </label>
            <select class="form-control select2 asset asset_select" id="asset_id"  name="asset_id[]" data-id="">
                <option value="">Please select asset</option>
                @foreach ($assetList  as $key => $value )
                    <option value="{{ $value['id'] }}">{{$value['asset_type'] }}</option>
                @endforeach
            </select>
            <span class="asset_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>Asset Name
                <span class="text-danger">*</span>
            </label>
            <select class="form-control select2 asset asset_master_select" id="asset_master_id"  name="asset_master_id[]">
                <option value="">Please select asset Name</option>
            </select>
            <span class="asset_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>&nbsp;</label><br>
            <a href="javascript:;" class="my-btn btn btn-success add-asset-allocation-button"><i class="my-btn fa fa-plus"></i></a>
            <a href="javascript:;" class="my-btn btn btn-danger remove-asset-allocation ml-2"><i class="my-btn fa fa-minus"></i></a>
        </div>
    </div>
</div>
