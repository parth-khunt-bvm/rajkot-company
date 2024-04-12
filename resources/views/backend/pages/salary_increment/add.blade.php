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
                        <form class="form" id="add-salary-increment" method="POST" action="{{ route('admin.salary-increment.save-add-salary-increment') }}" autocomplete="off" novalidate="novalidate" >@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Employee Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 employee_id" id="employee_id"  name="employee_id">
                                                <option value="">Please select Employee Name</option>
                                                @foreach ($employee  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['first_name'] .' '. $value['last_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Previous Salary
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control input-name" name="previous_salary" id="previous_salary" placeholder="Previous Salary" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Current Salary
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control input-name" name="current_salary" id="current_salary" placeholder="Current Salary" autocomplete="off" />
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Start From <span class="text-danger">*</span></label>
                                            <input type="text" name="start_from" id="datepicker_date" class="form-control date" placeholder="Select Date" value="" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a href="{{route('admin.salary.list')}}">Cancel</a></button>
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
