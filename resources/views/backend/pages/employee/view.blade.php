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
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <span class="nav-text">profile</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link user-menu" data-type="attendance" data-user-id="{{ $employee_details->id }}" id="attendance-tab-2" data-toggle="tab" href="#attendance-2" aria-controls="attendance">
                                        <span class="nav-icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                        <span class="nav-text">Attendance</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link user-menu" id="asset-allocation-tab-2 " data-type="asset-allocation" data-user-id="{{ $employee_details->id }}" data-toggle="tab" href="#asset-allocation-2" aria-controls="asset-allocation">
                                        <span class="nav-icon">
                                            <i class="fas fa-cube"></i>
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

                                <tbody>
                                    @php
                                    $i = 0;
                                    @endphp
                                    @foreach ( $asset_allocations as $asset_allocation )
                                    @php
                                    $i++;
                                    @endphp
                                            <tr>
                                                <td>{{ $i }} </td>
                                                <td>{{ $asset_allocation->asset_type  }} </td>
                                                <td>{{ $asset_allocation->brand_name  }} </td>
                                                <td>{{ $asset_allocation->suppiler_name . ' - ' . $asset_allocation->supplier_shop_name  }} </td>
                                                <td>{{ $asset_allocation->asset_code  }} </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <!--end: Datatable-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
