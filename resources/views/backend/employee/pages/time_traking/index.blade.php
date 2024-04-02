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

                {{-- <section id="stopWatch">
                <p id="timer">00:00:00</p>
                <button id="start">Start</button>
                <button id="stop">Stop</button>
                <p id="fulltime" class="fulltime"> </p>
                </section> --}}

        <!--begin: Datatable-->
        <table class="table table-bordered table-checkable" id="employee-tracker-list">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>In Time</th>
                    <th>Out Time</th>
                    <th>Working Time</th>
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






