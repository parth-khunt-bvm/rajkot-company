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
                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(32, explode(',', $permission_array[0]['permission'])) )
                        <button class="btn btn-primary font-weight-bolder mr-5 show-assets-form" id="show-assets-form">+</button>
                    @endif

                    <!--begin::Button-->
                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(32, explode(',', $permission_array[0]['permission'])) )
                        <a href="{{ route('admin.assets.add') }}" class="btn btn-primary font-weight-bolder">
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
                            </span>Add Assets
                         </a>
                    @endif
                    <!--end::Button-->
                </div>


            </div>
            <div class="card-body">
                <form class="form" style="display: none;" id="add-assets-users" method="POST" action="{{ route('admin.assets.save-add-assets') }}" autocomplete="off">@csrf
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Asset Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="asset_type"  class="form-control" placeholder="Enter Asset Type" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Asset Code
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="asset_code"  class="form-control" placeholder="Enter Asset Code" autocomplete="off">
                                </div>
                            </div>

                            <div class="col-md-2 mt-8">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Cancel</button>
                                </div>
                            </div>

                        </div>
                </form>


                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="admin-assets-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Asset Type</th>
                            <th>Asset Code</th>
                            @php
                            $target = [];
                            $target = [97,98];
                            @endphp
                            {{-- @if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 )
                                <th>Action</th>
                            @endif --}}
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
