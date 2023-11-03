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
                    </div>
                    {{-- <div class="row ml-5 mt-5">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Branch Name</label>
                                        <select class="form-control select2 branch change" id="branch_id"  name="branch_id">
                                            <option value="">Please select Branch Name</option>
                                            @foreach ($branch  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Technology Name</label>
                                        <select class="form-control select2 type change" id="technology_id"  name="technology_id">
                                            <option value="">Please select type Name</option>
                                            @foreach ($technology  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['technology_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Month of</label>
                                        <select class="form-control select2 month change" id="month_of"  name="month_of">
                                            <option value="">Select Month</option>
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mt-5">
                                    <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                                </div>
                            </div>
                        </div>

                    </div> --}}
                    <div class="card-body">
                        <div class="profit-loss-by-time-reports-chart">
                        <!--begin::Chart-->
                        <div id="profit-loss-by-time"></div>
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
