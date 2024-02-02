@extends('backend.employee.layout.app')
@section('section')

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
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="employee-overtime-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Employee name</th>
                                <th>Hours </th>
                                <th>Note</th>
                                <th>Action</th>
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
