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
                <div class="dropdown dropdown-inline float-right">
                    <select class="form-control select2 month employee_bday" id="employee_bday"  name="employee_bday">
                        <option value="">Select Time</option>
                        <option value="0">Yesterday</option>
                        <option value="1" selected="selected">Today</option>
                        <option value="2">Tomorrow</option>
                        <option value="3">Current Week</option>
                        <option value="4">Current Month</option>
                    </select>
                </div>

                <div class="bday-list">
                    <table class="table table-bordered table-checkable" id="employee-birthday-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Birth Date</th>
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
