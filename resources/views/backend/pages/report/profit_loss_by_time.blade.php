@extends('backend.layout.app')
@section('section')

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container-fluid">
        @csrf

        <div class="row">
            <div class="col-lg-12">
                <!--begin::Card-->
                <div class="card card-custom gutter-b">
                    <div class="card-header">
                        <div class="card-title">
                            <h3 class="card-title">{{ $header['title'] }}</h3>
                        </div>
                        <div class="card-toolbar">
                    <button data-toggle="modal" data-target="#importBranch" class="import-manager btn btn-danger font-weight-bolder mr-5 ">Import Branch</button>

                            <select class="form-control select2 month change_report" id="report_time"  name="report_time">
                                <option value="">Select Time</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                                <option value="semiannually">SemiAnnually</option>
                                <option value="annually">annually</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="profit-loss-by-time-reports-chart">
                        <!--begin::Chart-->
                        <div id="profit-loss-by-time" class="d-flex justify-content-center"></div>
                        <!--end::Chart-->
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
