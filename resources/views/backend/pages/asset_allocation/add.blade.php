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
                     <form class="form" id="add-asset-allocation" method="POST" action="{{ route('admin.asset-allocation.save-add-asset-allocation') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 employee_id" id="employee_id" name="employee_id">
                                            <option value="">Please select Employee Name</option>
                                            @foreach ($employee as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['first_name'] . " ". $value['last_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Branch Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 branch_id" id="branch_id" name="branch_id">
                                            <option value="">Please select Branch Name</option>
                                            @foreach (user_branch()  as $key => $value )
                                            <option value="{{ $value['id'] }}" {{  $_COOKIE['branch'] == $value['id'] ? 'selected="selected"' : '' }}>{{ $value['branch_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="add_asset_allocation_div">
                                <div class="row asset-list">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Asset
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 asset asset_select" id="asset_id"  name="asset_id[]" data-id="">
                                                <option value="">Please select asset</option>
                                                @foreach ($asset  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{$value['asset_type'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="asset_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Asset Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 asset asset_master_select" id="asset_master_id"  name="asset_master_id[]">
                                                <option value="">Please select asset code</option>
                                            </select>
                                            <span class="asset_master_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <a href="javascript:;" class="my-btn btn btn-success add-asset-allocation-button"><i class="my-btn fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
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
