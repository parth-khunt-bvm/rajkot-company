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

                    <div class="row ml-5 mt-5">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Manager Name</label>
                                        <select class="form-control select2 manager_id change" id="manager_id"  name="manager_id">
                                            <option value="">Please select Manager Name</option>
                                            @foreach ($manager  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Type Name</label>
                                        <select class="form-control select2 type change" id="type_id"  name="type_id">
                                            <option value="">Please select type Name</option>
                                            @foreach ($type  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['type_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date:</label>
                                        <input type="text" class="form-control datepicker_date change" id="start_date" name="start_date">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date:</label>
                                        <input type="text" class="form-control datepicker_date change" id="end_date" name="end_date">
                                    </div>
                                </div>
                                <div class="col-md-2 mt-5">
                                    <button type="reset" class="btn btn-primary mt-2 reset">Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="expense-reports-chart">
                        <!--begin::Chart-->
                        <div id="expense-reports"></div>
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
