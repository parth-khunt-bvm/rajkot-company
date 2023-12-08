@php
if(file_exists( public_path().'/employee/cheque/'.$employee_details['cancel_cheque']) && $employee_details['cancel_cheque'] != ''){
$image = url("employee/cheque/".$employee_details['cancel_cheque']);
}else{
$image = url("upload/userprofile/default.jpg");
}
@endphp
<!--begin::Header-->
 <div class="card-header py-3">
    <div class="card-title align-items-start flex-column">
        <h3 class="card-label font-weight-bolder text-dark">Company Information</h3>
    </div>
    <div class="card-toolbar">
    </div>
</div>
<!--end::Header-->
    <div class="card-body">
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Experience</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ numberformat( $employee_details->experience, 0)  }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Hired By</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->hired_by }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Salary</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value=" {{ numberformat( $employee_details->salary, 0)  }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">stipend from</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value=" {{ $employee_details->stipend_from}}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Bond Last Date</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->bond_last_date }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Resign Date</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value=" {{ $employee_details->resign_date }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Last Date</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->last_date }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Trainee Performance</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->trainee_performance ?? "-" }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Cancel Cheque</label>
            <div class="col-lg-9 col-xl-6">
                <div class="image-input image-input-outline" id="kt_profile_avatar" style="background-image: url(assets/media/users/blank.png)">
                    {{-- <div class="image-input-wrapper" style="background-image: url(public/upload/userprofile/default.jpg)"></div> --}}
                    <img class="" src="{{ $image }}" alt="" style="">
                </div>
            </div>
        </div>
    </div>
    <!--end::Body-->
