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
                @if(Auth()->guard('admin')->user()->is_admin == 'Y' || in_array(72, explode(',', $permission_array[0]['permission'])) )

                <div class="employee-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="employee-trash-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Branch</th>
                                <th>Date of Joining</th>
                                <th>Experience</th>
                                <th>Googal pay</th>
                                <th>Status</th>
                                @php
                                $target = [];
                                $target = [75, 76, 77, 78, 79, 80];
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
