@extends('backend.layout.app')
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

                        {{-- <div class="form-group row">
                            <label class="mt-5">
                                Date
                                <span class="text-danger">*</span>
                            </label>
                            <div class="col-10 mt-3">
                                <input type="text" name="date" id="datepicker_date_fill" class="form-control change_date datepicker_date" value="03-May-2024" placeholder="Enter Date" autocomplete="off">
                            </div>
                        </div> --}}

                </div>
            </div>
            <div class="card-body">

                <div class="attendance-list">
                    <!--begin: Datatable-->
                    <table class="table table-bordered table-checkable" id="attendance-list">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Attendance Type</th>
                                <th>Minutes</th>
                                <th>reason</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <!--end: Datatable-->
                </div>

            </div>
        </div>
        <!--end::Card-->
    </div>
    <!--end::Container-->
</div>
<!--end::Entry-->

@endsection
