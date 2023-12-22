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
                                <div class="col-md-6">
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
                                <div class="col-md-8" id="add_asset_allocation_div">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label>Asset Name
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control select2 asset asset_select" id="asset"  name="asset_master_id[]">
                                                    <option value="">Please select asset Name</option>
                                                    @foreach ($asset_master  as $key => $value )
                                                        <option value="{{ $value['id'] }}">{{ $value['asset_code'] . " " . $value['asset_type'] }}</option>
                                                    @endforeach
                                                </select>
                                             <span class="asset_error text-danger"></span>
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
