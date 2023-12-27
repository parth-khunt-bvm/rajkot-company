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
                     <form class="form" id="edit-asset-allocation" method="POST" action="{{ route('admin.asset-allocation.save-edit-asset-allocation') }}">@csrf
                        <div class="card-body">
                            <input type="hidden" name="edit_id" class="form-control"  value="{{ $asset_master_details['id']}}">

                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Employee Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 employee_id" id="employee_id" name="employee_id">
                                            <option value="">Please select Employee Name</option>
                                            @foreach ($employee as $key => $value )
                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $asset_master_details['allocated_user_id'] ? 'selected="selected"' : '' }}> {{ $value['first_name'] . " ". $value['last_name'] }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
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
                                        <span class="asset_error text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Asset Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control onlyNumber" value="{{ $asset_master_details['asset_code'] }}" autocomplete="off" disabled>
                                        <span class="asset_error text-danger"></span>
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
