@extends('backend.layout.app')
@section('section')

@php
if(file_exists( public_path().'/employee/cheque/'.$employee_details['cancel_cheque']) && $employee_details['cancel_cheque'] != ''){
$image = url("employee/cheque/".$employee_details['cancel_cheque']);
}else{
$image = url("upload/userprofile/default.jpg");
}
@endphp


<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <!--begin::Details-->


                    <div class="row">
                        <div class="col-xl-6 col-md-6">
                            <div class="row">
                                <div class="col-xl-2 col-md-2">
                                    <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url(assets/media/users/blank.png)">
                                        <img class="" src="{{ $image }}" alt="" style="">
                                    </div>
                                </div>
                                <div class="col-xl-10 col-md-10">
                                    <h5 class="text-dark-75 text-hover-primary font-size-h5 font-weight-bold mr-3">{{ $employee_details->first_name.' '. $employee_details->last_name }}</h5>

                                    <span class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-3">
                                        <i class="flaticon2-user mr-2 font-size-lg"></i>{{ $employee_details->technology_name }}</i> </span>
                                    <br>
                                    <span class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-3">
                                        <i class="flaticon2-laptop  mr-2 font-size-lg"></i>{{ $employee_details->designation_name }}</i></span>
                                    <br>

                                    <span class="text-dark-50 text-hover-primary font-weight-bold mr-lg-8 mr-5 mb-lg-0 mb-3">
                                        <i class="flaticon2-calendar mr-2 font-size-lg"></i>{{ $employee_details->DOJ }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6 " style="border-left: 1px dashed red">
                            <div class="row mt-2">
                                <div class="col-xl-3 col-md-3">
                                    <span class="text-dark text-bold">DOB</span>
                                </div>
                                <div class="col-xl-9 col-md-9">
                                    <span class="text-muted font-size-lg ">{{ $employee_details->DOB != '' && $employee_details->DOB != NULL ? date_formate($employee_details->DOB) : '-' }}</span>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-xl-3 col-md-3">
                                    <span class="text-dark text-bold">Com. Gmail</span>
                                </div>
                                <div class="col-xl-9 col-md-9">
                                    <span class="text-muted font-size-lg">{{ $employee_details->gmail }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-xl-3 col-md-3">
                                    <span class="text-dark text-bold">Gmail Password</span>
                                </div>
                                <div class="col-xl-9 col-md-9">
                                    <span class="text-muted font-size-lg">{{ $employee_details->password }}</span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-xl-3 col-md-3">
                                    <span class="text-dark text-bold">Slack Password</span>
                                </div>
                                <div class="col-xl-9 col-md-9">
                                    <span class="text-muted font-size-lg">{{ $employee_details->slack_password }}</span>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-xl-3 col-md-3">
                                    <span class="text-dark text-bold">Per. Email</span>
                                </div>
                                <div class="col-xl-9 col-md-9">
                                    <span class="text-muted font-size-lg">{{ $employee_details->personal_email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                <!--end::Details-->
                <div class="separator separator-solid mt-5"></div>
                <!--begin::Items-->
                <div class="d-flex align-items-center flex-wrap mt-8">



                        <div class="example-preview">
                            <ul class="nav nav-success nav-pills" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab-2" data-toggle="tab" href="#profile-2">
                                        <span class="nav-icon">
                                            <i class="flaticon2-chat-1"></i>
                                        </span>
                                        <span class="nav-text">profile</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link user-menu" data-type="attendance" data-user-id="{{ $employee_details->id }}" id="attendance-tab-2" data-toggle="tab" href="#attendance-2" aria-controls="attendance">
                                        <span class="nav-icon">
                                            <i class="flaticon2-rocket-1"></i>
                                        </span>
                                        <span class="nav-text">Attendance</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link user-menu" id="asset-allocation-tab-2 " data-type="asset-allocation" data-user-id="{{ $employee_details->id }}" data-toggle="tab" href="#asset-allocation-2" aria-controls="asset-allocation">
                                        <span class="nav-icon">
                                            <i class="flaticon2-rocket-1"></i>
                                        </span>
                                        <span class="nav-text">Asset Allocation</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                </div>
                <!--begin::Items-->
            </div>
        </div>
        <div class="tab-content mt-5" id="myTabContent2">
            <!--end::Card-->
            <div class="tab-pane fade show active" id="profile-2" role="tabpanel" aria-labelledby="profile-tab-2">
                <div class="row">
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
                                                <span class="text-muted font-size-lg ">{{ $employee_details->bank_name}}</span>
                                            </div>
                                        </div>

                                        <div class="row mt-2">
                                            <div class="col-xl-4 col-md-4">
                                                <span class="text-dark text-bold">Account Holder Name</span>
                                            </div>
                                            <div class="col-xl-8 col-md-8">
                                                <span class="text-muted font-size-lg">{{  $employee_details->acc_holder_name }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-4 col-md-4">
                                                <span class="text-dark text-bold">Account Number</span>
                                            </div>
                                            <div class="col-xl-8 col-md-8">
                                                <span class="text-muted font-size-lg">{{  $employee_details->account_number }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-4 col-md-4">
                                                <span class="text-dark text-bold">IFSC Code</span>
                                            </div>
                                            <div class="col-xl-8 col-md-8">
                                                <span class="text-muted font-size-lg">{{   $employee_details->ifsc_number }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-4 col-md-4">
                                                <span class="text-dark text-bold">Pancard Number</span>
                                            </div>
                                            <div class="col-xl-8 col-md-8">
                                                <span class="text-muted font-size-lg">{{ $employee_details->pan_number ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-4 col-md-4">
                                                <span class="text-dark text-bold">Aadhar Card Number</span>
                                            </div>
                                            <div class="col-xl-8 col-md-8">
                                                <span class="text-muted font-size-lg">{{ $employee_details->aadhar_card_number }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-4 col-md-4">
                                                <span class="text-dark text-bold">Google Pay Number</span>
                                            </div>
                                            <div class="col-xl-8 col-md-8">
                                                <span class="text-muted font-size-lg">{{$employee_details->google_pay_number}}</span>
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
                                                <span class="text-muted font-size-lg">{{ $employee_details->parents_name }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Personal Number</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{$employee_details->personal_number}}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Emergency Contact</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{$employee_details->emergency_number}}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Address</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{ $employee_details->address}}</span>
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
                <div class="row">
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
                                                <span class="text-muted font-size-lg">{{ numberformat( $employee_details->experience, 0)  }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Hired By</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{$employee_details->hired_by }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Salary</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg"> {{ numberformat( $employee_details->salary, 0)  }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">stipend from</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{$employee_details->stipend_from}}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Bond Last Date</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{ $employee_details->bond_last_date ?? "-"}}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Resign Date</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{$employee_details->resign_date ?? "-"}}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Last Date</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{$employee_details->last_date ?? "-"}}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Trainee Performance</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <span class="text-muted font-size-lg">{{ $employee_details->trainee_performance ?? "-" }}</span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-xl-3 col-md-3">
                                                <span class="text-dark text-bold">Cancel Cheque</span>
                                            </div>
                                            <div class="col-xl-9 col-md-9">
                                                <div class="col-lg-9 col-xl-6">
                                                    <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url(assets/media/users/blank.png)">
                                                        <img class="" src="{{ $image }}" alt="" style="">
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
            </div>
            <div class="tab-pane fade" id="attendance-2" role="tabpanel" aria-labelledby="attendance-tab-2">
                {{-- attendance --}}
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
            <div class="tab-pane fade" id="asset-allocation-2" role="tabpanel" aria-labelledby="asset-allocation-tab-2">
                asset allocation
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-toolbar">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="asset-allocation-list-div">
                        <!--begin: Datatable-->
                            <table class="table table-bordered table-checkable" id="asset-allocation-list">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Asset Type</th>
                                        <th>Brand</th>
                                        <th>Supplier</th>
                                        <th>Asset Code</th>
                                    </tr>
                                </thead>

                                {{-- <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @foreach ( $asset_allocation_details as $asset_allocation_detail )
                                    @php
                                    $i++;
                                    @endphp
                                            <tr>
                                                <td>{{ $i }} </td>
                                                <td>{{ $asset_allocation_detail->asset_type  }} </td>
                                                <td>{{ $asset_allocation_detail->brand_name  }} </td>
                                                <td>{{ $asset_allocation_detail->suppiler_name . ' - ' . $asset_allocation_detail->supplier_shop_name  }} </td>
                                                <td>{{ $asset_allocation_detail->asset_code  }} </td>
                                            </tr>
                                    @endforeach
                                </tbody> --}}
                            </table>
                            <!--end: Datatable-->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                    <!--begin::Entry-->
                    <div class="d-flex flex-column-fluid">
                        <!--begin::Container-->
                        <div class="container">
                            <!--begin::Profile Personal Information-->
                            <div class="change-top-margin" >
                            <div class="d-flex flex-row changemargin">
                                <!--begin::Aside-->
                                <div class="sidebar-margin-change">
                                <div class="flex-row-auto offcanvas-mobile w-250px w-xxl-350px" id="kt_profile_aside">
                                    <!--begin::Profile Card-->
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Body-->
                                        <div class="card-body pt-4">
                                            <!--begin::Toolbar-->
                                            <div class="d-flex justify-content-end">
                                                <div class="dropdown dropdown-inline">
                                                    <a href="#" class="btn btn-clean btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::Toolbar-->
                                            <!--begin::User-->
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-60 symbol-xxl-100 mr-5 align-self-start align-self-xxl-center">
                                                    <div class="symbol-label" style="background-image:url('assets/media/users/300_21.jpg')"></div>
                                                    <i class="symbol-badge bg-success"></i>
                                                </div>
                                                <div>
                                                    <a href="#" class="font-weight-bolder font-size-h5 text-dark-75 text-hover-primary">{{ $employee_details->first_name }} {{ $employee_details->last_name }}</a>
                                                    <div class="text-muted"> {{ $employee_details->technology_name }}</div>
                                                    <div class="mt-2">
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end::User-->
                                            <!--begin::Contact-->
                                            <div class="py-9">
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="font-weight-bold mr-2">Email:</span>
                                                    <a href="#" class="text-muted text-hover-primary">{{ $employee_details->gmail }}</a>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between mb-2">
                                                    <span class="font-weight-bold mr-2">Phone:</span>
                                                    <span class="text-muted">{{ $employee_details->personal_number }}</span>
                                                </div>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="font-weight-bold mr-2">Location:</span>
                                                    <span class="text-muted">{{ $employee_details->address}}</span>
                                                </div>
                                            </div>
                                            <!--end::Contact-->
                                            <!--begin::Nav-->
                                            <div class="navi navi-bold navi-hover navi-active navi-link-rounded user-menu-bar">
                                                <div class="navi-item mb-2">
                                                    <a href="#" class="navi-link py-4 user-menu" data-type="attendance" data-user-id="{{ $employee_details->id }}">
                                                        <span class="navi-icon mr-2">
                                                            <span class="svg-icon">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <path d="M13.5,21 L13.5,18 C13.5,17.4477153 13.0522847,17 12.5,17 L11.5,17 C10.9477153,17 10.5,17.4477153 10.5,18 L10.5,21 L5,21 L5,4 C5,2.8954305 5.8954305,2 7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,21 L13.5,21 Z M9,4 C8.44771525,4 8,4.44771525 8,5 L8,6 C8,6.55228475 8.44771525,7 9,7 L10,7 C10.5522847,7 11,6.55228475 11,6 L11,5 C11,4.44771525 10.5522847,4 10,4 L9,4 Z M14,4 C13.4477153,4 13,4.44771525 13,5 L13,6 C13,6.55228475 13.4477153,7 14,7 L15,7 C15.5522847,7 16,6.55228475 16,6 L16,5 C16,4.44771525 15.5522847,4 15,4 L14,4 Z M9,8 C8.44771525,8 8,8.44771525 8,9 L8,10 C8,10.5522847 8.44771525,11 9,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,9 C11,8.44771525 10.5522847,8 10,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 L8,14 C8,14.5522847 8.44771525,15 9,15 L10,15 C10.5522847,15 11,14.5522847 11,14 L11,13 C11,12.4477153 10.5522847,12 10,12 L9,12 Z M14,12 C13.4477153,12 13,12.4477153 13,13 L13,14 C13,14.5522847 13.4477153,15 14,15 L15,15 C15.5522847,15 16,14.5522847 16,14 L16,13 C16,12.4477153 15.5522847,12 15,12 L14,12 Z" fill="#000000" />
                                                                        <rect fill="#FFFFFF" x="13" y="8" width="3" height="3" rx="1" />
                                                                        <path d="M4,21 L20,21 C20.5522847,21 21,21.4477153 21,22 L21,22.4 C21,22.7313708 20.7313708,23 20.4,23 L3.6,23 C3.26862915,23 3,22.7313708 3,22.4 L3,22 C3,21.4477153 3.44771525,21 4,21 Z" fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text font-size-lg">Attendance</span>
                                                    </a>
                                                </div>
                                                <div class="navi-item mb-2">
                                                    <a href="#" class="navi-link py-4 user-menu" data-type="asset-allocation" data-user-id="{{ $employee_details->id }}">
                                                        <span class="navi-icon mr-2">
                                                            <span class="svg-icon">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <path d="M13.5,21 L13.5,18 C13.5,17.4477153 13.0522847,17 12.5,17 L11.5,17 C10.9477153,17 10.5,17.4477153 10.5,18 L10.5,21 L5,21 L5,4 C5,2.8954305 5.8954305,2 7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,21 L13.5,21 Z M9,4 C8.44771525,4 8,4.44771525 8,5 L8,6 C8,6.55228475 8.44771525,7 9,7 L10,7 C10.5522847,7 11,6.55228475 11,6 L11,5 C11,4.44771525 10.5522847,4 10,4 L9,4 Z M14,4 C13.4477153,4 13,4.44771525 13,5 L13,6 C13,6.55228475 13.4477153,7 14,7 L15,7 C15.5522847,7 16,6.55228475 16,6 L16,5 C16,4.44771525 15.5522847,4 15,4 L14,4 Z M9,8 C8.44771525,8 8,8.44771525 8,9 L8,10 C8,10.5522847 8.44771525,11 9,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,9 C11,8.44771525 10.5522847,8 10,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 L8,14 C8,14.5522847 8.44771525,15 9,15 L10,15 C10.5522847,15 11,14.5522847 11,14 L11,13 C11,12.4477153 10.5522847,12 10,12 L9,12 Z M14,12 C13.4477153,12 13,12.4477153 13,13 L13,14 C13,14.5522847 13.4477153,15 14,15 L15,15 C15.5522847,15 16,14.5522847 16,14 L16,13 C16,12.4477153 15.5522847,12 15,12 L14,12 Z" fill="#000000" />
                                                                        <rect fill="#FFFFFF" x="13" y="8" width="3" height="3" rx="1" />
                                                                        <path d="M4,21 L20,21 C20.5522847,21 21,21.4477153 21,22 L21,22.4 C21,22.7313708 20.7313708,23 20.4,23 L3.6,23 C3.26862915,23 3,22.7313708 3,22.4 L3,22 C3,21.4477153 3.44771525,21 4,21 Z" fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text font-size-lg">Asset Allocation</span>
                                                    </a>
                                                </div>
                                                <div class="navi-item mb-2">
                                                    <a href="#" class="navi-link py-4 user-menu salary-slip" data-type="salary-slip" data-user-id="{{ $employee_details->id }}">
                                                        <span class="navi-icon mr-2">
                                                            <span class="svg-icon">
                                                                <!--begin::Svg Icon | path:assets/media/svg/icons/Code/Compiling.svg-->
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                        <path d="M13.5,21 L13.5,18 C13.5,17.4477153 13.0522847,17 12.5,17 L11.5,17 C10.9477153,17 10.5,17.4477153 10.5,18 L10.5,21 L5,21 L5,4 C5,2.8954305 5.8954305,2 7,2 L17,2 C18.1045695,2 19,2.8954305 19,4 L19,21 L13.5,21 Z M9,4 C8.44771525,4 8,4.44771525 8,5 L8,6 C8,6.55228475 8.44771525,7 9,7 L10,7 C10.5522847,7 11,6.55228475 11,6 L11,5 C11,4.44771525 10.5522847,4 10,4 L9,4 Z M14,4 C13.4477153,4 13,4.44771525 13,5 L13,6 C13,6.55228475 13.4477153,7 14,7 L15,7 C15.5522847,7 16,6.55228475 16,6 L16,5 C16,4.44771525 15.5522847,4 15,4 L14,4 Z M9,8 C8.44771525,8 8,8.44771525 8,9 L8,10 C8,10.5522847 8.44771525,11 9,11 L10,11 C10.5522847,11 11,10.5522847 11,10 L11,9 C11,8.44771525 10.5522847,8 10,8 L9,8 Z M9,12 C8.44771525,12 8,12.4477153 8,13 L8,14 C8,14.5522847 8.44771525,15 9,15 L10,15 C10.5522847,15 11,14.5522847 11,14 L11,13 C11,12.4477153 10.5522847,12 10,12 L9,12 Z M14,12 C13.4477153,12 13,12.4477153 13,13 L13,14 C13,14.5522847 13.4477153,15 14,15 L15,15 C15.5522847,15 16,14.5522847 16,14 L16,13 C16,12.4477153 15.5522847,12 15,12 L14,12 Z" fill="#000000" />
                                                                        <rect fill="#FFFFFF" x="13" y="8" width="3" height="3" rx="1" />
                                                                        <path d="M4,21 L20,21 C20.5522847,21 21,21.4477153 21,22 L21,22.4 C21,22.7313708 20.7313708,23 20.4,23 L3.6,23 C3.26862915,23 3,22.7313708 3,22.4 L3,22 C3,21.4477153 3.44771525,21 4,21 Z" fill="#000000" opacity="0.3" />
                                                                    </g>
                                                                </svg>
                                                                <!--end::Svg Icon-->
                                                            </span>
                                                        </span>
                                                        <span class="navi-text font-size-lg">Salary Slip</span>
                                                    </a>
                                                </div>
                                            </div>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                    <!--end::Profile Card-->
                                </div>
                                </div>
                                <!--end::Aside-->
                                <!--begin::Content-->
                                <div class="flex-row-fluid ml-lg-8 personal-info" id="personal-information">
                                    <!--begin::Card-->
                                    <div class="card card-custom card-stretch">
                                        <!--begin::Header-->
                                        <div class="employee-detail-view">
                                            <div class="card-header py-3">
                                                <div class="card-title align-items-start flex-column">
                                                    <h3 class="card-label font-weight-bolder text-dark">Personal Information</h3>
                                                </div>
                                                <div class="card-toolbar">
                                                </div>
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Profile</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url(assets/media/users/blank.png)">
                                                            <img class="" src="{{ $image }}" alt="" style="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">First Name</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->first_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Last Name</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->last_name }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">DepartMent</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->technology_name  }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Date Of Birth</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->DOB }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Date Of Joining</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->DOJ  }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Company Gmail</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="input-group input-group-lg input-group-solid">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-at"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg form-control-solid" value="{{ $employee_details->gmail }}" placeholder="Email" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Gmail Password</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->password}}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Slack Password</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->slack_password }}" />
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-xl-3 col-lg-3 col-form-label">Personal Gmail</label>
                                                    <div class="col-lg-9 col-xl-6">
                                                        <div class="input-group input-group-lg input-group-solid">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">
                                                                    <i class="la la-at"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control form-control-lg form-control-solid" value=" {{ $employee_details->personal_email }}" placeholder="Email" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Body-->
                                    </div>
                                </div>
                                <!--end::Content-->
                            </div>
                            </div>
                            <!--end::Profile Personal Information-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Entry-->
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
