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
                    <form class="form" id="add-all-employee-salary-slip" method="POST" action="{{ route('admin.all-employee-salaryslip.save-add-all-employee-salaryslip') }}">@csrf
                        <div class="card-body">
                            <div class="col-12">
                                <h3 class="card-title">EMPLOYEE DETAILS</h3>
                            </div>
                            <div class="col-12">
                                <div class="row">

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Month<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="month" id="monthId">
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

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Year<span class="text-danger">*</span></label>
                                            <select class="form-control select2" name="year" id="yearId">
                                                <option value="">Select Salary Slip Year </option>
                                                @for($i = 2015; $i <= date("Y") ; $i++) <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Pay Salary Date</label>
                                            <input type="text" class="form-control datepicker_date" name="pay_salary" placeholder="Please enter your Pay Salary date" autocomplete="off" />
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="" for="exampleSelect1">WORKING DAY <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="wd" value="0" name="wd">
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12">

                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>HOUSE RENT ALLOWANCE(%) <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="hra_pr" value="0" name="hra_pr">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Income Tax(%) <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="income_tax_pr" value="0" name="income_tax_pr">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Provident Fund (%) <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="pf_pr" value="0" name="pf_pr">
                                        </div>
                                    </div>

                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>PROFESSIONAL Tax(%) <span class="text-danger">*</span></label>
                                            <input class="form-control " type="number" id="pro_tax_pr" value="0" name="pro_tax_pr">
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
