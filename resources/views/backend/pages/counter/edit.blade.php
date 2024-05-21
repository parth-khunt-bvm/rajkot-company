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
                    <form class="form" id="edit-counter-users" method="POST" action="{{ route('admin.counter.save-edit-counter') }}" autocomplete="off">@csrf
                        <div class="card-body">
                            <div class="row">
                                <input type="hidden" name="counter_id" class="form-control" value="{{ $counter_detail->id}}">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Month
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 month" id="counterMonthId"  name="month">
                                            <option value="1" {{ $counter_detail->month == 1 ? 'selected="selected"' : '' }}>January</option>
                                            <option value="2" {{ $counter_detail->month == 2 ? 'selected="selected"' : '' }}>February</option>
                                            <option value="3" {{ $counter_detail->month == 3 ? 'selected="selected"' : '' }}>March</option>
                                            <option value="4" {{ $counter_detail->month == 4 ? 'selected="selected"' : '' }}>April</option>
                                            <option value="5" {{ $counter_detail->month == 5 ? 'selected="selected"' : '' }}>May</option>
                                            <option value="6" {{ $counter_detail->month == 6 ? 'selected="selected"' : '' }}>June</option>
                                            <option value="7" {{ $counter_detail->month == 7 ? 'selected="selected"' : '' }}>July</option>
                                            <option value="8" {{ $counter_detail->month == 8 ? 'selected="selected"' : '' }}>August</option>
                                            <option value="9" {{ $counter_detail->month == 9 ? 'selected="selected"' : '' }}>September</option>
                                            <option value="10" {{ $counter_detail->month == 10 ? 'selected="selected"' : '' }}>October</option>
                                            <option value="11" {{ $counter_detail->month == 11 ? 'selected="selected"' : '' }}>November</option>
                                            <option value="12" {{ $counter_detail->month == 12 ? 'selected="selected"' : '' }}>December</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Year</label>
                                        <select class="form-control select2 year change" id="yearID" name="year">
                                            <option value="">Select Year</option>
                                            @for ($i = 2019; $i <= date('Y'); $i++)
                                                <option value="{{ $i }}" {{ $i == $counter_detail->year ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Employee Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 employee_id" id="employee_id" name="employee_id">
                                            <option value="">Please select Employee Name</option>
                                            @foreach ($employee  as $key => $value )
                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $counter_detail->employee_id ? 'selected="selected"' : '' }}>{{ $value['first_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Technology Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 technology" id="technology" name="technology_id">
                                            <option value="">Please select Technology Name</option>
                                            @foreach ($technology  as $key => $value )
                                            <option value="{{ $value['id'] }}" {{ $value['id'] == $counter_detail->technology_id ? 'selected="selected"' : '' }}>{{ $value['technology_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Present Days
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="present_day" id="present_day" class="form-control onlyNumber" placeholder="Enter Present Days" value="{{ numberformat( $counter_detail->present_days, 0)  }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Half Leaves
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="half_leaves" id="half_leaves" class="form-control onlyNumber" placeholder="Enter Half Leave" autocomplete="off" value="{{ $counter_detail->half_leaves }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Leaves
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="full_leaves" id="full_leaves" class="form-control onlyNumber" placeholder="Enter Full Leaves" autocomplete="off" value="{{ $counter_detail->full_leaves }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Paid Leave Detail
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="paid_leaves_details" id="paid_leaves_details" class="form-control " placeholder="Enter Paid Leave Detail" value="{{ $counter_detail->paid_leaves_details }}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Paid Date
                                        </label>
                                        <input type="text" name="paid_date" id="datepicker_date" class="form-control date" placeholder="Enter Present Days" value="{{ date_formate($counter_detail->paid_date) }}" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Salary Status
                                        </label>
                                        <input type="text" name="salary_status" id="salary_status" class="form-control " placeholder="Enter Salary Detail" autocomplete="off" value="{{ $counter_detail->salary_status }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Total Days
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="total_days" id="total_days" class="form-control onlyNumber" placeholder="Enter Present Days" autocomplete="off" value="{{ numberformat( $counter_detail->total_days, 0) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Salary Counted </label>
                                        <div class="radio-inline" style="margin-top:10px">
                                            <label class="radio radio-lg radio-success">
                                                <input type="radio" name="salary_counted" class="radio-btn" value="Y" checked="checked" />
                                                <span></span>Yes</label>
                                            <label class="radio radio-lg radio-danger">
                                                <input type="radio" name="salary_counted" class="radio-btn" value="N" />
                                                <span></span>No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note
                                        </label>
                                        <textarea class="form-control" id="" cols="30" rows="10" name="note" id="note"> {{ $counter_detail->note }}</textarea>
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
