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
                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(116, explode(',', $permission_array[0]['permission'])) )
                    <span class="svg-icon svg-icon-primary svg-icon-2x show-asset-allocation-filter" id="show-asset-allocation-filter"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/>
                        </g>
                    </svg><!--end::Svg Icon--></span>
                    @endif
                </div>

                <div class="card-toolbar">
                    <!--begin::Button-->

                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(117, explode(',', $permission_array[0]['permission'])) )
                        <a href="{{ route('admin.asset-allocation.add') }}" class="btn btn-primary font-weight-bolder">
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
                            </span>Add Asset Allocation
                         </a>
                   @endif

                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">
                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(116, explode(',', $permission_array[0]['permission'])) )
                <div class="row asset-allocation-filter" style="display: none">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <select class="form-control select2 technology change" id="fil_employee_id"  name="employee_id">
                                        <option value="">Please select Employee Name</option>
                                        @foreach ($employee  as $key => $value )
                                        <option value="{{ $value['id'] }}">{{ $value['first_name'] . " " . $value['last_name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supplier Name</label>
                                    <select class="form-control select2 supplier change" id="fil_supplier_id"  name="supplier_id">
                                        <option value="">Please select Suppier Name</option>
                                        @foreach ($suppier  as $key => $value )
                                        <option value="{{ $value['id'] }}">{{ $value['suppiler_name'].' - '.$value['supplier_shop_name'] }}</option>
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
                                    <label>Brand Name</label>
                                    <select class="form-control select2 brand change" id="fil_brand_id"  name="brand_id">
                                        <option value="">Please select Suppier Name</option>
                                        @foreach ($brand  as $key => $value )
                                        <option value="{{ $value['id'] }}">{{ $value['brand_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Asset Name</label>
                                    <select class="form-control select2 technology change" id="fil_asset_id"  name="asset_id">
                                        <option value="">Please select Asset Type</option>
                                        @foreach ($asset  as $key => $value )
                                        <option value="{{ $value['id'] }}">{{ $value['asset_type'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-2 mt-5">
                        <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                    </div>
                </div>
                <!--begin: Datatable-->
                <div class="asset-allocation-list-div">
                    <table class="table table-bordered table-checkable" id="asset-allocation-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Employee Name</th>
                                <th>Supplier Name</th>
                                <th>Brand</th>
                                <th>Asset</th>
                                <th>Asset Code</th>
                                @php
                                $target = [];
                                $target = [118, 119];
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
