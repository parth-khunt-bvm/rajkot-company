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
                    <form class="form" id="add-salary-slip" method="POST" action="{{ route('admin.employee-salaryslip.save-add-employee-salaryslip') }}">@csrf
                        <div class="card-body">
                            <div class="col-12">
                                <h3 class="card-title">EMPLOYEE DETAILS</h3>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="" for="exampleSelect1">Department <span class="text-danger">*</span></label>
                                            <select class="form-control employee-change select2" id="empDepartment" name="empDepartment">
                                                <option value="">Select Employee Department</option>
                                                 @foreach ($technology  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['technology_name'] }}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Designation<span class="text-danger">*</span></label>
                                            <select class="form-control employee-change select2" name="empDesignation" id="empDesignation">
                                                <option value="">Select Employee Designation</option>
                                                @foreach ($designation  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['designation_name'] }}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Employee<span class="text-danger">*</span></label>
                                            <select class="form-control employee select2" name="employee" id="employeeSalarySlipId">
                                                <option value="">Select Employee </option>
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
                                                <option value="1">January </option>
                                                <option value="2">February </option>
                                                <option value="3">March </option>
                                                <option value="4">April </option>
                                                <option value="5">May </option>
                                                <option value="6">June </option>
                                                <option value="7">July </option>
                                                <option value="8">August </option>
                                                <option value="9">September </option>
                                                <option value="10">October </option>
                                                <option value="11">November </option>
                                                <option value="12">December </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Year<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="year" id="SalarySlipYearId">
                                                <option value="">Select Salary Slip Year </option>
                                                @for($i = 2015; $i <= date("Y") ; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Pay Salary Date</label>
                                            <input type="text" class="form-control datepicker_date" name="pay_salary" placeholder="Please enter your Pay Salary date" autocomplete="off" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="" for="exampleSelect1">BASIC SALARY <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="basic" value="0" name="basic">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="" for="exampleSelect1">WORKING DAY <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="wd" value="0" name="wd">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="" for="exampleSelect1">Loss Of Pay(LOP) <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="lop" value="0" name="lop">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="salary-icrement">
                            </div>

                            <div class="row ml-1">
                                <div class="col-6">
                                    <h3 class="card-title">HOUSE RENT ALLOWANCE</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>HOUSE RENT ALLOWANCE(%) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="hra_pr" value="0" name="hra_pr">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>HOUSE RENT ALLOWANCE(Amount) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="hra" value="0" name="hra">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="card-title">Income Tax</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Income Tax(%) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="income_tax_pr" value="0" name="income_tax_pr">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Income Tax(Amount) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="income_tax" value="0" name="income_tax">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row ml-1">
                                <div class="col-6">
                                    <h3 class="card-title">Provident Fund </h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Provident Fund (%) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="pf_pr" value="0" name="pf_pr">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>Provident Fund (Amount) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="pf" value="0" name="pf">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <h3 class="card-title">PROFESSIONAL Tax</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>PROFESSIONAL Tax(%) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="pro_tax_pr" value="0" name="pro_tax_pr">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label>PROFESSIONAL Tax(Amount) <span class="text-danger">*</span></label>
                                                <input class="form-control " type="number" id="pro_tax" value="0" name="pro_tax">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                            <button type="reset" class="btn btn-secondary"><a href="{{route('admin.employee-salaryslip.list')}}">Cancel</a></button>
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
