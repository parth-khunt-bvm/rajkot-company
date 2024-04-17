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

                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(66, explode(',', $permission_array[0]['permission'])) )


                <div class="expense-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="hr-expense-trash-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Month</th>
                                <th>Amount</th>
                                <th>Remark</th>
                                @php
                                $target = [];
                                $target = [69,70,71];
                                @endphp
                                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 )
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Total:</th>
                                <th></th>
                                <th></th>
                                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || count(array_intersect(explode(",", $permission_array[0]['permission']), $target)) > 0 )
                                    <th></th>
                                @endif
                            </tr>
                        </tfoot>
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
