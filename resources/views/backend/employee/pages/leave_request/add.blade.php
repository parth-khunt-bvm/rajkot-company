@extends('backend.employee.layout.app')
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
                    <form class="form" id="add-leave-request" method="POST" action="{{ route('leave-request.store') }}">@csrf
                        <div class="card-body add-leave-body">
                            <div class="row">
                                <div class="col-md-2 leaveDate">
                                    <div class="form-group">
                                        <label>Leave Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="date[]" class="form-control date datepicker_start_date" max="{{ date('Y-m-d') }}" placeholder="Select Date" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 leave-type-container">
                                    <div class="form-group leave-type-group">
                                        <label>Leave Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 leave_type leave_select" name="leave_type[]" id="leave_type">
                                            <option value="">Please select Leave Type</option>
                                            <option value="1">Full Day Leave</option>
                                            <option value="2">Half Day Leave</option>
                                            <option value="3">Short Leave</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Manager
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 manager input-name" id="manager" name="manager[]">
                                            <option value="">Please select Manager Name</option>
                                            @foreach ($manager as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Reason
                                        </label>
                                        <textarea class="form-control" id="" cols="40" rows="1" name="reason" id="reason[]"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-center">
                                    <button class="btn btn-primary font-weight-bolder add-leave" id="">+</button>
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
