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
                <!--begin: Datatable-->
                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(132, explode(',', $permission_array[0]['permission'])) )
                <table class="table table-bordered table-checkable" id="admin-leave-request-list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Employee Name</th>
                            <th>Manager</th>
                            <th>Leave Type</th>
                            <th>Leave Status</th>
                            <th>Leave Reason</th>
                            <th>Approved By</th>
                            <th>Rejected Reason</th>
                            <th>Approved Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                @endif
                <!--end: Datatable-->
            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
