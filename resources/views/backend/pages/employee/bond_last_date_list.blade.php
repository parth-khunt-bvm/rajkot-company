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
                </div>

            </div>
            <div class="card-body">
                <div class="row bond-last-date-fill" style="display: none">
                    <div class="col-md-2 date" >
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="text" class="form-control datepicker_date date-fill" id="start_date_id" name="start_date" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-2 date" >
                        <div class="form-group">
                            <label>End Date</label>
                            <input type="text" class="form-control datepicker_date date-fill" id="end_date_id" name="end_date" autocomplete="off">
                        </div>
                    </div>

                    <div class="col-md-2 mt-5 date" >
                        <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                    </div>
                </div>
                <div class="dropdown dropdown-inline float-right">
                    <select class="form-control select2 month employee_bond_last_date" id="employee_bond_last_date"  name="employee_bond_last_date">
                        <option value="">Select Time</option>
                        <option value="custom">custom</option>
                        <option value="0">Yesterday</option>
                        <option value="1" selected="selected">Today</option>
                        <option value="2">Tomorrow</option>
                        <option value="3">Current Week</option>
                        <option value="4">Current Month</option>
                        <option value="5">Next Month</option>
                    </select>
                </div>

                <div class="bond-last-date-list">
                    <table class="table table-bordered table-checkable" id="employee-bond-last-date-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Bond Last Date</th>
                                <th>Employee Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
