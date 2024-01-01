<div class="card-header py-3">
    <div class="card-title align-items-start flex-column">
        <h3 class="card-label font-weight-bolder text-dark">Bank Information</h3>
    </div>
    <div class="card-toolbar">
    </div>
</div>
<!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Bank Name</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->bank_name }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Account Holder Name</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->acc_holder_name}}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Account Number</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->account_number}}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">IFSC Code</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->ifsc_number }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Pancard Number</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value=" {{ $employee_details->pan_number }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Aadhar Card Number</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->aadhar_card_number}}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Google Pay Number</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->google_pay_number  }}" />
            </div>
        </div>
    </div>
