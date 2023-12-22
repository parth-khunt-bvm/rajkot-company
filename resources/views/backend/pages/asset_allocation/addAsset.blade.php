<div class="row remove-div">
    <div class="col-md-9">
        <div class="form-group">
            {{-- <label>Asset Name
                <span class="text-danger">*</span>
            </label> --}}
            <select class="form-control select2 asset asset_select" id="asset" name="asset_master_id[]">
                <option value="">Please select asset Name</option>
                @foreach ($assetMasterList  as $key => $value )
                    <option value="{{ $value['id'] }}">{{ $value['asset_code'] . " " . $value['asset_type'] }}</option>
                @endforeach
            </select>
         <span class="asset_error text-danger"></span>
        </div>
    </div>
    <div class="col-md-2 mt-0">
        <div class="form-group" style="margin-top: -26px ">
            <label>&nbsp;</label><br>
            <a href="javascript:;" class="my-btn btn btn-success add-asset-allocation-button"><i class="my-btn fa fa-plus"></i></a>
            <a href="javascript:;" class="my-btn btn btn-danger remove-asset-allocation ml-2"><i class="my-btn fa fa-minus"></i></a>
        </div>
    </div>
</div>
