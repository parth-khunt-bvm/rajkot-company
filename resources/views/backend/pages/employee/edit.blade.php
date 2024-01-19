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
    {{-- <div class="d-flex flex-column-fluid">
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
										<div class="wizard wizard-3" id="kt_wizard_v3" data-wizard-state="step-first" data-wizard-clickable="true">
											<!--begin: Wizard Nav-->
											<div class="wizard-nav">
												<div class="wizard-steps px-8 py-8 px-lg-15 py-lg-3">
													<!--begin::Wizard Step 1 Nav-->
													<div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
														<div class="wizard-label">
															<h3 class="wizard-title">
															<span>1.</span>Personal Detail</h3>
															<div class="wizard-bar"></div>
														</div>
													</div>
													<!--end::Wizard Step 1 Nav-->
													<!--begin::Wizard Step 2 Nav-->
													<div class="wizard-step" data-wizard-type="step">
														<div class="wizard-label">
															<h3 class="wizard-title">
															<span>2.</span>Bank Details</h3>
															<div class="wizard-bar"></div>
														</div>
													</div>
													<!--end::Wizard Step 2 Nav-->
													<!--begin::Wizard Step 3 Nav-->
													<div class="wizard-step" data-wizard-type="step">
														<div class="wizard-label">
															<h3 class="wizard-title">
															<span>3.</span>Parent Details</h3>
															<div class="wizard-bar"></div>
														</div>
													</div>
													<!--end::Wizard Step 3 Nav-->
													<!--begin::Wizard Step 4 Nav-->
													<div class="wizard-step" data-wizard-type="step">
														<div class="wizard-label">
															<h3 class="wizard-title">
															<span>4.</span>Company Information</h3>
															<div class="wizard-bar"></div>
														</div>
													</div>
													<!--end::Wizard Step 4 Nav-->
												</div>
											</div>
											<!--end: Wizard Nav-->
											<!--begin: Wizard Body-->
											<div class="row py-10 px-8 py-lg-12 px-lg-17">
												<div class="col-xl-12 col-xxl-12">
													<!--begin: Wizard Form-->
													<form action="{{ route('admin.employee.save-edit-employee') }}" method="POST" enctype="multipart/form-data" class="form add-employee" id="kt_form">
                                                        @csrf
														<!--begin: Wizard Step 1-->
														<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
															<h4 class="mb-10 font-weight-bold text-dark">Enter Personal Detail</h4>
                                                           <input type="hidden" name="employee_id" class="form-control" value="{{ $employee_details->id}}">

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>First Name
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="first_name" id="first_name" value="{{ $employee_details->first_name }}" placeholder="First Name" autocomplete="off"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Last Name
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="last_name" id="last_name" value="{{ $employee_details->last_name }}" placeholder="last Name" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Technology Name
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <select class="form-control select2 technology" id="technology"  name="technology" >
                                                                            <option value="">Please select Technology Name</option>
                                                                            @foreach ($technology  as $key => $value )
                                                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $employee_details->department ? 'selected="selected"' : '' }}>{{ $value['technology_name'] }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Date Of Birth
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control datepicker_date" name="dob" id="dob" value="{{ $employee_details->DOB }}"  placeholder="Date Of Birth" autocomplete="off" />
                                                                    </div>
                                                                </div>
															</div>
															<div class="row">
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Date Of joining
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control datepicker_date" name="doj" id="doj" value="{{ $employee_details->DOJ }}" placeholder="Date Of Joining" autocomplete="off"/>
                                                                    </div>
                                                                </div>
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Gmail
                                                                        </label>
																		<input type="email" class="form-control" name="gmail" id="gmail"  value="{{ $employee_details->gmail }}" placeholder="Gmail" autocomplete="off"/>
                                                                    </div>
                                                                </div>
															</div>
                                                            <div class="row">
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Gmail Password
                                                                        </label>
																		<input type="text" class="form-control" name="gmail_password" id="gmail_password"  value="{{ $employee_details->password }}" placeholder="Gmail Password" autocomplete="off"/>
                                                                    </div>
                                                                </div>
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Slack Password
                                                                        </label>
																		<input type="text" class="form-control" name="slack_password" id="slack_password"  value="{{ $employee_details->slack_password }}" placeholder="Slack Password" autocomplete="off"/>
                                                                    </div>
                                                                </div>
															</div>
                                                            <div class="row">
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Personal Email
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="email" class="form-control" name="personal_email" id="personal_email" value="{{ $employee_details->personal_email }}" placeholder="Personal Email" autocomplete="off"/>
                                                                    </div>
                                                                </div>
															</div>
														</div>
														<!--end: Wizard Step 1-->
														<!--begin: Wizard Step 2-->
														<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
															<h4 class="mb-10 font-weight-bold text-dark">Enter Bank Detail</h4>

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Bank Name
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="bank_name" id="bank_name" value="{{ $employee_details->bank_name }}" placeholder="Bank Name" autocomplete="off"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Account Holder Name
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="acc_holder_name" id="acc_holder_name" value="{{ $employee_details->acc_holder_name }}" placeholder="Account Holder Name" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                            </div>
															<div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Account Number
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="account_number" id="account_number" value="{{ $employee_details->account_number }}" placeholder="Account Number" autocomplete="off"/>
                                                                    </div>
                                                                </div>
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>IFSC Code
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="{{ $employee_details->ifsc_number }}" placeholder="IFSC Code" autocomplete="off"/>
                                                                    </div>
                                                                </div>
															</div>
															<div class="row">
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Pan Number
                                                                        </label>
																		<input type="string" class="form-control" name="pan_number"  value="{{ $employee_details->pan_number }}" id="pan_number" placeholder="Pan Number" autocomplete="off"/>
                                                                    </div>
                                                                </div>
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Aadhar Card Number
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="string" class="form-control" name="aadhar_card_number" id="aadhar_card_number"  value="{{ $employee_details->aadhar_card_number }}" placeholder="Aadhar Card Number" autocomplete="off"/>
                                                                    </div>
                                                                </div>
															</div>
                                                            <div class="row">
																<div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Google Pay Number
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="string" class="form-control" name="google_pay" id="google_pay"  value="{{ $employee_details->google_pay_number }}" placeholder="Google Pay Number" autocomplete="off"/>
                                                                    </div>
                                                                </div>
															</div>
														</div>
														<!--end: Wizard Step 2-->
														<!--begin: Wizard Step 3-->
														<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
															<h4 class="mb-10 font-weight-bold text-dark">Enter Parent Detail</h4>

                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <div class="form-group">
                                                                        <label>Parents Name
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="parent_name" id="parent_name" value="{{ $employee_details->parents_name }}" placeholder="Parent Name" autocomplete="off"/>
                                                                    </div>
                                                                </div>

                                                            </div>
															<div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Personal Number
                                                                        </label>
																		<input type="number" class="form-control" name="personal_number" id="personal_number"  value="{{ $employee_details->personal_number }}" placeholder="Personal Number" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Emergency Contact
                                                                        </label>
																		<input type="number" class="form-control" name="emergency_contact" id="emergency_contact" value="{{ $employee_details->emergency_number }}" placeholder="Emergency Contact" autocomplete="off"/>
                                                                    </div>
                                                                </div>

															</div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Address
                                                                            <span class="text-danger">*</span>
                                                                        </label>
                                                                        <textarea class="form-control" id="" cols="30" rows="10" name="address" id="address" autocomplete="off">{{ $employee_details->address }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
														</div>
														<!--end: Wizard Step 3-->
														<!--begin: Wizard Step 4-->
														<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
															<h4 class="mb-10 font-weight-bold text-dark">Company Information</h4>

                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Experience
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="number" class="form-control" name="experience" id="experience" value="{{ $employee_details->experience }}" placeholder="Experience" autocomplete="off"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Hired By
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="text" class="form-control" name="hired_by" id="hired_by"  value="{{ $employee_details->hired_by }}" placeholder="Hired By" autocomplete="off"/>
                                                                    </div>
                                                                </div>

                                                            </div>
															<div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>salary
                                                                            <span class="text-danger">*</span>
                                                                        </label>
																		<input type="number" class="form-control" name="salary" id="salary"  value="{{ $employee_details->salary }}" placeholder="Salary" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Stipend From
                                                                        </label>
																		<input type="text" class="form-control datepicker_date" name="stipend_from" id="stipend_from"  value="{{ $employee_details->stipend_from }}" placeholder="Stippend From" autocomplete="off"/>
                                                                    </div>
                                                                </div>

															</div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Bond Last Date
                                                                        </label>
																		<input type="text" class="form-control datepicker_date" name="bond_last_date" id="bond_last_date" value="{{ $employee_details->bond_last_date }}" placeholder="Bond Last Date" autocomplete="off"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Resign Date
                                                                        </label>
																		<input type="text" class="form-control datepicker_date" name="resign_date" id="resign_date" value="{{ $employee_details->resign_date }}" placeholder="Resign Date" autocomplete="off" />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Last Date
                                                                        </label>
																		<input type="text" class="form-control datepicker_date" name="last_date" id="last_date" value="{{ $employee_details->last_date }}" placeholder="Last Date" autocomplete="off" />
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
                                                                <div class="col-xl-6">
                                                                    <div class="form-group">
                                                                        <label>Status <span class="text-danger">*</span></label>
                                                                        <div class="radio-inline" style="margin-top:10px">
                                                                            <label class="radio radio-lg radio-success" >
                                                                            <input type="radio" name="status" class="radio-btn" value="A" checked="checked"/>
                                                                            <span></span>Active</label>
                                                                            <label class="radio radio-lg radio-danger" >
                                                                            <input type="radio" name="status" class="radio-btn" value="I"/>
                                                                            <span></span>Inactive</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label>Trainee Performance
                                                                        </label>
                                                                        <textarea class="form-control" id="" cols="30" rows="10" name="trainee_performance" id="trainee_performance" autocomplete="off">{{ $employee_details->trainee_performance }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
														</div>
														<!--end: Wizard Step 4-->
														<!--begin: Wizard Actions-->
														<div class="d-flex justify-content-between border-top mt-5 pt-10">
															<div class="mr-2">
																<button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
															</div>
															<div>
																<button type="submit" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit" >Submit</button>
																<button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
															</div>
														</div>
														<!--end: Wizard Actions-->
													</form>
													<!--end: Wizard Form-->
												</div>
											</div>
											<!--end: Wizard Body-->
										</div>
										<!--end: Wizard-->
                        </div>
                    </div>
                    <!--end::Card-->

                </div>

            </div>
        </div>
        <!--end::Container-->
    </div> --}}
    <!--end::Entry-->

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
                        <form id="edit-employee-form" action="{{  route('admin.employee.save-edit-employee') }}" method="post" enctype="multipart/form-data" class="form">
                            @csrf
                            <!-- Step 1 -->
                            <div class="pb-5 step m-5" id="step1">
                                <h4 class="mb-10 font-weight-bold text-dark">Enter Personal Detail</h4>
                                <input type="hidden" name="employee_id" class="form-control" value="{{ $employee_details->id}}">
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>First Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control input-name" name="first_name" id="first_name" value="{{ $employee_details->first_name }}" placeholder="First Name" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Last Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control input-name" name="last_name" id="last_name" value="{{ $employee_details->last_name }}" placeholder="last Name" autocomplete="off" />
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
                                            <select class="form-control select2 branch input-name" id="branch" name="branch">
                                                <option value="">Please select Branch Name</option>
                                                @foreach (user_branch()  as $key => $value )
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $employee_details->branch ? 'selected="selected"' : '' }}>{{ $value['branch_name'] }}</option>
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
                                            <select class="form-control select2 technology input-name" id="technology"  name="technology" >
                                                <option value="">Please select Technology Name</option>
                                                @foreach ($technology  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $employee_details->department ? 'selected="selected"' : '' }}>{{ $value['technology_name'] }}</option>
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
                                            <select class="form-control select2 designation input-name" id="designation" name="designation">
                                                <option value="">Please select Designation Name</option>
                                                @foreach ($designation  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $employee_details->designation ? 'selected="selected"' : '' }}>{{ $value['designation_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Date Of Birth
                                            </label>
                                            <input type="text" class="form-control datepicker_date date_of_birth input-name" name="dob" id="dob" value="{{ $employee_details->DOB != null && $employee_details->DOB != '' ? date_formate($employee_details->DOB) : '' }}" max="{{ date('Y-m-d') }}" placeholder="Date Of Birth" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Date Of joining
                                            </label>
                                            <input type="text" class="form-control datepicker_date input-name" name="doj" id="doj" value="{{ $employee_details->DOJ != null && $employee_details->DOJ != '' ? date_formate($employee_details->DOJ) : '' }}" placeholder="Date Of Joining" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Company Gmail
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" class="form-control input-name" name="gmail" id="gmail" value="{{ $employee_details->gmail }}" placeholder="Gmail" autocomplete="off" />
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
                                            <input type="text" class="form-control input-name" name="gmail_password" id="gmail_password" value="{{ $employee_details->gmail_password }}" placeholder="Gmail Password" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Personal Email
                                            </label>
                                            <input type="email" class="form-control input-name" name="personal_email" id="personal_email" value="{{ $employee_details->personal_email }}" placeholder="Personal Email" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Slack Password
                                            </label>
                                            <input type="text" class="form-control input-name" name="slack_password" id="slack_password" value="{{ $employee_details->slack_password }}" placeholder="Slack Password" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <div class="radio-inline" style="margin-top:10px">
                                                <label class="radio radio-lg radio-success" >
                                                <input type="radio" name="status" class="radio-btn" value="W" {{ $employee_details->status == 'W' ? 'checked="checked"' : '' }}/>
                                                <span></span>Working</label>
                                                <label class="radio radio-lg radio-danger" >
                                                <input type="radio" name="status" class="radio-btn" value="L" {{ $employee_details->status == 'L' ? 'checked="checked"' : '' }}/>
                                                <span></span>Left</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" data-next-page="2" data-current-page="1" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 float-right mb-2 next-step">Next</button>
                            </div>

                            <!-- Step 2 -->
                            <div class="pb-5 step m-5 " id="step2" style="display: none">
                                <h4 class="mb-10 font-weight-bold text-dark">Enter Bank Detail</h4>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Bank Name
                                            </label>
                                            <input type="text" class="form-control input-name" name="bank_name" id="bank_name" value="{{ $employee_details->bank_name }}" placeholder="Bank Name" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Account Holder Name
                                            </label>
                                            <input type="text" class="form-control input-name" name="acc_holder_name" id="acc_holder_name" value="{{ $employee_details->acc_holder_name }}" placeholder="Account Holder Name" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Account Number
                                            </label>
                                            <input type="text" class="form-control input-name onlyNumber" name="account_number" id="account_number" value="{{ $employee_details->account_number }}" placeholder="Account Number" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>IFSC Code
                                            </label>
                                            <input type="text" class="form-control input-name" maxlength="11" name="ifsc_code" id="ifsc_code" value="{{ $employee_details->ifsc_number }}" placeholder="IFSC Code" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Pan Number
                                            </label>
                                            <input type="text" class="form-control input-name" name="pan_number" id="pan_number" value="{{ $employee_details->pan_number }}" maxlength="11" placeholder="Pan Number" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Aadhar Card Number
                                            </label>
                                            <input type="text" class="form-control input-name onlyNumber " name="aadhar_card_number" id="aadhar_card_number" value="{{ $employee_details->aadhar_card_number }}" maxlength="12" placeholder="Aadhar Card Number" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Google Pay Number
                                            </label>
                                            <input type="text" class="form-control input-name onlyNumber" name="google_pay" id="google_pay" maxlength="10" value="{{ $employee_details->google_pay_number }}" placeholder="Google Pay Number" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-container d-flex justify-content-between float-right">
                                    <button type="button" data-prev-page="1" data-current-page="2" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 prev-step" >Previous</button>
                                    <button type="button" data-next-page="3" data-current-page="2" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 next-step">Next</button>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="pb-5 step m-5 " id="step3" style="display: none">
                                <h4 class="mb-10 font-weight-bold text-dark">Enter Parent Detail</h4>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <label>Parents Name
                                            </label>
                                            <input type="text" class="form-control input-name" name="parent_name" id="parent_name" value="{{ $employee_details->parents_name }}" placeholder="Parent Name" autocomplete="off" />
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
                                            <input type="text" class="form-control  input-name" name="personal_number" id="personal_number" maxlength="10" value="{{ $employee_details->personal_number }}" placeholder="Personal Number" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Emergency Contact
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control onlyNumber input-name" name="emergency_contact" id="emergency_contact" maxlength="10" value="{{ $employee_details->emergency_number }}" placeholder="Emergency Contact" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address
                                            </label>
                                            <textarea class="form-control input-name" id="" cols="30" rows="10" name="address" id="address" autocomplete="off">{{ $employee_details->address }}</textarea>
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-container d-flex justify-content-between float-right">
                                    <button type="button" data-prev-page="2" data-current-page="3"class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 prev-step">Previous</button>
                                    <button type="button" data-next-page="4" data-current-page="3"class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 next-step">Next</button>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="pb-5 step m-5 " id="step4" style="display: none">
                                <h4 class="mb-10 font-weight-bold text-dark">Company Information</h4>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Experience
                                            </label>
                                            <input type="number" class="form-control input-name" name="experience" id="experience" value="{{numberformat( $employee_details->experience, 0) }}" placeholder="Experience" autocomplete="off" />
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
                                                <option value="{{ $value['id'] }}"  {{ $value['id'] == $employee_details->hired_by ? 'selected="selected"' : '' }}>{{ $value['manager_name'] }}</option>
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
                                            <input type="number" class="form-control input-name" name="salary" id="salary" value="{{ numberformat( $employee_details->salary, 0)  }}" placeholder="Salary" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Stipend From
                                            </label>
                                            <input type="text" class="form-control datepicker_date" name="stipend_from" id="stipend_from" value="{{ $employee_details->stipend_from != null && $employee_details->stipend_from != '' ? date_formate($employee_details->stipend_from) : '' }}" placeholder="Stippend From" autocomplete="off" />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Bond Last Date
                                            </label>
                                            <input type="text" class="form-control datepicker_date" name="bond_last_date" id="bond_last_date" value="{{ $employee_details->bond_last_date != null && $employee_details->bond_last_date != '' ? date_formate($employee_details->bond_last_date) : '' }}" placeholder="Bond Last Date" autocomplete="off" />
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Resign Date
                                            </label>
                                            <input type="text" class="form-control datepicker_date" name="resign_date" id="resign_date" value="{{ $employee_details->resign_date != null && $employee_details->resign_date != '' ? date_formate($employee_details->resign_date) : '' }}" placeholder="Resign Date" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Last Date
                                            </label>
                                            <input type="text" class="form-control datepicker_date" name="last_date" id="last_date" value="{{ $employee_details->last_date != null && $employee_details->last_date != '' ? date_formate($employee_details->last_date) : '' }}" placeholder="Last Date" autocomplete="off" />
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
                                            <textarea class="form-control" id="" cols="30" rows="10" name="trainee_performance" id="trainee_performance" autocomplete="off">{{ $employee_details->trainee_performance }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="button-container d-flex justify-content-between float-right">
                                    <button type="button" data-prev-page="3" data-current-page="4" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4 float-right m-1 mb-2 prev-step">Previous</button>
                                    <button type="submit" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4 float-right m-1 mb-2">Submit</button>
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


