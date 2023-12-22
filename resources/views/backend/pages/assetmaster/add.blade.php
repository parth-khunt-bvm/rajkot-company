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
                        <form class="form" id="add-asset-master-users" method="POST" action="{{ route('admin.asset-master.save-add-asset-master') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Suplier Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 supplier_id" id="supplier_id"  name="supplier_id">
                                                <option value="">Please select Suplier Name</option>
                                                @foreach ($suppier  as $key => $value )
                                                @if ($value['priority'] == '2')
                                                        <option value="{{ $value['id'] }}">{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "High"}}</option>
                                                @elseif ($value['priority'] == '1')
                                                    <option value="{{ $value['id'] }}">{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "Medium"}}</option>
                                                @elseif ($value['priority'] == '0')
                                                        <option value="{{ $value['id'] }}">{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "Low"}}</option>
                                                @else
                                                    <option value="{{ $value['id'] }}">{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] .' - '. "Unknown Priority"}}</option>
                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Asset Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 asset" id="asset"  name="asset_id">
                                                <option value="">Please select asset Name</option>
                                                @foreach ($asset  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['asset_type'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Brand Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 brand-class" id="brand"  name="brand_id">
                                                <option value="">Please select Brand Name</option>
                                                @foreach ($brand  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['brand_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Branch Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 branch" id="branch"  name="branch_id">
                                                <option value="">Please select Branch Name</option>
                                                @foreach ($branch  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
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
                                            <input type="text" id="price" name="price" class="form-control onlyNumber" placeholder="Enter price" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Quantity
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" id="quantity" name="quantity" class="form-control onlyNumber" placeholder="Enter quantity" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 status" id="status"  name="status">
                                                <option value="">Asset Status</option>
                                                <option value="1">Working</option>
                                                <option value="2">Need To Service</option>
                                                <option value="3">Not Working</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="10" name="description" id="description"></textarea>
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
