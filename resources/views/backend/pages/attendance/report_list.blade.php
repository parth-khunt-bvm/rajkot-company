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
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>
            </div>
            <div class="card-body">

                <div class="row report-list-filter" style="">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch Name</label>
                                    <select class="form-control select2 branch counter-sheet-filter" id="att_report_branch_id"  name="branch_id">
                                        <option value="">Please select Branch Name</option>
                                        @foreach ($branch  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Technology Name</label>
                                    <select class="form-control select2 technology counter-sheet-filter" id="att_report_technology_id"  name="technology_id">
                                        <option value="">Please select Technology Name</option>
                                        @foreach ($technology  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['technology_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label> Month</label>
                                    <select class="form-control select2 month counter-sheet-filter" id="att_report_month_id"  name="month">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>year</label>
                                    <select class="form-control select2 year counter-sheet-filter" id="att_report_year_id"  name="year">
                                        <option value="">Select Year</option>
                                        @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ $i == date('Y') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mt-5">
                        <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                    </div>
                </div>
                <div class="attendance-report-list">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="attendance-report-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Total Working Day</th>
                            <th>Present Day</th>
                            <th>Absent Day</th>
                            <th>Half leave</th>
                            <th>Sort Leave</th>
                            <th>total</th>
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
