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
                        $monthNumber = $counter_detail['month'];
                        $monthName = date('F', strtotime("2023-$monthNumber-01"));
                        @endphp
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Month</b> <br>
                                 {{ $monthName }}
                            </div>
                            <div class="col-3">
                                <b>Year</b> <br>
                                 {{ $counter_detail->year }}
                            </div>
                            <div class="col-3">
                                <b>employee Name</b> <br>
                                 {{ $counter_detail->first_name }}
                            </div>
                            <div class="col-3">
                                <b>Technology Name</b> <br>
                                 {{ $counter_detail->technology_name }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Present Day</b> <br>
                                {{ numberformat( $counter_detail->present_days, 0)  }}
                            </div>
                            <div class="col-3">
                                <b>Half Leaves</b> <br>
                                 {{ $counter_detail->half_leaves }}
                            </div>
                            <div class="col-3">
                                <b>Full Leaves</b> <br>
                                 {{ $counter_detail->full_leaves }}
                            </div>
                            <div class="col-3">
                                <b>Paid Leave Detail</b> <br>
                                 {{ $counter_detail->paid_leaves_details }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Total Days</b> <br>
                                {{ numberformat( $counter_detail->total_days, 0)  }}
                            </div>
                            <div class="col-3">
                                <b>Salary Counted</b> <br>
                                 {{ $counter_detail->salary_counted }}
                            </div>
                            <div class="col-3">
                                <b>Paid Date</b> <br>
                                 {{date_formate($counter_detail->paid_date)}}
                            </div>
                            <div class="col-3">
                                <b>Salary Status</b> <br>
                                 {{ $counter_detail->salary_status ?? '-'}}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Note</b> <br>
                                 {{ $counter_detail->note ?? '-'}}
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
