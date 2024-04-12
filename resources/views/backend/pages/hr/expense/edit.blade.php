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
                        <form class="form" id="edit-hr-expense" method="POST" action="{{ route('admin.hr.expense.save-edit-expense') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <input type="hidden" name="editId"  class="form-control" value="{{ $hr_expense_details->id}}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Enter Date" autocomplete="off" value="{{ date_formate($hr_expense_details->date) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Month
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 month" id="hrExpenseMonthId"  name="month" >
                                                <option value="">Please Select month name</option>
                                                <option value="1" {{ $hr_expense_details->month == 1 ? 'selected="selected"' : '' }}>January</option>
                                                <option value="2" {{ $hr_expense_details->month == 2 ? 'selected="selected"' : '' }}>February</option>
                                                <option value="3" {{ $hr_expense_details->month == 3 ? 'selected="selected"' : '' }}>March</option>
                                                <option value="4" {{ $hr_expense_details->month == 4 ? 'selected="selected"' : '' }}>April</option>
                                                <option value="5" {{ $hr_expense_details->month == 5 ? 'selected="selected"' : '' }}>May</option>
                                                <option value="6" {{ $hr_expense_details->month == 6 ? 'selected="selected"' : '' }}>June</option>
                                                <option value="7" {{ $hr_expense_details->month == 7 ? 'selected="selected"' : '' }}>July</option>
                                                <option value="8" {{ $hr_expense_details->month == 8 ? 'selected="selected"' : '' }}>August</option>
                                                <option value="9" {{ $hr_expense_details->month == 9 ? 'selected="selected"' : '' }}>September</option>
                                                <option value="10" {{ $hr_expense_details->month == 10 ? 'selected="selected"' : '' }}>October</option>
                                                <option value="11" {{ $hr_expense_details->month == 11 ? 'selected="selected"' : '' }}>November</option>
                                                <option value="12" {{ $hr_expense_details->month == 12 ? 'selected="selected"' : '' }}>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>amount
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="amount" class="form-control onlyNumber" placeholder="Enter Amount" autocomplete="off" value="{{ numberformat($hr_expense_details->amount) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>remarks
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="1" name="remarks" id="remarks">{{ $hr_expense_details->remarks}}</textarea>
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
