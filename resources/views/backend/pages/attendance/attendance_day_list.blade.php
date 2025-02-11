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
                                <input type="text" name="date" id="datepicker_date_fill" class="form-control change_date datepicker_date" value="{{ $date }}" placeholder="Enter Date" autocomplete="off">
                            </div>
                        </div>

                    <button class="btn btn-primary font-weight-bolder mr-5 mb-5 ml-5 show-emp-attendance-form" id="show-emp-attendance-form">+</button>

                </div>
            </div>
            <div class="card-body">

                <form class="form" id="add-emp-attendance-form" style="display: none;"  method="POST" action="{{ route('admin.emp-attendance.save-add-attendance') }}">@csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="text" name="date" id="datepicker_date_input" class="form-control date datepicker_date" value="{{ $date }}" placeholder="Select Date" value="" autocomplete="off">
                                </div>
                            </div>
                        </div>

                        <div id="add_attendance_div">
                            <div class="row">
                                <div class="col-md-2">
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
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Leave Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 leave_type leave_select"  name="leave_type[]" id="leave_type">
                                            <option value="">Please select Leave Type</option>
                                            <option value="0">Present</option>
                                            <option value="1">Full Day Leave</option>
                                            <option value="2">Half Day Leave</option>
                                            <option value="3">Short Leave</option>
                                        </select>
                                        <span class="leave_error text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Minute (1 hour = 60 min)
                                        </label>
                                        <input type="number" name="minutes[]" id="minutes" class="form-control minutes" placeholder="Enter minutes" value="" autocomplete="off">
                                        <span class="minute_error text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Reason
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
                                <th>Minutes</th>
                                <th>Reason</th>
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

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Employee Time Tracking </h3>
                 </div>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">

                <div class="emp-time-tracking-list">
                    <table class="table table-bordered table-checkable" id="emp-time-tracking-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>In Time</th>
                                <th>Out Time</th>
                                <th>Working Time</th>
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

        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">Employee Overtime </h3>
                 </div>
                <div class="card-toolbar">
                </div>
            </div>
            <div class="card-body">

                <div class="emp-overtime-day-list">
                    <table class="table table-bordered table-checkable" id="emp-overtime-day-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Hours</th>
                                <th>Note</th>
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
