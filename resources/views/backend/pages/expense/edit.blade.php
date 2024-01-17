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
                        <form class="form" id="edit-expense-users" method="POST" action="{{ route('admin.expense.save-edit-expense') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="editId"  class="form-control" placeholder="Enter manager name" value="{{ $expense_details->id}}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Manager Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 manager_id" id="manager_id"  name="manager_id">
                                                <option value="">Please select Manager Name</option>
                                                @foreach ($manager  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $expense_details->manager_id ? 'selected="selected"' : '' }}>{{ $value['manager_name'] }}</option>
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
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $expense_details->branch_id ? 'selected="selected"' : '' }}>{{ $value['branch_name'] }}</option>
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
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $expense_details->type_id ? 'selected="selected"' : '' }}>{{ $value['type_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Enter Date" value="{{ date_formate($expense_details->date) }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Month
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 month" id="month"  name="month" >
                                                <option value="1" {{ $expense_details->month == 1 ? 'selected="selected"' : '' }}>January</option>
                                                <option value="2" {{ $expense_details->month == 2 ? 'selected="selected"' : '' }}>February</option>
                                                <option value="3" {{ $expense_details->month == 3 ? 'selected="selected"' : '' }}>March</option>
                                                <option value="4" {{ $expense_details->month == 4 ? 'selected="selected"' : '' }}>April</option>
                                                <option value="5" {{ $expense_details->month == 5 ? 'selected="selected"' : '' }}>May</option>
                                                <option value="6" {{ $expense_details->month == 6 ? 'selected="selected"' : '' }}>June</option>
                                                <option value="7" {{ $expense_details->month == 7 ? 'selected="selected"' : '' }}>July</option>
                                                <option value="8" {{ $expense_details->month == 8 ? 'selected="selected"' : '' }}>August</option>
                                                <option value="9" {{ $expense_details->month == 9 ? 'selected="selected"' : '' }}>September</option>
                                                <option value="10" {{ $expense_details->month == 10 ? 'selected="selected"' : '' }}>October</option>
                                                <option value="11" {{ $expense_details->month == 11 ? 'selected="selected"' : '' }}>November</option>
                                                <option value="12" {{ $expense_details->month == 12 ? 'selected="selected"' : '' }}>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>year</label>
                                            <span class="text-danger">*</span>
                                            <select class="form-control select2 year change" id="yearId" name="year">
                                                <option value="">Select Year</option>
                                                @for ($i = 2019; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ $i == $expense_details->year ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>amount
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="amount" class="form-control onlyNumber" placeholder="Enter Amount" autocomplete="off" value="{{ $expense_details->amount }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>remarks
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="10" name="remarks" id="remarks" >{{ $expense_details->remarks }}</textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a href="{{route('admin.expense.list')}}">Cancel</a></button>
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
