@extends('backend.layout.app')
@section('section')
    <!--begin::Entry-->
    <div class="d-flex flex-column-fluid">
        <!--begin::Container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Card-->
                    <div class="card card-custom gutter-b example example-compact">
                        <div class="card-header">
                            <h3 class="card-title">{{ $header['title'] }}</h3>
                        </div>
                        @php
                        $monthNumber = $expense_details['month'];
                        $monthName = date('F', strtotime("2023-$monthNumber-01"));
                        @endphp
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Manager Name</b> <br>
                                 {{ $expense_details->manager_name }}
                            </div>
                            <div class="col-3">
                                <b>Branch Name</b> <br>
                                 {{ $expense_details->branch_name }}
                            </div>
                            <div class="col-3">
                                <b>Type Name</b> <br>
                                 {{ $expense_details->type_name }}
                            </div>
                            <div class="col-3">
                                <b>Date</b> <br>
                                 {{ $expense_details->date }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Month Of</b> <br>
                                 {{ $monthName }}
                            </div>
                            <div class="col-3">
                                <b>Year</b> <br>
                                {{ $expense_details->year}}
                            </div>
                            <div class="col-3">
                                <b>Amount</b> <br>
                                 {{ $expense_details->amount }}
                            </div>
                            <div class="col-3">
                                <b>Remarks</b> <br>
                                 {{ $expense_details->remarks }}
                            </div>

                        </div>
                    </div>
                    <!--end::Card-->
                </div>
            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
