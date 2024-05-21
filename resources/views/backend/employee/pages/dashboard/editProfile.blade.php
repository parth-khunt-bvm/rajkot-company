@extends('backend.employee.layout.app')
@section('section')
    @php
        $currentRoute = Route::current()->getName();
        if (!empty(Auth()->guard('employee')->user())) {
            $data = Auth()->guard('employee')->user();
        }
        if (
            file_exists(public_path() . '/upload/userprofile/' . $employee_details['employee_image']) &&
            $employee_details['employee_image'] != ''
        ) {
            $image = url('upload/userprofile/' . $employee_details['employee_image']);
        } else {
            $image = url('upload/userprofile/default.jpg');
        }
        if (
            file_exists(public_path() . '/employee/cheque/' . $employee_details['cancel_cheque']) &&
            $employee_details['cancel_cheque'] != ''
        ) {
            $cheque_image = url('employee/cheque/' . $employee_details['cancel_cheque']);
        } else {
            $cheque_image = url('upload/userprofile/default.jpg');
        }
        if (
            file_exists(public_path() . '/employee/bond/' . $employee_details['bond_file']) &&
            $employee_details['bond_file'] != ''
        ) {
            $bond_file = url('employee/bond/' . $employee_details['bond_file']);
        } else {
            $bond_file = '';
        }
    @endphp
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <!--begin::Container-->
        <div class="container-fluid">
            {{-- <div class="row"> --}}
            {{-- <div class="col-md-12"> --}}
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
                <div class="card-header">
                    <h3 class="card-title font-weight-bolder text-dark">{{ $header['title'] }}</h3>
                </div>
                <form class="form" id="update-personal-info" method="POST" action="{{ route('employee.save-profile') }}"
                    enctype="multipart/form-data">@csrf
                    <div class="card-body pb-0">
                        <div class="row">
                            <div class="col-xl-auto">
                                <div class="form-group">
                                    <label>Profile Image</label>
                                    <div class="">
                                        <div class="image-input image-input-outline" id="kt_image_1">
                                            <div class="image-input-wrapper my-avtar pre-img"
                                                style="background-image: url({{ $image }})"></div>
                                            <label
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="change" data-toggle="tooltip" title=""
                                                data-original-title="Change avatar">
                                                <i class="fa fa-pencil  icon-sm text-muted"></i>
                                                <input type="file" name="employee_image" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="profile_avatar_remove" />
                                            </label>
                                            <span
                                                class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                <i class="ki ki-bold-close icon-xs text-muted"></i>
                                            </span>
                                        </div>
                                        <span class="form-text text-muted">Allowed file types: png, jpg,
                                            jpeg.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>First Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="hidden" name="id" class="form-control"
                                        value="{{ $employee_details->id }}">
                                    <input type="text" class="form-control" name="first_name"
                                        id="first_name" value="{{ $employee_details->first_name }}"
                                        placeholder="First Name" autocomplete="off" />
                                    <input type="hidden" value="{{ $employee_details->first_name }}"
                                        class="old_value" data-attribute="first_name">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Last Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="last_name"
                                        id="last_name" value="{{ $employee_details->last_name }}"
                                        placeholder="last Name" autocomplete="off" />
                                    <input type="hidden" value="{{ $employee_details->last_name }}"
                                        class="old_value" data-attribute="last_name">
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="form-group">
                                    <label>Company Gmail
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" class="form-control" name="gmail"
                                        id="gmail" value="{{ $employee_details->gmail }}"
                                        placeholder="Gmail" autocomplete="off" />
                                    <input type="hidden" value="{{ $employee_details->gmail }}"
                                        class="old_value" data-attribute="gmail">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary mr-2 green-btn submitbtn">Submit</button>
                        <button type="reset" class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="card card-custom card-stretch gutter-b">
                        <div class="card-header">
                            <h3 class="card-title font-weight-bolder text-dark">Personal Information</h3>
                        </div>
                        <div class="card-body">
                            <!--begin::Details-->

                            <div class="row">
                                <div class="col-xl-4 col-md-4">
                                    <div class="row">
                                        <div class="col-xl-10 col-md-10">
                                            <h5 class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">
                                                {{ $employee_details->first_name . ' ' . $employee_details->last_name }}</h5>

                                            <span
                                                class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-3">
                                                <i
                                                    class="flaticon2-user mr-2 font-size-lg"></i>{{ $employee_details->technology_name }}</i>
                                            </span>
                                            <br>
                                            <span
                                                class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-3">
                                                <i
                                                    class="flaticon2-laptop  mr-2 font-size-lg"></i>{{ $employee_details->designation_name }}</i></span>
                                            <br>

                                            <span
                                                class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-3">
                                                <i
                                                    class="flaticon2-calendar mr-2 font-size-lg"></i>{{ $employee_details->DOJ }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-8" style="border-left: 1px dashed red">
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">DOB</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg ">{{ $employee_details->DOB != '' && $employee_details->DOB != null ? date_formate($employee_details->DOB) : '-' }}</span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Com. Gmail</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span class="text-muted font-size-lg">{{ $employee_details->gmail }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Gmail Password</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span class="text-muted font-size-lg">{{ $employee_details->gmail_password }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Slack Password</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span class="text-muted font-size-lg">{{ $employee_details->slack_password }}</span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Per. Email</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span class="text-muted font-size-lg">{{ $employee_details->personal_email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <!--begin::List Widget 3-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Bank Information</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->

                        <div class="card-body pt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Bank Name</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg ">{{ $employee_details->bank_name }}</span>
                                        </div>
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Account Holder Name</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->acc_holder_name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Account Number</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->account_number }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">IFSC Code</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->ifsc_number }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Pancard Number</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->pan_number ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Aadhar Card Number</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->aadhar_card_number }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-4 col-md-4">
                                            <span class="text-dark text-bold">Google Pay Number</span>
                                        </div>
                                        <div class="col-xl-8 col-md-8">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->google_pay_number }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 3-->
                </div>
            </div>
            <!--end::Card-->
            
            <div class="row">
                <div class="col-xl-6">
                    <!--begin::List Widget 3-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Emergency Contact</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->

                        <div class="card-body pt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Parents Name</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->parents_name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Personal Number</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->personal_number }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Emergency Contact</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->emergency_number }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Address</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->address }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 3-->
                </div>
                <div class="col-xl-6">
                    <!--begin::List Widget 3-->
                    <div class="card card-custom card-stretch gutter-b">
                        <!--begin::Header-->
                        <div class="card-header border-0">
                            <h3 class="card-title font-weight-bolder text-dark">Company Information</h3>
                            <div class="card-toolbar">
                            </div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->

                        <div class="card-body pt-2">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Experience</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ numberformat($employee_details->experience, 0) }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Hired By</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span class="text-muted font-size-lg">{{ $employee_details->manager_name }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Salary</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span class="text-muted font-size-lg">
                                                {{ numberformat($employee_details->salary, 0) }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">stipend from</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->stipend_from }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Bond Last Date</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->bond_last_date ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Resign Date</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->resign_date ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Last Date</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->last_date ?? '-' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Trainee Performance</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <span
                                                class="text-muted font-size-lg">{{ $employee_details->trainee_performance ?? '-' }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Bond File</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            @if ($bond_file != '')
                                            <a href="{{ $bond_file }}" class="btn btn-primary font-weight-bolder" download>Download</a>
                                            @else
                                            <span class="text-muted font-size-lg">-</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-xl-3 col-md-3">
                                            <span class="text-dark text-bold">Cancel Cheque</span>
                                        </div>
                                        <div class="col-xl-9 col-md-9">
                                            <div class="image-input image-input-outline"
                                                id="kt_profile_avatar"
                                                style="background-image: url(assets/media/users/blank.png)">
                                                <div class="doc-img">
                                                    <img src="{{ $cheque_image }}" alt="" width="100" class="pre-img">
                                                    <a href="{{ $cheque_image }}" class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow downloadBtn" data-toggle="tooltip" data-original-title="Download" download>
                                                        <i class="fa fa-download text-primary"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::List Widget 3-->
                </div>
            </div>

            {{-- </div> --}}

            {{-- </div> --}}
        </div>
        <!--end::Container-->
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
