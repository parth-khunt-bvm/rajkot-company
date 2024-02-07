@extends('backend.layout.app')
@section('section')

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        @csrf
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">{{ $header['title'] }}</h3>
                 </div>
                <div class="card-toolbar">

                        <div class="form-group row">
                            <label class="mt-5">
                                Date
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-10 mt-3">
                                <input type="text" name="date" id="datepicker_date" class="form-control change_date datepicker_date" value="{{ $date }}" placeholder="Enter Date" autocomplete="off">
                            </div>
                        </div>

                    <button class="btn btn-primary font-weight-bolder mr-5 mb-5 ml-5 show-attendance-form" id="show-branch-form">+</button>

                </div>
            </div>
            <div class="card-body">

                <form class="form" id="add-attendance-form" style="display: block"  method="POST" action="{{ route('admin.emp-attendance.save-add-attendance') }}">@csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" id="datepicker_date" class="form-control date datepicker_date" value="{{ $date }}" placeholder="Select Date" value="" autocomplete="off">
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
                                            <option value="{{ $value['id'] }}">{{ $value['first_name']. " " . $value['last_name'] }}</option>
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
                                            <option value="0">Present</option>
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

                        <div class="col-md-5  mb-5">
                            <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                            <button type="reset" class="btn btn-secondary">Cancel</button>
                        </div>
                </form>

                <div class="attendance-list">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="attendance-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Attendance Type</th>
                            <th>reason</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--end: Datatable-->
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
