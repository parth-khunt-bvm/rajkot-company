 <!--begin::Header-->
 <div class="card-header py-3">
    <div class="card-title align-items-start flex-column">
        <h3 class="card-label font-weight-bolder text-dark">Parent Information</h3>
    </div>
    <div class="card-toolbar">
    </div>
</div>
<!--end::Header-->
    <div class="card-body">
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Parents Name </label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->parents_name }}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Personal Number</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->personal_number}}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Emergency Contact</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value="{{ $employee_details->emergency_number}}" />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-xl-3 col-lg-3 col-form-label">Address</label>
            <div class="col-lg-9 col-xl-6">
                <input class="form-control form-control-lg form-control-solid" type="text" value=" {{ $employee_details->address}}" />
            </div>
        </div>
    </div>
