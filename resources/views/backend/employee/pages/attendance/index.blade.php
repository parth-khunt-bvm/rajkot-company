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
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Month</label>
                            <select class="form-control select2 month emp-cal-fillter" id="empMonthId"  name="month">
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
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>year</label>
                            <select class="form-control select2 year emp-cal-fillter" id="empYearId"  name="year">
                                <option value="">Select Year</option>
                                @for ($i = 2019; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card card-custom">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-label">Attendance Calendar</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="emp-attendance-list">
                        <div id="emp_attendance_calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
