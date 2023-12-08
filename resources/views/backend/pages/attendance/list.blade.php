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
                    {{-- <button class="btn btn-primary font-weight-bolder mr-5 show-attendance-form" id="show-attendance-form">+</button> --}}
                    {{-- <button data-toggle="modal" data-target="#importAttendance" class=" import-attendance btn btn-danger font-weight-bolder mr-5 ">Import Attendance</button> --}}
                    <a href="{{ route('admin.attendance.add') }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Add Attendance</a>
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label> Month</label>
                            <select class="form-control select2 month change-fillter" id="monthId"  name="month">
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
                            <select class="form-control select2 year change-fillter" id="yearId"  name="year">
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
                        <div class="attendance-list">
                        <div id="attendance_calendar"></div>
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
