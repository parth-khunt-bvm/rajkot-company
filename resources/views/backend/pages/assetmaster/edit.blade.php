@extends('backend.layout.app')
@section('section')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">{{ $header['title'] }}</h3>
                        </div>
                        <!--begin::Form-->
                        <form class="form" id="edit-asset-master-users" method="POST" action="{{ route('admin.asset-master.save-edit-asset-master') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Supplier Name
                                                <span class="text-danger">*</span>
                                            </label>
                                           <input type="hidden" name="edit_id" class="form-control"  value="{{ $asset_master_details['id']}}">
                                            <select  class="form-control select2 supplier_id" id="supplier_id"  name="supplier_id">
                                                <option value="">Please select Supplier Name</option>
                                                @foreach ($suppier  as $key => $value )
                                                @if ($value['priority'] == '2')
                                                        <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['supplier_id'] ? 'selected="selected"' : '' }}>{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "High"}}</option>
                                                @elseif ($value['priority'] == '1')
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['supplier_id'] ? 'selected="selected"' : '' }}>{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "Medium"}}</option>
                                                @elseif ($value['priority'] == '0')
                                                        <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['supplier_id'] ? 'selected="selected"' : '' }}>{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "Low"}}</option>
                                                @else
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['supplier_id'] ? 'selected="selected"' : '' }}>{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "Unknown Priority"}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">

                                        <div class="form-group">
                                            <label>Asset Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 asset" id="asset"  name="asset_id" disabled="disabled">
                                                <option value="">Please select asset Name</option>
                                                @foreach ($asset  as $key => $value )
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['asset_id'] ? 'selected="selected"' : '' }}>{{ $value['asset_type'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Brand Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 brand-class" id="brand"  name="brand_id">
                                                <option value="">Please select Brand Name</option>
                                                @foreach ($brand  as $key => $value )
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['brand_id'] ? 'selected="selected"' : '' }}>{{ $value['brand_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Branch Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 branch" id="branch"  name="branch_id">
                                                <option value="">Please select Branch Name</option>
                                                @foreach (user_branch() as $key => $value )
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['branch_id'] ? 'selected="selected"' : '' }}>{{ $value['branch_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Price
                                            </label>
                                            <input type="text" id="price" name="price" class="form-control onlyNumber" placeholder="Enter price" value="{{ $asset_master_details['price'] }}" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 status" id="status"  name="status">
                                                <option value="">Asset Status</option>
                                                <option value="1" {{ $asset_master_details->status == 1 ? 'selected="selected"' : '' }}>Working</option>
                                                <option value="2" {{ $asset_master_details->status == 2 ? 'selected="selected"' : '' }}>Need To Service</option>
                                                <option value="3" {{ $asset_master_details->status == 3 ? 'selected="selected"' : '' }}>Not Working</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Purchase Date</label>
                                            <input type="text" name="purchase_date" value="{{ $asset_master_details->purchase_date != null ? date_formate($asset_master_details->purchase_date) : null }}" id="datepicker_date" class="form-control date" placeholder="Enter Purchase Date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Warranty/Guarantee (in year)</label>
                                            <input type="number" id="warranty_guarantee" name="warranty_guarantee" value="{{ $asset_master_details->warranty_guarantee }}" class="form-control onlyNumber" placeholder="Enter Warranty/Guarantee" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Agreement</label>
                                            <div class="radio-inline" style="margin-top:10px">
                                                <label class="radio radio-lg radio-success">
                                                    <input type="radio" name="agreement" class="radio-btn" value="W" {{ $asset_master_details->agreement == 'W' ? 'checked="checked"' : '' }}/>
                                                    <span></span>In Warranty
                                                </label>
                                                <label class="radio radio-lg radio-success">
                                                    <input type="radio" name="agreement" class="radio-btn" value="G" {{ $asset_master_details->agreement == 'G' ? 'checked="checked"' : '' }}/>
                                                    <span></span>In Guarantee
                                                </label>
                                                <label class="radio radio-lg radio-success">
                                                    <input type="radio" name="agreement" class="radio-btn" value="N" {{ $asset_master_details->agreement == 'N' ? 'checked="checked"' : '' }}/>
                                                    <span></span>None
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Description
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="1" name="description" id="description">{{ $asset_master_details->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a href="{{route('admin.assets-master.list')}}">Cancel</a></button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->

                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
