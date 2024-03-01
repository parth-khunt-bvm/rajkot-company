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
                                    <a class="nav-link user-menu" id="bank-info-tab-2"
                                        data-toggle="tab" href="#bankInfo" aria-controls="bank-info">
                                        <span class="nav-icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                        <span class="nav-text">Bank Information</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link user-menu" id="parent-info-tab-2"
                                        data-toggle="tab" href="#parentInfo" aria-controls="parent-info">
                                        <span class="nav-icon">
                                            <i class="fas fa-cube"></i>
                                        </span>
                                        <span class="nav-text"> Parent Information</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link user-menu"  id="company-info-tab-2"
                                        data-toggle="tab" href="#company-info" aria-controls="company-info">
                                        <span class="nav-icon">
                                            <i class="fas fa-calendar-check"></i>
                                        </span>
                                        <span class="nav-text">Company Information</span>
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
                                    <form id="update-profile" action="{{ route('employee.save-profile') }}"
                                        method="post" enctype="multipart/form-data" class="form">
                                        @csrf
                                        <!-- Step 1 -->
                                        <div class="pb-5 step m-5" id="step1">
                                            <h4 class="mb-10 font-weight-bold text-dark">Enter Personal Detail</h4>

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>First Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="hidden" name="edit_id" class="form-control" value="{{ $data['id'] }}">
                                                        <input type="text" class="form-control input-name"
                                                            name="first_name" id="first_name"
                                                            value="{{ $data['first_name'] }}" placeholder="First Name"
                                                            autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Last Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control input-name"
                                                            name="last_name" id="last_name" value="{{ $data['last_name'] }}"
                                                            placeholder="last Name" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Branch Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 branch input-name"
                                                            id="branch" name="branch">
                                                            <option value="">Please select Branch Name</option>
                                                            @foreach ($branch as $key => $value)
                                                                <option value="{{ $value['id'] }}"
                                                                    {{ $data['branch'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                    {{ $value['branch_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Technology Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 technology input-name"
                                                            id="technology" name="technology">
                                                            <option value="">Please select Technology Name</option>
                                                            @foreach ($technology as $key => $value)
                                                                <option value="{{ $value['id'] }}"
                                                                    {{ $data['department'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                    {{ $value['technology_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Designation Name
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 designation input-name"
                                                            id="designation" name="designation">
                                                            <option value="">Please select Designation Name</option>
                                                            @foreach ($designation as $key => $value)
                                                                <option value="{{ $value['id'] }}"
                                                                    {{ $data['designation'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                    {{ $value['designation_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Date Of Birth
                                                        </label>
                                                        <input type="text"
                                                            class="form-control date_of_birth input-name" name="dob"
                                                            id="dob" value="{{ date_formate($data['DOB']) }}"
                                                            max="{{ date('Y-m-d') }}" placeholder="Date Of Birth"
                                                            autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Date Of joining
                                                        </label>
                                                        <input type="text"
                                                            class="form-control datepicker_date input-name" name="doj"
                                                            id="doj" value="{{ date_formate($data['DOJ']) }}"
                                                            placeholder="Date Of Joining" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Company Gmail
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="email" class="form-control input-name"
                                                            name="gmail" id="gmail" value="{{ $data['gmail'] }}"
                                                            placeholder="Gmail" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Gmail Password
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control input-name"
                                                            name="gmail_password" id="gmail_password"
                                                            value="{{ $data['gmail_password'] }}"
                                                            placeholder="Gmail Password" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Slack Password
                                                        </label>
                                                        <input type="text" class="form-control input-name"
                                                            name="slack_password" id="slack_password"
                                                            value="{{ $data['slack_password'] }}"
                                                            placeholder="Slack Password" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Personal Email
                                                        </label>
                                                        <input type="email" class="form-control input-name"
                                                            name="personal_email" value="{{ $data['personal_email'] }}"
                                                            id="personal_email" placeholder="Personal Email"
                                                            autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Status <span class="text-danger">*</span></label>
                                                        <div class="radio-inline" style="margin-top:10px">
                                                            <label class="radio radio-lg radio-success">
                                                                <input type="radio" name="status" class="radio-btn"
                                                                    value="W"
                                                                    {{ $data['status'] == 'W' ? 'checked="checked"' : '' }} />
                                                                <span></span>Working</label>
                                                            <label class="radio radio-lg radio-danger">
                                                                <input type="radio" name="status" class="radio-btn"
                                                                    value="L"
                                                                    {{ $data['status'] == 'L' ? 'checked="checked"' : '' }} />
                                                                <span></span>Left</label>
                                                        </div>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
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
                                    <form id="update-profile" action="{{ route('employee.save-profile') }}" method="post" enctype="multipart/form-data" class="form">
                                        @csrf
                                <!-- Step 2 -->
                                        <div class="pb-5 step m-5 " id="step2">
                                            <h4 class="mb-10 font-weight-bold text-dark">Enter Bank Detail</h4>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Bank Name
                                                        </label>
                                                        <input type="text" class="form-control input-name" name="bank_name" id="bank_name" value="{{ $data['bank_name'] }}" placeholder="Bank Name" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Account Holder Name
                                                        </label>
                                                        <input type="text" class="form-control input-name" name="acc_holder_name" id="acc_holder_name" value="{{ $data['acc_holder_name'] }}" placeholder="Account Holder Name" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Account Number
                                                        </label>
                                                        <input type="text" class="form-control input-name onlyNumber" name="account_number" id="account_number" value="{{ $data['account_number'] }}" placeholder="Account Number" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>IFSC Code
                                                        </label>
                                                        <input type="text" class="form-control input-name" maxlength="11" name="ifsc_code" id="ifsc_code" value="{{ $data['ifsc_number'] }}" placeholder="IFSC Code" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Pan Number
                                                        </label>
                                                        <input type="text" class="form-control input-name" name="pan_number" id="pan_number" value="{{ $data['pan_number'] }}" maxlength="11" placeholder="Pan Number" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Aadhar Card Number
                                                        </label>
                                                        <input type="text" class="form-control input-name onlyNumber " name="aadhar_card_number" id="aadhar_card_number" value="{{ $data['aadhar_card_number'] }}" maxlength="12" placeholder="Aadhar Card Number" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Google Pay Number
                                                        </label>
                                                        <input type="text" class="form-control input-name onlyNumber" name="google_pay" id="google_pay" maxlength="10" value="{{ $data['google_pay_number'] }}" placeholder="Google Pay Number" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
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
                                    <form id="update-profile" action="{{ route('employee.save-profile') }}" method="post" enctype="multipart/form-data" class="form">
                                        @csrf
                                        <!-- Step 3 -->
                                        <div class="pb-5 step m-5 " id="step3">
                                            <h4 class="mb-10 font-weight-bold text-dark">Enter Parent Detail</h4>

                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="form-group">
                                                        <label>Parents Name
                                                        </label>
                                                        <input type="text" class="form-control input-name" name="parent_name" id="parent_name" value="{{ $data['parents_name'] }}" placeholder="Parent Name" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Personal Number
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control  input-name" name="personal_number" id="personal_number" maxlength="10" value="{{ $data['personal_number'] }}" placeholder="Personal Number" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Emergency Contact
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" class="form-control onlyNumber input-name" name="emergency_contact" id="emergency_contact" maxlength="10" value="{{ $data['emergency_number'] }}" placeholder="Emergency Contact" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Address
                                                        </label>
                                                        <textarea class="form-control input-name" id="" cols="30" rows="10" name="address" id="address" autocomplete="off">{{ $data['address'] }}</textarea>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
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

                <div class="tab-pane fade" id="company-info" role="tabpanel" aria-labelledby="company-info-tab-2">

                    <div class="row">
                        <div class="col-md-12">
                            <!--begin::Card-->
                            <div class="card card-custom gutter-b example example-compact">
                                {{-- <div class="card-header">
                                    <h3 class="card-title">{{ $header['title'] }}</h3>
                                </div> --}}
                                <div class="card-body p-0">
                                    <!--begin: Wizard-->
                                    <form id="update-profile" action="{{ route('employee.save-profile') }}" method="post" enctype="multipart/form-data" class="form">
                                        @csrf
                                        <!-- Step 4 -->
                                        <div class="pb-5 step m-5 " id="step4" >
                                            <h4 class="mb-10 font-weight-bold text-dark">Company Information</h4>

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Experience
                                                        </label>
                                                        <input type="number" class="form-control input-name" name="experience" id="experience" value="{{numberformat( $data['experience'], 0) }}" placeholder="Experience" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Hired By
                                                            <span class="text-danger">*</span>
                                                        </label>
                                                        <select class="form-control select2 hired_by input-name" id="hired_by" name="hired_by">
                                                            <option value="">Please select Manager Name</option>
                                                            @foreach ($manager as $key => $value )
                                                            <option value="{{ $value['id'] }}"  {{ $value['id'] == $data['hired_by'] ? 'selected="selected"' : '' }}>{{ $value['manager_name'] }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>salary
                                                        </label>
                                                        <input type="number" class="form-control input-name" name="salary" id="salary" value="{{ numberformat( $data['salary'], 0)  }}" placeholder="Salary" autocomplete="off" />
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Stipend From
                                                        </label>
                                                        <input type="text" class="form-control datepicker_date" name="stipend_from" id="stipend_from" value="{{ $data['stipend_from'] != null && $data['stipend_from'] != '' ? date_formate($data['stipend_from']) : '' }}" placeholder="Stippend From" autocomplete="off" />
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Bond Last Date
                                                        </label>
                                                        <input type="text" class="form-control datepicker_date" name="bond_last_date" id="bond_last_date" value="{{ $data['bond_last_date'] != null && $data['bond_last_date'] != '' ? date_formate($data['bond_last_date']) : '' }}" placeholder="Bond Last Date" autocomplete="off" />
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Resign Date
                                                        </label>
                                                        <input type="text" class="form-control datepicker_date" name="resign_date" id="resign_date" value="{{ $data['resign_date'] != null && $data['resign_date'] != '' ? date_formate($data['resign_date']) : '' }}" placeholder="Resign Date" autocomplete="off" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Last Date
                                                        </label>
                                                        <input type="text" class="form-control datepicker_date" name="last_date" id="last_date" value="{{ $data['last_date'] != null && $data['last_date'] != '' ? date_formate($data['last_date']) : '' }}" placeholder="Last Date" autocomplete="off" />
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>Bond File</label>
                                                        <div></div>
                                                        <div class="custom-file">
                                                            <input type="file" class="form-control custom-file-input" name="bond_file" id="bond_file" autocomplete="off" />
                                                            <label class="custom-file-label" for="customFile">Bond File</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="form-group">
                                                        <label>cheque Image</label>
                                                        <div class="">
                                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                                <div class="image-input-wrapper my-avtar" style="background-image: url({{ $image }})"></div>

                                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                                                    <i class="fa fa-pencil  icon-sm text-muted"></i>
                                                                    <input type="file" name="cancel_cheque" accept=".png, .jpg, .jpeg" />
                                                                    <input type="hidden" name="profile_avatar_remove" />
                                                                </label>
                                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                </span>
                                                            </div>
                                                            <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Trainee Performance
                                                        </label>
                                                        <textarea class="form-control" id="" cols="30" rows="10" name="trainee_performance" id="trainee_performance" autocomplete="off">{{ $data['trainee_performance'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
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
