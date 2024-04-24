@extends('backend.layout.app')
@section('section')
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
                        <!--begin::Form-->
                        <form class="form" id="edit-salary-slip" method="POST"
                            action="{{ route('admin.employee-salaryslip.save-edit-employee-salaryslip') }}">@csrf
                            <div class="card-body">
                                <div class="col-12">
                                    <h3 class="card-title">EMPLOYEE DETAILS</h3>
                                </div>
                                <div class="col-12">
                                    <input type="hidden" name="salary_slip_id" class="form-control"
                                        value="{{ $salary_slip_details->id }}">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="" for="exampleSelect1">Department <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control employee-change select2" id="empDepartment"
                                                    name="empDepartment">
                                                    <option value="">Select Employee Department</option>
                                                    @foreach ($technology as $key => $value)
                                                        <option value="{{ $value['id'] }}"
                                                            {{ $value['id'] == $salary_slip_details->department ? 'selected="selected"' : '' }}>
                                                            {{ $value['technology_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Designation<span class="text-danger">*</span></label>
                                                <select class="form-control employee-change select2" name="empDesignation"
                                                    id="empDesignation">
                                                    <option value="">Select Employee Designation</option>
                                                    @foreach ($designation as $key => $value)
                                                        <option value="{{ $value['id'] }}"
                                                            {{ $value['id'] == $salary_slip_details->designation ? 'selected="selected"' : '' }}>
                                                            {{ $value['designation_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Employee<span class="text-danger">*</span></label>
                                                <select class="form-control employee select2" name="employee"
                                                    id="employeeSalarySlipId">
                                                    <option value="">Select Employee </option>
                                                    @foreach ($employee as $key => $value)
                                                        <option value="{{ $value['id'] }}"
                                                            {{ $value['id'] == $salary_slip_details->employee ? 'selected="selected"' : '' }}>
                                                            {{ $value['first_name'] . ' ' . $value['last_name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Month<span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="month" id="salarySlipMonthId">
                                                    <option value="">Select Salary Slip Month </option>
                                                    <option value="1"
                                                        {{ $salary_slip_details->month == 1 ? 'selected="selected"' : '' }}>
                                                        January</option>
                                                    <option value="2"
                                                        {{ $salary_slip_details->month == 2 ? 'selected="selected"' : '' }}>
                                                        February</option>
                                                    <option value="3"
                                                        {{ $salary_slip_details->month == 3 ? 'selected="selected"' : '' }}>
                                                        March</option>
                                                    <option value="4"
                                                        {{ $salary_slip_details->month == 4 ? 'selected="selected"' : '' }}>
                                                        April</option>
                                                    <option value="5"
                                                        {{ $salary_slip_details->month == 5 ? 'selected="selected"' : '' }}>
                                                        May</option>
                                                    <option value="6"
                                                        {{ $salary_slip_details->month == 6 ? 'selected="selected"' : '' }}>
                                                        June</option>
                                                    <option value="7"
                                                        {{ $salary_slip_details->month == 7 ? 'selected="selected"' : '' }}>
                                                        July</option>
                                                    <option value="8"
                                                        {{ $salary_slip_details->month == 8 ? 'selected="selected"' : '' }}>
                                                        August</option>
                                                    <option value="9"
                                                        {{ $salary_slip_details->month == 9 ? 'selected="selected"' : '' }}>
                                                        September</option>
                                                    <option value="10"
                                                        {{ $salary_slip_details->month == 10 ? 'selected="selected"' : '' }}>
                                                        October</option>
                                                    <option value="11"
                                                        {{ $salary_slip_details->month == 11 ? 'selected="selected"' : '' }}>
                                                        November</option>
                                                    <option value="12"
                                                        {{ $salary_slip_details->month == 12 ? 'selected="selected"' : '' }}>
                                                        December</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Year<span class="text-danger">*</span></label>
                                                <select class="form-control select2" name="year" id="SalarySlipYearId">
                                                    <option value="">Select Salary Slip Year </option>
                                                    @for ($i = 2015; $i <= date('Y'); $i++)
                                                        <option value="{{ $i }}"
                                                            {{ $salary_slip_details->year == $i ? 'selected="selected"' : '' }}>
                                                            {{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Pay Salary Date</label>
                                                <input type="text" class="form-control datepicker_date" name="pay_salary"
                                                    value="{{ date_formate($salary_slip_details->pay_salary_date) }}"
                                                    placeholder="Please enter your Pay Salary date" autocomplete="off" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="" for="exampleSelect1">Basic Salary <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="basic"
                                                    value="{{ $salary_slip_details->basic_salary }}" name="basic">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="" for="exampleSelect1">Working Day <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="wd"
                                                    value="{{ $salary_slip_details->working_day }}" name="wd">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="" for="exampleSelect1">Loss Of Pay(LOP) <span
                                                        class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="lop"
                                                    value="{{ $salary_slip_details->loss_of_pay }}" name="lop">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if (
                                    $salary_slip_details['old_basic_salary'] !== null ||
                                        $salary_slip_details['old_working_day'] !== null ||
                                        $salary_slip_details['old_loss_of_pay'] !== null)
                                    <div class="col-12">
                                        <h4 class="card-title">AFTER INCREMENT</h4>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="" for="exampleSelect1">Basic Salary <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control " type="number" id="basic"
                                                        value="{{ $salary_slip_details->old_basic_salary }}"
                                                        name="basic_old">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="" for="exampleSelect1">Working Day <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control " type="number" id="wd"
                                                        value="{{ $salary_slip_details->old_working_day }}"
                                                        name="wd_old">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label class="" for="exampleSelect1">Loss Of Pay(LOP) <span
                                                            class="text-danger">*</span></label>
                                                    <input class="form-control " type="number" id="lop"
                                                        value="{{ $salary_slip_details->old_loss_of_pay }}"
                                                        name="lop_old">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row ml-1">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="card-title">HOUSE RENT ALLOWANCE</h3>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>House Rent Allowance(%) <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control " type="number" id="hra_pr"
                                                                value="{{ $salary_slip_details->house_rent_allow_pr }}"
                                                                name="hra_pr">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>House Rent Allowance(Amount) <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control " type="number" id="hra"
                                                                value="{{ $salary_slip_details->house_rent_allow }}"
                                                                name="hra">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="col-12">
                                            <h3 class="card-title">INCOME TAX</h3>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Income Tax(%) <span class="text-danger">*</span></label>
                                                        <input class="form-control " type="number" id="income_tax_pr"
                                                            value="{{ $salary_slip_details->income_tax_pr }}"
                                                            name="income_tax_pr">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label>Income Tax(Amount) <span
                                                                class="text-danger">*</span></label>
                                                        <input class="form-control " type="number" id="income_tax"
                                                            value="{{ $salary_slip_details->income_tax }}"
                                                            name="income_tax">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ml-1">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3 class="card-title">PROVIDENT FUND </h3>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Provident Fund (%) <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control " type="number" id="pf_pr"
                                                                value="{{ $salary_slip_details->pf_pr }}" name="pf_pr">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Provident Fund (Amount) <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control " type="number" id="pf"
                                                                value="{{ $salary_slip_details->pf }}" name="pf">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row ml-1">
                                            <div class="col-12">
                                                <h3 class="card-title">PROFESSIONAL TAX</h3>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Professional Tax(%) <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control " type="number" id="pro_tax_pr"
                                                                value="{{ $salary_slip_details->pt_pr }}"
                                                                name="pro_tax_pr">
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Professional Tax(Amount) <span
                                                                    class="text-danger">*</span></label>
                                                            <input class="form-control " type="number" id="pro_tax"
                                                                value="{{ $salary_slip_details->pt }}" name="pro_tax">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a
                                        href="{{ route('admin.employee-salaryslip.list') }}">Cancel</a></button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->

                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
