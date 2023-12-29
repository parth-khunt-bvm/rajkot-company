@extends('backend.layout.app')
@section('section')
@php
    $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
@endphp

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
                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(72, explode(',', $permission_array[0]['permission'])) )

                    <span class="svg-icon svg-icon-primary svg-icon-2x show-employee-filter" id="show-employee-filter"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                   @endif

                </div>

                <div class="card-toolbar">
                    <!--begin::Button-->
                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(73, explode(',', $permission_array[0]['permission'])) )
                    <button data-toggle="modal" data-target="#importEmployee" class=" import-manager btn btn-danger font-weight-bolder mr-5 ">Import Employee</button>
                    @endif

                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(74, explode(',', $permission_array[0]['permission'])) )
                        <a href="{{ route('admin.employee.add') }}" class="btn btn-primary font-weight-bolder">
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
                            </span>Add Employee
                        </a>
                    @endif

                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">
                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(72, explode(',', $permission_array[0]['permission'])) )
                <div class="row employee-filter w-5 h-5" style="display: none">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select class="form-control select2 branch change-fillter" id="employee_branch"  name="branch_id">
                                        <option value="">Please select Branch Name</option>
                                        @foreach ($branch  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Technology Name</label>
                                    <select class="form-control select2 technology change-fillter" id="technology_id"  name="technology_id">
                                        <option value="">Please select Technology Name</option>
                                        @foreach ($technology  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['technology_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Designation Name</label>
                                    <select class="form-control select2 designation change-fillter" id="designation_id"  name="designation_id">
                                        <option value="">Please select designation Name</option>
                                        @foreach ($designation  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['designation_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Start Date:</label>
                                    <input type="text" class="form-control datepicker_date change-fillter" id="start_date" name="start_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>End Date:</label>
                                    <input type="text" class="form-control datepicker_date change-fillter" id="end_date" name="end_date" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2 mt-5">
                                <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="employee-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="employee-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Date of Joining</th>
                                <th>Experience</th>
                                <th>Status</th>
                                @php
                                $target = [];
                                $target = [75, 76, 77, 78, 79, 80];
                                @endphp
                                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 )
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
                @endif

            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
