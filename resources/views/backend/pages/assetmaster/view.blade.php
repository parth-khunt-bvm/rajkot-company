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
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Supplier</b> <br>
                                 {{ $monthName }}
                            </div>
                            <div class="col-3">
                                <b>Asset</b> <br>
                                 {{ $asset_master_details->year }}
                            </div>
                            <div class="col-3">
                                <b>Brand</b> <br>
                                 {{ $asset_master_details->first_name }}
                            </div>
                            <div class="col-3">
                                <b>Branch</b> <br>
                                 {{ $asset_master_details->technology_name }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 mb-5 ml-5" >
                            <div class="col-3">
                                <b>Present Day</b> <br>
                                {{ numberformat( $asset_master_details->present_days, 0)  }}
                            </div>
                            <div class="col-3">
                                <b>Half Leaves</b> <br>
                                 {{ $asset_master_details->half_leaves }}
                            </div>
                            <div class="col-3">
                                <b>Full Leaves</b> <br>
                                 {{ $asset_master_details->full_leaves }}
                            </div>
                            <div class="col-3">
                                <b>Paid Leave Detail</b> <br>
                                 {{ $asset_master_details->paid_leaves_details }}
                            </div>
                        </div>

                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Total Days</b> <br>
                                {{ numberformat( $asset_master_details->total_days, 0)  }}
                            </div>
                            <div class="col-3">
                                <b>Salary Counted</b> <br>
                                 {{ $asset_master_details->salary_counted }}
                            </div>
                            <div class="col-3">
                                <b>Paid Date</b> <br>
                                 {{ $asset_master_details->paid_date }}
                            </div>
                            <div class="col-3">
                                <b>Salary Status</b> <br>
                                 {{ $asset_master_details->salary_status }}
                            </div>
                        </div>
                        <div class="row mt-5 mr-5 ml-5" >
                            <div class="col-3">
                                <b>Note</b> <br>
                                 {{ $asset_master_details->note }}
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
