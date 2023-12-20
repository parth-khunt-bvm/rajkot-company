@extends('backend.layout.app')
@section('section')
@php
    $permission_array = get_users_permission(Auth()->guard('admin')->user()->user_type);
@endphp

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

                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(100, explode(',', $permission_array[0]['permission'])) )
                    <button class="btn btn-primary font-weight-bolder mr-5 show-supplier-form" id="show-supplier-form">+</button>
                    @endif

                    <!--begin::Button-->
                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(100, explode(',', $permission_array[0]['permission'])) )

                    <a href="{{ route('admin.supplier.add') }}" class="btn btn-primary font-weight-bolder">
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
                        </span>Add Supplier
                    </a>
                    @endif
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">
                <form class="form" style="display: none" id="add-supplier" method="POST" action="{{ route('admin.supplier.save-add-supplier') }}" autocomplete="off">@csrf
                    <div class="row">
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Supplier
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Supplier Name" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Shop Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" name="shop_name" id="shop_name" placeholder="Shop Name" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Personal Contact
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control onlyNumber" name="personal_contact" id="personal_contact" placeholder="Supplier Name" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                 <label>Shop Contact
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control onlyNumber" name="shop_contact" id="shop_contact" placeholder="Shop Name" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Address
                                    <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="" cols="30" rows="1" name="address" id="address"></textarea>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Priority
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-control select2 priority" id="priority" name="priority">
                                    <option value="">Please select priority</option>
                                    <option value="0">Low</option>
                                    <option value="1">Normal</option>
                                    <option value="2">High</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Short Name
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control " name="short_name" id="short_name" placeholder="Short Name" autocomplete="off" />
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="radio-inline" style="margin-top:10px">
                                    <label class="radio radio-lg radio-success" >
                                    <input type="radio" name="status" class="radio-btn" value="A" checked="checked"/>
                                    <span></span>Active</label>
                                    <label class="radio radio-lg radio-danger" >
                                    <input type="radio" name="status" class="radio-btn" value="I"/>
                                    <span></span>Inactive</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group mt-8">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary"><a href="{{route('admin.salary.list')}}">Cancel</a></button>
                            </div>
                        </div>
                    </div>
                </form>
                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(99, explode(',', $permission_array[0]['permission'])) )

                {{-- <div class="row revenue-filter" style="display: none">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Technology Name</label>
                                    <select class="form-control select2 technology change" id="technology_id"  name="technology_id">
                                        <option value="">Please select Technology Name</option>
                                        @foreach ($technology  as $key => $value )
                                            <option value="{{ $value['id'] }}">{{ $value['technology_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Received Month</label>
                                    <select class="form-control select2 month change" id="received_month"  name="received_month">
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
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Month Of</label>
                                    <select class="form-control select2 month change" id="month_of"  name="month_of">
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
                                    <select class="form-control select2 year change" id="revenueYearId"  name="year">
                                        <option value="">Select Year</option>
                                        @for ($i = 2019; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-5">
                                <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                            </div>
                        </div>
                    </div>

                </div> --}}
                <div class="Supplier-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="admin-supplier-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Supplier Name</th>
                                <th>Shop Name</th>
                                <th>Shop Contact</th>
                                <th>Personal Contact </th>
                                <th>Priority </th>
                                <th>Short Name </th>
                                <th>Status</th>
                                @php
                                $target = [];
                                $target = [101,102,103,104];
                                @endphp
                                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 )
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>
                @endif


            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
