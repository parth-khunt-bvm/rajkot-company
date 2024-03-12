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
                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(149, explode(',', $permission_array[0]['permission'])) )
                <!--begin: Datatable-->
                <table class="table table-bordered table-checkable" id="change-request-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee Name</th>
                            <th>Branch</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Request Type</th>
                            @php
                            $target = [];
                            $target = [149,150];
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
                @endif

            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
