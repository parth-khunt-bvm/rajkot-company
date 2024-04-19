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
                    <!--end::Button-->
                </div>

            </div>
            <div class="card-body">

                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(54, explode(',', $permission_array[0]['permission'])) )


                <div class="revenue-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="admin-revenue-trash-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Manager Name</th>
                                <th>Technology Name</th>
                                <th>Received Month  </th>
                                <th>Month_Of</th>
                                <th>Amount</th>
                                <th>Bank Holder Name</th>
                                <th>Remark</th>
                                @php
                                $target = [];
                                $target = [57,58,59];
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
