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
                    <!--begin::Button-->
                    <!--end::Button-->
                </div>

            </div>
                <div class="card-body">

                    @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(111, explode(',', $permission_array[0]['permission'])) )
                    <div class="asset-master-list">
                        <!--begin: Datatable-->
                        <table class="table table-bordered table-checkable" id="admin-asset-master-trash-list">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Asset Code</th>
                                    <th>Suplier Name</th>
                                    <th>Asset Name</th>
                                    <th>Branch Name</th>
                                    <th>Brand Name</th>
                                    <th>Price</th>
                                    <th>status</th>
                                    <th>Description</th>
                                    @php
                                        $target = [];
                                        $target = [113 ,114 ,115];
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
