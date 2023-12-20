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

                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(99, explode(',', $permission_array[0]['permission'])) )
                    <span class="svg-icon svg-icon-primary svg-icon-2x show-supplier-filter" id="show-supplier-filter"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                    @endif

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
                                    <option value="1">Medium</option>
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
                <div class="row supplier-filter" style="display: none">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Priority</label>
                                    <select class="form-control select2 supplier-filter" id="priorityId" name="priority">
                                        <option value="">Please select priority</option>
                                        <option value="0">Low</option>
                                        <option value="1">Medium</option>
                                        <option value="2">High</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>status</label>
                                    <select class="form-control select2 supplier_status supplier-filter" id="statusId"  name="supplier_status">
                                        <option value="">Please select user status</option>
                                            <option value="1">Active</option>
                                            <option value="2">Deactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2 mt-5">
                                <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="supplier-list">
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
