@extends('backend.layout.app')
@section('section')
    @php
        // if(file_exists( public_path().'/employee/cheque/'.$employee_details['cancel_cheque']) && $employee_details['cancel_cheque'] != ''){
        // $image = url("employee/cheque/".$employee_details['cancel_cheque']);
        // }else{
        $image = url('upload/userprofile/default.jpg');
        // }
    @endphp

    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">{{ $header['title'] }}</h3>
                        </div>
                        <div class="card-body p-0">
                            <!--begin: Wizard-->
                            <form id="add-employee-form" action="{{ route('admin.employee.save-add-employee') }}"
                                method="post" enctype="multipart/form-data" class="form">
                                @csrf
                                <!-- Step 1 -->
                                <div class="card-body">
                                    <div class="pb-5 step" id="step1">
                                        <h4 class="mb-10 font-weight-bold text-dark">Enter Personal Detail</h4>

                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>First Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control input-name" name="first_name"
                                                        id="first_name" placeholder="First Name" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Last Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control input-name" name="last_name"
                                                        id="last_name" placeholder="last Name" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Branch Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 branch input-name" id="branch"
                                                        name="branch">
                                                        <option value="">Please select Branch Name</option>
                                                        @foreach (user_branch() as $key => $value)
                                                            <option value="{{ $value['id'] }}"
                                                                {{ $_COOKIE['branch'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                                {{ $value['branch_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Technology Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 technology input-name"
                                                        id="technology" name="technology">
                                                        <option value="">Please select Technology Name</option>
                                                        @foreach ($technology as $key => $value)
                                                            <option value="{{ $value['id'] }}">
                                                                {{ $value['technology_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Designation Name
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 designation input-name"
                                                        id="designation" name="designation">
                                                        <option value="">Please select Designation Name</option>
                                                        @foreach ($designation as $key => $value)
                                                            <option value="{{ $value['id'] }}">
                                                                {{ $value['designation_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Date Of Birth
                                                    </label>
                                                    <input type="text" class="form-control date_of_birth input-name"
                                                        name="dob" id="dob" max="{{ date('Y-m-d') }}"
                                                        placeholder="Date Of Birth" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Date Of joining
                                                    </label>
                                                    <input type="text" class="form-control datepicker_date input-name"
                                                        name="doj" id="doj" placeholder="Date Of Joining"
                                                        autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Slack Password
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="slack_password" id="slack_password"
                                                        placeholder="Slack Password" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Company Gmail
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="email" class="form-control input-name" name="gmail"
                                                        id="gmail" placeholder="Gmail" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Gmail Password
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="gmail_password" id="gmail_password"
                                                        placeholder="Gmail Password" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Personal Email
                                                    </label>
                                                    <input type="email" class="form-control input-name"
                                                        name="personal_email" id="personal_email"
                                                        placeholder="Personal Email" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Status <span class="text-danger">*</span></label>
                                                    <div class="radio-inline" style="margin-top:10px">
                                                        <label class="radio radio-lg radio-success ">
                                                            <input type="radio" name="status"
                                                                class="radio-btn input-name" value="W"
                                                                checked="checked" />
                                                            <span></span>Working</label>
                                                        <label class="radio radio-lg radio-danger">
                                                            <input type="radio" name="status"
                                                                class="radio-btn input-name" value="L" />
                                                            <span></span>Left</label>
                                                    </div>
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" data-next-page="2" data-current-page="1"
                                            class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 float-right mb-2 next-step">Next</button>
                                    </div>


                                    <!-- Step 2 -->
                                    <div class="pb-5 step" id="step2" style="display: none">
                                        <h4 class="mb-10 font-weight-bold text-dark">Enter Bank Detail</h4>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Bank Name
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="bank_name" id="bank_name" placeholder="Bank Name"
                                                        autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Account Holder Name
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="acc_holder_name" id="acc_holder_name"
                                                        placeholder="Account Holder Name" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Account Number
                                                    </label>
                                                    <input type="text" class="form-control input-name onlyNumber"
                                                        name="account_number" id="account_number"
                                                        placeholder="Account Number" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>IFSC Code
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="ifsc_code" id="ifsc_code" maxlength="11"
                                                        placeholder="IFSC Code" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Pan Number
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="pan_number" id="pan_number" placeholder="Pan Number"
                                                        maxlength="11" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Aadhar Card Number
                                                    </label>
                                                    <input type="text" class="form-control input-name onlyNumber"
                                                        name="aadhar_card_number" id="aadhar_card_number" maxlength="12"
                                                        placeholder="Aadhar Card Number" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Google Pay Number
                                                    </label>
                                                    <input type="text" class="form-control input-name onlyNumber"
                                                        name="google_pay" id="google_pay" maxlength="10"
                                                        placeholder="Google Pay Number" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-container d-flex justify-content-between float-right">
                                            <button type="button" data-prev-page="1" data-current-page="2"
                                                class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 prev-step">Previous</button>
                                            <button type="button" data-next-page="3" data-current-page="2"
                                                class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="pb-5 step" id="step3" style="display: none">
                                        <h4 class="mb-10 font-weight-bold text-dark">Enter Parent Detail</h4>

                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Parents Name
                                                    </label>
                                                    <input type="text" class="form-control input-name"
                                                        name="parent_name" id="parent_name" placeholder="Parent Name"
                                                        autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Personal Number
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control onlyNumber input-name"
                                                        name="personal_number" id="personal_number" maxlength="10"
                                                        placeholder="Personal Number" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Emergency Contact
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control onlyNumber input-name"
                                                        name="emergency_contact" id="emergency_contact" maxlength="10"
                                                        placeholder="Emergency Contact" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Address
                                                    </label>
                                                    <textarea class="form-control input-name" id="" cols="30" rows="1" name="address"
                                                        id="address" autocomplete="off"></textarea>
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-container d-flex justify-content-between float-right">
                                            <button type="button" data-prev-page="2"
                                                data-current-page="3"class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 prev-step">Previous</button>
                                            <button type="button" data-next-page="4"
                                                data-current-page="3"class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 next-step">Next</button>
                                        </div>
                                    </div>

                                    <!-- Step 4 -->
                                    <div class="pb-5 step" id="step4" style="display: none">
                                        <h4 class="mb-10 font-weight-bold text-dark">Company Information</h4>

                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Experience
                                                    </label>
                                                    <input type="number" class="form-control input-name"
                                                        name="experience" id="experience" placeholder="Experience"
                                                        autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Hired By
                                                        <span class="text-danger">*</span>
                                                    </label>
                                                    <select class="form-control select2 hired_by input-name"
                                                        id="hired_by" name="hired_by">
                                                        <option value="">Please select Manager Name</option>
                                                        @foreach ($manager as $key => $value)
                                                            <option value="{{ $value['id'] }}">
                                                                {{ $value['manager_name'] }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>salary
                                                    </label>
                                                    <input type="number" class="form-control input-name" name="salary"
                                                        id="salary" placeholder="Salary" autocomplete="off" />
                                                    <span class="type_error text-danger"></span>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Stipend From
                                                    </label>
                                                    <input type="text" class="form-control datepicker_date"
                                                        name="stipend_from" id="stipend_from" placeholder="Stippend From"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Bond Last Date
                                                    </label>
                                                    <input type="text" class="form-control datepicker_date"
                                                        name="bond_last_date" id="bond_last_date"
                                                        placeholder="Bond Last Date" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Resign Date
                                                    </label>
                                                    <input type="text" class="form-control datepicker_date"
                                                        name="resign_date" id="resign_date" placeholder="Resign Date"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Last Date
                                                    </label>
                                                    <input type="text" class="form-control datepicker_date"
                                                        name="last_date" id="last_date" placeholder="Last Date"
                                                        autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <label>Bond File</label>
                                                    <div></div>
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control custom-file-input"
                                                            name="bond_file" id="bond_file" autocomplete="off" />
                                                        <label class="custom-file-label" for="customFile"
                                                            accept=".pdf,application/pdf">Bond File</label>
                                                        <span class="type_error text-danger"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Trainee Performance
                                                    </label>
                                                    <textarea class="form-control" id="" cols="30" rows="5" name="trainee_performance"
                                                        id="trainee_performance" autocomplete="off"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label>cheque Image</label>
                                                        <div class="">
                                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                                <div class="image-input-wrapper my-avtar"
                                                                    style="background-image: url({{ $image }})">
                                                                </div>

                                                                <label
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="change" data-toggle="tooltip"
                                                                    title="" data-original-title="Change avatar">
                                                                    <i class="fa fa-pencil  icon-sm text-muted"></i>
                                                                    <input type="file" name="cancel_cheque"
                                                                        accept=".png, .jpg, .jpeg" />
                                                                    <input type="hidden" name="profile_avatar_remove" />
                                                                </label>
                                                                <span
                                                                    class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow"
                                                                    data-action="cancel" data-toggle="tooltip"
                                                                    title="Cancel avatar">
                                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                                </span>
                                                            </div>
                                                            <span class="form-text text-muted">Allowed file types: png,
                                                                jpg, jpeg.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Cheque Status <span class="text-danger">*</span></label>
                                                    <div class="radio-inline" style="margin-top:10px">
                                                        <label class="radio radio-lg radio-success" >
                                                        <input type="radio" name="cheque_status" class="radio-btn" value="S"/>
                                                        <span></span>Submitted</label>
                                                        <label class="radio radio-lg radio-warning" >
                                                        <input type="radio" name="cheque_status" class="radio-btn" value="P"/>
                                                        <span></span>Pending</label>
                                                        <label class="radio radio-lg radio-danger" >
                                                        <input type="radio" name="cheque_status" class="radio-btn" value="R"/>
                                                        <span></span>Return</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="button-container d-flex justify-content-between float-right">
                                            <button type="button" data-prev-page="3" data-current-page="4"
                                                class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 mb-2 prev-step">Previous</button>
                                            <button type="submit"
                                                class="btn btn-success font-weight-bolder text-uppercase px-9 py-4 float-right m-1 mb-2">Submit</button>
                                        </div>
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
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection

{{-- <script>
    let currentStep = 1;
    function nextStep(step) {
        if (step === currentStep) {
            return;
        }

        const currentStepElement = document.getElementById(`step${currentStep}`);
        const nextStepElement = document.getElementById(`step${step}`);

        if (currentStepElement && nextStepElement) {
            currentStepElement.style.display = "none";
            nextStepElement.style.display = "block";
            currentStep = step;
        }
    }
</script> --}}
