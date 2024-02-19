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
                    <form class="form" method="POST" id="edit-leave-request" action="{{ route('leave-request.update', $Leave_request_details->id ) }}">@csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="hidden" name="leave_req_Id"  value="{{ $Leave_request_details->id}}">
                                        <input type="text" name="date" id="datepicker_date" class="form-control date" max="{{ date('Y-m-d') }}" placeholder="Select Date" value="{{ date_formate($Leave_request_details->date) }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Leave Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 leave_type leave_select" name="leave_type" id="leave_type">
                                            <option value="">Please select Leave Type</option>
                                            <option value="1" {{ $Leave_request_details->leave_type == 1 ? 'selected="selected"' : '' }}>Full Day Leave</option>
                                            <option value="2" {{ $Leave_request_details->leave_type == 2 ? 'selected="selected"' : '' }}>Half Day Leave</option>
                                            <option value="3" {{ $Leave_request_details->leave_type == 3 ? 'selected="selected"' : '' }}>Short Leave</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Manager
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 manager input-name" id="manager" name="manager">
                                            <option value="">Please select Manager Name</option>
                                            @foreach ($manager as $key => $value )
                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $Leave_request_details->manager_id ? 'selected="selected"' : '' }}>{{ $value['manager_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Reson
                                        </label>
                                        <textarea class="form-control" id="" cols="40" rows="1" name="reason" id="reason">{{ $Leave_request_details->reason }}</textarea>
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
