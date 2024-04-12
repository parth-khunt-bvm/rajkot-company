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
                        <form class="form" id="edit-salary-users" method="POST" action="{{ route('admin.salary.save-edit-salary') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="hidden" name="editId"  class="form-control" placeholder="Enter manager name" value="{{ $salary_details->id}}">
                                            <label>Manager Name
                                                <span class="text-danger">*</span>
                                            </label>

                                            <select class="form-control select2 manager_id" id="manager_id"  name="manager_id">
                                                <option value="">Please select Manager Name</option>
                                                @foreach ($manager  as $key => $value )
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $salary_details->manager_id ? 'selected="selected"' : '' }}>{{ $value['manager_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Branch Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 branch" id="branch"  name="branch_id">
                                                <option value="">Please select Branch Name</option>
                                                @foreach (user_branch()  as $key => $value )
                                                    <option value="{{ $value['id'] }}" {{ $value['id'] == $salary_details->branch_id ? 'selected="selected"' : '' }}>{{ $value['branch_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Technology Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 technology" id="technology"  name="technology_id">
                                                <option value="">Please select Technology Name</option>
                                                @foreach ($technology  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $salary_details->technology_id ? 'selected="selected"' : '' }}>{{ $value['technology_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Enter Date" autocomplete="off" value="{{ date_formate($salary_details->date) }}" >
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Month Of
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 month_of" id="month_of"  name="month_of" >
                                                <option value="1" {{ $salary_details->month_of == 1 ? 'selected="selected"' : '' }}>January</option>
                                                <option value="2" {{ $salary_details->month_of == 2 ? 'selected="selected"' : '' }}>February</option>
                                                <option value="3" {{ $salary_details->month_of == 3 ? 'selected="selected"' : '' }}>March</option>
                                                <option value="4" {{ $salary_details->month_of == 4 ? 'selected="selected"' : '' }}>April</option>
                                                <option value="5" {{ $salary_details->month_of == 5 ? 'selected="selected"' : '' }}>May</option>
                                                <option value="6" {{ $salary_details->month_of == 6 ? 'selected="selected"' : '' }}>June</option>
                                                <option value="7" {{ $salary_details->month_of == 7 ? 'selected="selected"' : '' }}>July</option>
                                                <option value="8" {{ $salary_details->month_of == 8 ? 'selected="selected"' : '' }}>August</option>
                                                <option value="9" {{ $salary_details->month_of == 9 ? 'selected="selected"' : '' }}>September</option>
                                                <option value="10" {{ $salary_details->month_of == 10 ? 'selected="selected"' : '' }}>October</option>
                                                <option value="11" {{ $salary_details->month_of == 11 ? 'selected="selected"' : '' }}>November</option>
                                                <option value="12" {{ $salary_details->month_of == 12 ? 'selected="selected"' : '' }}>December</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>year</label>
                                            <select class="form-control select2 year change" id="salaryYearId" name="year">
                                                <option value="">Select Year</option>
                                                @for ($i = 2019; $i <= date('Y'); $i++)
                                                    <option value="{{ $i }}" {{ $i == $salary_details->year ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>amount
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="amount" class="form-control onlyNumber" placeholder="Enter Amount" autocomplete="off" value="{{ numberformat($salary_details->amount)}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>remarks
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="1" name="remarks" id="remarks">{{ $salary_details->remarks}}</textarea>
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
