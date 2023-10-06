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
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">{{ $header['title'] }}</h3>
                        </div>

                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>First Name</b> <br>
                                 {{ $employee_details->first_name }}
                            </div>
                            <div class="col-3">
                                <b>Last Name</b> <br>
                                 {{ $employee_details->last_name }}
                            </div>
                            <div class="col-3">
                                <b>DepartMent</b> <br>
                                 {{ $employee_details->technology_name }}
                            </div>
                            <div class="col-3">
                                <b>Date Of Birth</b> <br>
                                {{ $employee_details->DOB }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Date Of Joining</b> <br>
                                {{ $employee_details->DOJ }}
                            </div>
                            <div class="col-3">
                                <b>Gmail</b> <br>
                                 {{ $employee_details->gmail }}
                            </div>
                            <div class="col-3">
                                <b>Gmail Password</b> <br>
                                 {{ $employee_details->password}}
                            </div>
                            <div class="col-3">
                                <b>Slack Password</b> <br>
                                 {{ $employee_details->slack_password }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Personal Email</b> <br>
                                {{ $employee_details->personal_email }}
                            </div>
                            <div class="col-3">
                                <b>Bank Name</b> <br>
                                 {{ $employee_details->bank_name }}
                            </div>
                            <div class="col-3">
                                <b>Account Holder Name</b> <br>
                                 {{ $employee_details->acc_holder_name}}
                            </div>
                            <div class="col-3">
                                <b>Account Number</b> <br>
                                 {{ $employee_details->account_number }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>IFSC Code </b> <br>
                                {{ $employee_details->ifsc_number }}
                            </div>
                            <div class="col-3">
                                <b>Pancard Number</b> <br>
                                 {{ $employee_details->pan_number }}
                            </div>
                            <div class="col-3">
                                <b>Aadhar Card Number</b> <br>
                                 {{ $employee_details->aadhar_card_number}}
                            </div>
                            <div class="col-3">
                                <b>Google Pay Number</b> <br>
                                 {{ $employee_details->google_pay_number }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Parents Name </b> <br>
                                {{ $employee_details->parents_name }}
                            </div>
                            <div class="col-3">
                                <b>Personal Number</b> <br>
                                 {{ $employee_details->personal_number }}
                            </div>
                            <div class="col-3">
                                <b>Emergency Contact</b> <br>
                                 {{ $employee_details->emergency_number}}
                            </div>
                            <div class="col-3">
                                <b>Experience</b> <br>
                                 {{ numberformat( $employee_details->experience, 0)  }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Hired By </b> <br>
                                {{ $employee_details->hired_by }}
                            </div>
                            <div class="col-3">
                                <b>Salary</b> <br>
                                 {{ $employee_details->salary }}
                            </div>
                            <div class="col-3">
                                <b>stipend from</b> <br>
                                 {{ $employee_details->stipend_from}}
                            </div>
                            <div class="col-3">
                                <b>Bond Last Date</b> <br>
                                 {{ $employee_details->bond_last_date }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Resign Date</b> <br>
                                {{ $employee_details->resign_date }}
                            </div>
                            <div class="col-3">
                                <b>Last Date</b> <br>
                                 {{ $employee_details->last_date }}
                            </div>
                            <div class="col-3">
                                <b>Address</b> <br>
                                 {{ $employee_details->address}}
                            </div>
                            <div class="col-3">
                                <b>Trainee Performance</b> <br>
                                 {{ $employee_details->trainee_performance }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Cancel Cheque</b> <br>
                                <img src="{{ $image }}" alt="" style="height: 100px; width: 100px">
                            </div>
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
