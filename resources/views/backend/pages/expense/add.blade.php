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
                        <form class="form" id="add-expense-users" method="POST" action="{{ route('admin.expense.save-add-expense') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Manager Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 manager_id" id="manager_id"  name="manager_id">
                                                <option value="">Please select Manager Name</option>
                                                @foreach ($manager  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Branch Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 branch" id="branch"  name="branch_id">
                                                <option value="">Please select Branch Name</option>
                                                @foreach (user_branch()  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{  $_COOKIE['branch'] == $value['id'] ? 'selected="selected"' : '' }}>{{ $value['branch_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Type Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 type" id="type"  name="type_id">
                                                <option value="">Please select Type Name</option>
                                                @foreach ($type  as $key => $value )
                                                    <option value="{{ $value['id'] }}">{{ $value['type_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Enter Date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Month
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 month" id="expenseMonthId"  name="month" disabled="disabled">
                                                <option value="">Month of salary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>year</label>
                                            <span class="text-danger">*</span>
                                            <select class="form-control select2 year change" id="expenseYearId"  name="year">
                                                <option value="">Select Year</option>
                                                @for ($i = 2019; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>amount
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="amount" class="form-control onlyNumber" placeholder="Enter Amount" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>remarks
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="10" name="remarks" id="remarks"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
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
