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
                     <form class="form" id="add-attendance-form" method="POST" action="{{ route('admin.attendance.save-add-attendance') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Select Date" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-4 col-form-label mt-5">
                                    <div class="checkbox-inline mt-3">
                                        <label class="checkbox checkbox-success">
                                            <input type="checkbox" id="all_present" name="all_present"/>
                                            <span></span>
                                            All Present
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div id="add_attendance_div">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Employee Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 employee_id employee_select"  name="employee_id[]">
                                                <option value="">Please select Employee Name</option>
                                                @foreach ($employee as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['first_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="attendance_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Leave Type
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 leave_type leave_select"  name="leave_type[]" id="leave_type">
                                                <option value="">Please select Leave Type</option>
                                                <option value="1">Full Day Leave</option>
                                                <option value="2">Half Day Leave</option>
                                                <option value="3">Sort Leave</option>
                                            </select>
                                            <span class="leave_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Reson
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="1" name="reason[]" id="reason"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-2 padding-left-5 padding-right-5">
                                        <div class="form-group">
                                            <label>&nbsp;</label><br>
                                            <a href="javascript:;" class="my-btn btn btn-success add-attendance-button"><i class="my-btn fa fa-plus"></i></a>
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
