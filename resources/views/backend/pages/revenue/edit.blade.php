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
                        <form class="form" id="edit-revenue-users" method="POST" action="{{ route('admin.revenue.save-edit-revenue') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <input type="hidden" name="editId"  class="form-control"  value="{{ $revenue_details->id}}">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Manager Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 manager_id" id="manager_id"  name="manager_id">
                                                <option value="">Please select Manager Name</option>
                                                @foreach ($manager  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $revenue_details->manager_id ? 'selected="selected"' : '' }}>{{ $value['manager_name'] }}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Technology Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 technology" id="technology"  name="technology_id">
                                                <option value="">Please select Technology Name</option>
                                                @foreach ($technology  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $revenue_details->technology_id ? 'selected="selected"' : '' }}>{{ $value['technology_name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Enter Date" autocomplete="off" value="{{ $revenue_details->date }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Received Month
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 received_month" id="received_month"  name="received_month" >
                                                <option value="1" {{ $revenue_details->month_of == 1 ? 'selected="selected"' : '' }}>January</option>
                                                <option value="2" {{ $revenue_details->month_of == 2 ? 'selected="selected"' : '' }}>February</option>
                                                <option value="3" {{ $revenue_details->month_of == 3 ? 'selected="selected"' : '' }}>March</option>
                                                <option value="4" {{ $revenue_details->month_of == 4 ? 'selected="selected"' : '' }}>April</option>
                                                <option value="5" {{ $revenue_details->month_of == 5 ? 'selected="selected"' : '' }}>May</option>
                                                <option value="6" {{ $revenue_details->month_of == 6 ? 'selected="selected"' : '' }}>June</option>
                                                <option value="7" {{ $revenue_details->month_of == 7 ? 'selected="selected"' : '' }}>July</option>
                                                <option value="8" {{ $revenue_details->month_of == 8 ? 'selected="selected"' : '' }}>August</option>
                                                <option value="9" {{ $revenue_details->month_of == 9 ? 'selected="selected"' : '' }}>September</option>
                                                <option value="10" {{ $revenue_details->month_of == 10 ? 'selected="selected"' : '' }}>October</option>
                                                <option value="11" {{ $revenue_details->month_of == 11 ? 'selected="selected"' : '' }}>November</option>
                                                <option value="12" {{ $revenue_details->month_of == 12 ? 'selected="selected"' : '' }}>December</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Month Of
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 month_of" id="month_of"  name="month_of" >
                                                <option value="1" {{ $revenue_details->month_of == 1 ? 'selected="selected"' : '' }}>January</option>
                                                <option value="2" {{ $revenue_details->month_of == 2 ? 'selected="selected"' : '' }}>February</option>
                                                <option value="3" {{ $revenue_details->month_of == 3 ? 'selected="selected"' : '' }}>March</option>
                                                <option value="4" {{ $revenue_details->month_of == 4 ? 'selected="selected"' : '' }}>April</option>
                                                <option value="5" {{ $revenue_details->month_of == 5 ? 'selected="selected"' : '' }}>May</option>
                                                <option value="6" {{ $revenue_details->month_of == 6 ? 'selected="selected"' : '' }}>June</option>
                                                <option value="7" {{ $revenue_details->month_of == 7 ? 'selected="selected"' : '' }}>July</option>
                                                <option value="8" {{ $revenue_details->month_of == 8 ? 'selected="selected"' : '' }}>August</option>
                                                <option value="9" {{ $revenue_details->month_of == 9 ? 'selected="selected"' : '' }}>September</option>
                                                <option value="10" {{ $revenue_details->month_of == 10 ? 'selected="selected"' : '' }}>October</option>
                                                <option value="11" {{ $revenue_details->month_of == 11 ? 'selected="selected"' : '' }}>November</option>
                                                <option value="12" {{ $revenue_details->month_of == 12 ? 'selected="selected"' : '' }}>December</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>amount
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="amount" class="form-control onlyNumber" placeholder="Enter Amount" autocomplete="off" value="{{ $revenue_details->amount }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bank Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Enter Bank Name"  value="{{ $revenue_details->bank_name }}" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Holder Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="holder_name" id="holder_name" class="form-control" placeholder="Enter Holder Name"  value="{{ $revenue_details->holder_name }}" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>remarks
                                            </label>
                                            <textarea class="form-control" id="" cols="30" rows="10" name="remarks" id="remarks">{{ $revenue_details->remarks}}</textarea>
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
