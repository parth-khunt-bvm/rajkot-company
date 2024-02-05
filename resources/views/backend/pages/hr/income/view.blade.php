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
                        $monthNumber = $hr_income_details['month_of'];
                        $monthName = date('F', strtotime("2023-$monthNumber-01"));
                        $monthNum = $hr_income_details['received_month'];
                        $receivedMonth = date('F', strtotime("2023-$monthNum-01"));
                        @endphp
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Manager Name</b> <br>
                                 {{ $hr_income_details->manager_name }}
                            </div>
                            <div class="col-3">
                                <b>Payment Mode</b> <br>
                                 @if ($hr_income_details->payment_mode == 1)
                                        Cash
                                 @else
                                        Bank Transfer
                                 @endif
                            </div>
                            <div class="col-3">
                                <b>Date</b> <br>
                                 {{date_formate($hr_income_details->date)}}
                            </div>
                            <div class="col-3">
                                <b>Month Of</b> <br>
                                 {{ $monthName }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Received Month</b> <br>
                                 {{ $receivedMonth }}
                            </div>
                            <div class="col-3">
                                <b>Amount</b> <br>
                                 {{ numberformat($hr_income_details->amount) }}
                            </div>
                            <div class="col-3">
                                <b>Remarks</b> <br>
                                 {{ $hr_income_details->remarks }}
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
