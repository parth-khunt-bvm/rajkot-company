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

                    {{-- <button class="btn btn-primary font-weight-bolder mr-5 show-leave-request-form" id="show-leave-request-form">+</button> --}}

                    {{-- <button class="btn btn-primary font-weight-bolder mr-5 show-branch-form" id="show-branch-form">+</button> --}}
                    <a href="{{ route('latter-templates.create') }}" class="btn btn-primary font-weight-bolder">
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
                        </span>Add Latter Template
                    </a>
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">

                {{-- <form class="form" style="display: none;" id="add-leave-request" method="POST" action="{{ route('leave-request.store') }}" autocomplete="off">@csrf
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="date" id="datepicker_date" class="form-control date" max="{{ date('Y-m-d') }}" placeholder="Select Date" value="" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Leave Type
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 leave_type leave_select" name="leave_type" id="leave_type">
                                    <option value="">Please select Leave Type</option>
                                    <option value="1">Full Day Leave</option>
                                    <option value="2">Half Day Leave</option>
                                    <option value="3">Short Leave</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Manager
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 manager input-name" id="manager" name="manager">
                                    <option value="">Please select Manager Name</option>
                                    @foreach ($manager as $key => $value )
                                    <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Reson
                                </label>
                                <textarea class="form-control" id="" cols="40" rows="1" name="reason" id="reason"></textarea>
                            </div>
                        </div>

                        <div class="col-md-2 mt-8">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
            </form> --}}
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="latter-template-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Template Name</th>
                            <th>Template</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
