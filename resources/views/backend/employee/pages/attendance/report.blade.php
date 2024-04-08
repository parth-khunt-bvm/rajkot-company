@extends('backend.employee.layout.app')
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
                        {{-- <div class="form-group row">
                            <label class="mt-5">
                                Date
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-10 mt-3">
                                <input type="text" name="date" id="datepicker_date_fill" class="form-control change_date datepicker_date" value="{{ $date }}" placeholder="Enter Date" autocomplete="off">
                            </div>
                        </div> --}}
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label> Month</label>
                            <select class="form-control select2 month att-report-fill" id="reportMonthId"  name="month">
                                <option value="">Select Month</option>
                                <option value="1" {{  date('n') == 1 ? 'selected="selected"' : '' }} >January</option>
                                <option value="2" {{  date('n') == 2 ? 'selected="selected"' : '' }} >February</option>
                                <option value="3" {{  date('n') == 3 ? 'selected="selected"' : '' }} >March</option>
                                <option value="4" {{  date('n') == 4 ? 'selected="selected"' : '' }} >April</option>
                                <option value="5" {{  date('n') == 5 ? 'selected="selected"' : '' }} >May</option>
                                <option value="6" {{  date('n') == 6 ? 'selected="selected"' : '' }} >June</option>
                                <option value="7" {{  date('n') == 7 ? 'selected="selected"' : '' }} >July</option>
                                <option value="8" {{  date('n') == 8 ? 'selected="selected"' : '' }} >August</option>
                                <option value="9" {{  date('n') == 9 ? 'selected="selected"' : '' }} >September</option>
                                <option value="10" {{  date('n') == 10 ? 'selected="selected"' : '' }} >October</option>
                                <option value="11" {{  date('n') == 11 ? 'selected="selected"' : '' }} >November</option>
                                <option value="12" {{  date('n') == 12 ? 'selected="selected"' : '' }} >December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>year</label>
                            <select class="form-control select2 year att-report-fill" id="reportYearId"  name="year">
                                <option value="">Select Year</option>
                                @for ($i = 2019; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Leave Type</label>
                            <select class="form-control select2 leave_type leave_select att-report-fill"  name="leave_type" id="reportLeaveType">
                                <option value="">Please select Leave Type</option>
                                <option value="0">Present</option>
                                <option value="1">Full Day Leave</option>
                                <option value="2">Half Day Leave</option>
                                <option value="3">Short Leave</option>
                            </select>
                            <span class="leave_error text-danger"></span>
                        </div>
                    </div>
                </div>
                <div class="emp-attendance-list">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="emp-attendance-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Attendance Type</th>
                            <th>Minutes</th>
                            <th>reason</th>
                            {{-- <th>Action</th> --}}
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
