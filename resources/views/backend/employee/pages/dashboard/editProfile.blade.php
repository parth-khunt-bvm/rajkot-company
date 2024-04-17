@extends('backend.employee.layout.app')
@section('section')
    @php
        $currentRoute = Route::current()->getName();
        if (!empty(Auth()->guard('employee')->user())) {
            $data = Auth()->guard('employee')->user();
        }
        if (
            file_exists(public_path() . '/upload/userprofile/' . $data['employee_image']) &&
            $data['employee_image'] != ''
        ) {
            $image = url('upload/userprofile/' . $data['employee_image']);
        } else {
            $image = url('upload/userprofile/default.jpg');
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
                    <h3 class="card-title">{{ $header['title'] }}</h3>
                </div>
                <div class="card-body">
                    <!--begin::Details-->
                    <!--begin::Items-->
                    <div class="d-flex align-items-center flex-wrap mt-8">
                        <div class="">
                            <ul class="nav nav-success nav-pills" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="profile-tab-2" data-toggle="tab" href="#personalInfo">
                                        <span class="nav-icon">
                                            <i class="fas fa-user"></i>
                                        </span>
                                        <span class="nav-text">Personal Information</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link user-menu" id="bank-info-tab-2" data-toggle="tab" href="#bankInfo"
                                        aria-controls="bank-info">
                                        <span class="nav-icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                        <span class="nav-text">Bank Information</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link user-menu" id="parent-info-tab-2" data-toggle="tab"
                                        href="#parentInfo" aria-controls="parent-info">
                                        <span class="nav-icon">
                                            <i class="fas fa-cube"></i>
                                        </span>
                                        <span class="nav-text"> Parent Information</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--begin::Items-->
                </div>
            </div>
            <!--end::Card-->
            <div class="tab-content mt-5" id="myTabContent2">
                <!--end::Card-->
                <div class="tab-pane fade show active" id="personalInfo" role="tabpanel" aria-labelledby="profile-tab-2">

                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                {{-- <div class="card-header">
                                    <h3 class="card-title">{{ $header['title'] }}</h3>
                                </div> --}}
                                <div class="card-body p-0">
                                    <!--begin: Wizard-->
                                    <form id="update-personal-info" action="{{ route('employee.save-personal-info') }}"
                                        method="post" enctype="multipart/form-data" class="form update-profile">
                                        @csrf
                                        <!-- Step 1 -->
                                        <div class="pb-5 step m-5" id="step1">
                                            <h4 class="mb-10 font-weight-bold text-dark">Enter Personal Detail</h4>

                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>First Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="hidden" name="id" class="form-control"
                                                            value="{{ $data['id'] }}">
                                                        <input type="text" class="form-control" name="first_name"
                                                            id="first_name" value="{{ $data['first_name'] }}"
                                                            placeholder="First Name" autocomplete="off" />
                                                        <input type="hidden" value="{{ $data['first_name'] }}"
                                                            class="old_value" data-attribute="first_name">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Last Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="last_name"
                                                            id="last_name" value="{{ $data['last_name'] }}"
                                                            placeholder="last Name" autocomplete="off" />
                                                        <input type="hidden" value="{{ $data['last_name'] }}"
                                                            class="old_value" data-attribute="last_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Branch Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 branch" id="branch"
                                                            name="branch">
                                                            <option value="">Please select Branch Name</option>
                                                            @foreach ($branch as $key => $value)
                                                                <option value="{{ $value['id'] }}"
                                                                    {{ $data['branch'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                    {{ $value['branch_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Technology Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 technology" id="technology"
                                                            name="department">
                                                            <option value="">Please select Technology Name</option>
                                                            @foreach ($technology as $key => $value)
                                                                <option value="{{ $value['id'] }}"
                                                                    {{ $data['department'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                    {{ $value['technology_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Designation Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 designation" id="designation"
                                                            name="designation">
                                                            <option value="">Please select Designation Name</option>
                                                            @foreach ($designation as $key => $value)
                                                                <option value="{{ $value['id'] }}"
                                                                    {{ $data['designation'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                    {{ $value['designation_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Date Of Birth</label>
                                                        <input type="text" class="form-control date_of_birth" name="DOB" id="dob"
                                                            value="{{ $data['DOB'] != null && $data['DOB'] != '' ? date_formate($data['DOB']) : '' }}"
                                                            max="{{ date('Y-m-d') }}" placeholder="Date Of Birth"
                                                            autocomplete="off" />
                                                        <input type="hidden" value="{{ date_formate($data['DOB']) }}"
                                                            class="old_value" data-attribute="dob">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Date Of joining</label>
                                                        <input type="text" class="form-control datepicker_date"
                                                            name="DOJ" id="doj"
                                                            value="{{ $data['DOJ'] != null && $data['DOJ'] != '' ? date_formate($data['DOJ']) : '' }}"
                                                            placeholder="Date Of Joining" autocomplete="off" />
                                                        <input type="hidden" value="{{ date_formate($data['DOJ']) }}"
                                                            class="old_value" data-attribute="doj">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Company Gmail
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email" class="form-control" name="gmail"
                                                            id="gmail" value="{{ $data['gmail'] }}"
                                                            placeholder="Gmail" autocomplete="off" />
                                                        <input type="hidden" value="{{ $data['gmail'] }}"
                                                            class="old_value" data-attribute="gmail">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Gmail Password
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="gmail_password"
                                                            id="gmail_password" value="{{ $data['gmail_password'] }}"
                                                            placeholder="Gmail Password" autocomplete="off" />
                                                        <input type="hidden" value="{{ $data['gmail_password'] }}"
                                                            class="old_value" data-attribute="gmail_password">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Slack Password
                                                        </label>
                                                        <input type="text" class="form-control" name="slack_password"
                                                            id="slack_password" value="{{ $data['slack_password'] }}"
                                                            placeholder="Slack Password" autocomplete="off" />
                                                        <input type="hidden" value="{{ $data['slack_password'] }}"
                                                            class="old_value" data-attribute="slack_password">
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Personal Email
                                                        </label>
                                                        <input type="email" class="form-control" name="personal_email"
                                                            value="{{ $data['personal_email'] }}" id="personal_email"
                                                            placeholder="Personal Email" autocomplete="off" />
                                                        <input type="hidden" value="{{ $data['personal_email'] }}"
                                                            class="old_value" data-attribute="personal_email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--end: Wizard-->
                                </div>
                            </div>
                            <!--end::Card-->

                        </div>

                    </div>

                </div>

                <div class="tab-pane fade" id="bankInfo" role="tabpanel" aria-labelledby="bank-info-tab-2">

                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                {{-- <div class="card-header">
                                    <h3 class="card-title">{{ $header['title'] }}</h3>
                                </div> --}}
                                <div class="card-body p-0">
                                    <!--begin: Wizard-->
                                    <form id="update-bank-info" action="{{ route('employee.save-bank-info') }}"
                                        method="post" enctype="multipart/form-data" class="form">
                                        @csrf
                                        <!-- Step 2 -->
                                        <div class="pb-5 step m-5 " id="step2">
                                            <h4 class="mb-10 font-weight-bold text-dark">Enter Bank Detail</h4>
                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Bank Name
                                                        </label>
                                                        <input type="hidden" name="id" class="form-control"
                                                            value="{{ $data['id'] }}">
                                                        <input type="text" class="form-control" name="bank_name"
                                                            id="bank_name" value="{{ $data['bank_name'] }}"
                                                            placeholder="Bank Name" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Account Holder Name
                                                        </label>
                                                        <input type="text" class="form-control" name="acc_holder_name"
                                                            id="acc_holder_name" value="{{ $data['acc_holder_name'] }}"
                                                            placeholder="Account Holder Name" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Account Number
                                                        </label>
                                                        <input type="text" class="form-control onlyNumber"
                                                            name="account_number" id="account_number"
                                                            value="{{ $data['account_number'] }}"
                                                            placeholder="Account Number" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>IFSC Code
                                                        </label>
                                                        <input type="text" class="form-control" maxlength="11"
                                                            name="ifsc_number" id="ifsc_code"
                                                            value="{{ $data['ifsc_number'] }}" placeholder="IFSC Code"
                                                            autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Pan Number
                                                        </label>
                                                        <input type="text" class="form-control" name="pan_number"
                                                            id="pan_number" value="{{ $data['pan_number'] }}"
                                                            maxlength="11" placeholder="Pan Number" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Aadhar Card Number
                                                        </label>
                                                        <input type="text" class="form-control onlyNumber "
                                                            name="aadhar_card_number" id="aadhar_card_number"
                                                            value="{{ $data['aadhar_card_number'] }}" maxlength="12"
                                                            placeholder="Aadhar Card Number" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Google Pay Number
                                                        </label>
                                                        <input type="text" class="form-control onlyNumber"
                                                            name="google_pay_number" id="google_pay" maxlength="10"
                                                            value="{{ $data['google_pay_number'] }}"
                                                            placeholder="Google Pay Number" autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--end: Wizard-->
                                </div>
                            </div>
                            <!--end::Card-->

                        </div>

                    </div>

                </div>

                <div class="tab-pane fade" id="parentInfo" role="tabpanel" aria-labelledby="parent-info-tab-2">

                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                {{-- <div class="card-header">
                                    <h3 class="card-title">{{ $header['title'] }}</h3>
                                </div> --}}
                                <div class="card-body p-0">
                                    <!--begin: Wizard-->
                                    <form id="update-parent-info" action="{{ route('employee.save-parent-info') }}"
                                        method="post" enctype="multipart/form-data" class="form">
                                        @csrf
                                        <!-- Step 3 -->
                                        <div class="pb-5 step m-5 " id="step3">
                                            <h4 class="mb-10 font-weight-bold text-dark">Enter Parent Detail</h4>

                                            <div class="row">
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Parents Name
                                                        </label>
                                                        <input type="hidden" name="id" class="form-control"
                                                            value="{{ $data['id'] }}">
                                                        <input type="text" class="form-control" name="parents_name"
                                                            id="parent_name" value="{{ $data['parents_name'] }}"
                                                            placeholder="Parent Name" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Personal Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control" name="personal_number"
                                                            id="personal_number" maxlength="10"
                                                            value="{{ $data['personal_number'] }}"
                                                            placeholder="Personal Number" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-3">
                                                    <div class="form-group">
                                                        <label>Emergency Contact
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control onlyNumber"
                                                            name="emergency_number" id="emergency_contact" maxlength="10"
                                                            value="{{ $data['emergency_number'] }}"
                                                            placeholder="Emergency Contact" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Address
                                                        </label>
                                                        <textarea class="form-control" id="" cols="30" rows="1" name="address" id="address"
                                                            autocomplete="off">{{ $data['address'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit"
                                                    class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                                <button type="reset" class="btn btn-secondary">Cancel</button>
                                            </div>
                                        </div>
                                    </form>
                                    <!--end: Wizard-->
                                </div>
                            </div>
                            <!--end::Card-->

                        </div>

                    </div>

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
