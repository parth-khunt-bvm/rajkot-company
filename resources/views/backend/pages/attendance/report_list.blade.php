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
                    <span class="svg-icon svg-icon-primary svg-icon-2x report-list-filter-icon" id="report-list-filter-icon"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/>
                        </g>
                    </svg><!--end::Svg Icon-->
                    </span>
                 </div>
                <div class="card-toolbar">
                    <!--begin::Button-->
                    <!--end::Button-->
                    <a href="{{ route('admin-counter-sheet.pdf') }}" class="btn btn-icon btn-outline-danger mr-4 download-countersheet-pdf" id="download-countersheet-pdf">
                        <i class="fa fa-file-pdf"></i>
                    </a>

                    <a href="{{ route('admin-counter-sheet.pdf') }}" class="btn btn-icon btn-outline-success mr-4">
                        <i class="fa fa-file-excel"></i>
                    </a>

                </div>
            </div>
            <div class="card-body">
                <div class="row report-list-filter" style="display:none;">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-4">
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

                            <div class="col-md-4">
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

                            <div class="col-md-4">
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
                            <th>Short Leave</th>
                            <th>OverTime(Hrs.)</th>
                            <th>Total Working Days</th>
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
