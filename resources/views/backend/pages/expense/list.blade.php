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
                </div>

                <div class="card-toolbar">
                    <button data-toggle="modal" data-target="#importExpense" class="import-expense btn btn-danger font-weight-bolder mr-5 ">Import Expense</button>
                    <!--begin::Button-->
                    <a href="{{ route('admin.expense.add') }}" class="btn btn-primary font-weight-bolder">
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
                    </span>Add Expense</a>
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">

                <form class="form" id="add-expense-users" method="POST" action="{{ route('admin.expense.save-add-expense') }}" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Manager Name
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 manager_id" id="manager_id" name="manager_id">
                                    <option value="">Please select Manager Name</option>
                                    @foreach ($manager  as $key => $value )
                                    <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Branch Name
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 branch" id="branch" name="branch_id">
                                    <option value="">Please select Branch Name</option>
                                    @foreach ($branch  as $key => $value )
                                    <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Type Name
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 type" id="type" name="type_id">
                                    <option value="">Please select Type Name</option>
                                    @foreach ($type  as $key => $value )
                                    <option value="{{ $value['id'] }}">{{ $value['type_name'] }}</option>
                                    @endforeach
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
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Month
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 month" id="month" name="month" disabled="disabled">
                                    <option value="">Month of salary</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Amount
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="amount" class="form-control" placeholder="Enter Amount" autocomplete="off">
                            </div>
                        </div>

                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Remarks</label>
                                <textarea class="form-control" id="remarks" cols="5" rows="1" name="remarks"></textarea>
                            </div>
                        </div>
                        <div class="col-md-2 mt-7">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a href="{{route('admin.expense.list')}}">Cancel</a></button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Manager Name</label>
                                    <select class="form-control select2 manager_id change" id="manager_id"  name="manager_id">
                                        <option value="">Please select Manager Name</option>
                                        @foreach ($manager  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch Name</label>
                                    <select class="form-control select2 branch change" id="branch_id"  name="branch_id">
                                        <option value="">Please select Branch Name</option>
                                        @foreach ($branch  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type Name</label>
                                    <select class="form-control select2 type change" id="type_id"  name="type_id">
                                        <option value="">Please select type Name</option>
                                        @foreach ($type  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['type_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Month</label>
                                    <select class="form-control select2 month change" id="month"  name="month">
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
                        </div>
                    </div>
                    <div class="col-md-2 mt-5">
                        <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                    </div>
                </div>
                <div class="expense-list">
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="admin-expense-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Manager Name</th>
                            <th>Branch Name</th>
                            <th>Type Name</th>
                            <th>Date</th>
                            <th>Month</th>
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
