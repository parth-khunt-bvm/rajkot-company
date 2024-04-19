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


                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(48, explode(',', $permission_array[0]['permission'])) )

                <div class="expense-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="admin-expense-trash-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Manager Name</th>
                                <th>Branch Name</th>
                                <th>Type Name</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Remark</th>
                                @php
                                $target = [];
                                $target = [51,52,53];
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
