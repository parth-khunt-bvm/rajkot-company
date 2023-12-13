@extends('backend.layout.app')
@section('section')

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        @csrf
        <!--begin::Card-->
        <div class="card card-custom gutter-b">
            <div class="card-header flex-wrap py-3">
                <div class="card-title">
                    <h3 class="card-label">{{ $header['title'] }}</h3>
                    <span class="svg-icon svg-icon-primary svg-icon-2x show-hr-income-filter" id="show-hr-income-filter"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                </div>

                <div class="card-toolbar">
                    <button class="btn btn-primary font-weight-bolder mr-5 show-hr-income-form" id="show-hr-income-form">+</button>
                    <button data-toggle="modal" data-target="#importHrExpense" class="import-hr-expense btn btn-danger font-weight-bolder mr-5 ">Import Hr Income</button>
                    <a href="{{ route('admin.hr.income.add') }}" class="btn btn-primary font-weight-bolder">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>Add Hr Income</a>
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">
                <form class="form" style="display: none" id="add-hr-income" method="POST" action="{{ route('admin.hr.income.save-add-income') }}" autocomplete="off">@csrf
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Manager
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
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Payment Mode
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-control select2 payment_mode" id="payment_mode" name="payment_mode">
                                <option value="">Please select Payment Mode</option>
                                <option value="1">Cash </option>
                                <option value="2">Bank Transfer</option>
                            </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Date
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Enter Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Received Month
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 received_month" id="received_month"  name="received_month">
                                    <option value="">Received Month</option>
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Month Of
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 month_of" id="month_of"  name="month_of" disabled="disabled">
                                    <option value="">Month of salary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>year
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 year change" id="yearId"  name="year">
                                    <option value="">Select Year</option>
                                    @for ($i = 2019; $i <= date('Y'); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>amount
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="amount" class="form-control onlyNumber" placeholder="Enter Amount" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" id="remarks" cols="5" rows="1" name="remarks"></textarea>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="form-group mt-8">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a href="{{route('admin.revenue.list')}}">Cancel</a></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row hr-income-filter" style="display: none">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Manager Name</label>
                                    <select class="form-control select2 manager_id change" id="hr_manager_id"  name="manager_id">
                                        <option value="">Please select Manager Name</option>
                                        @foreach ($manager  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Month Of</label>
                                    <select class="form-control select2 month change" id="hr_month_of"  name="month_of">
                                        <option value="">Select Month</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>year</label>
                                    <select class="form-control select2 year change" id="hrIncomeYearId"  name="year">
                                        <option value="">Select Year</option>
                                        @for ($i = 2019; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-2 mt-5">
                                <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="income-list">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="hr-income-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Manager Name</th>
                            <th>Payment Mode</th>
                            <th>Salary Month</th>
                            <th>Amount</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>

            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
