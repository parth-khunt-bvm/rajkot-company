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
                            <span class="svg-icon svg-icon-primary svg-icon-2x show-expense-filter" id="show-expense-filter"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\Text\Filter.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"/>
                                    <path d="M5,4 L19,4 C19.2761424,4 19.5,4.22385763 19.5,4.5 C19.5,4.60818511 19.4649111,4.71345191 19.4,4.8 L14,12 L14,20.190983 C14,20.4671254 13.7761424,20.690983 13.5,20.690983 C13.4223775,20.690983 13.3458209,20.6729105 13.2763932,20.6381966 L10,19 L10,12 L4.6,4.8 C4.43431458,4.5790861 4.4790861,4.26568542 4.7,4.1 C4.78654809,4.03508894 4.89181489,4 5,4 Z" fill="#000000"/>
                                </g>
                            </svg><!--end::Svg Icon--></span>
                        </div>
                    </div>

                    <div class="row ml-5 mt-5 expense-filter" style="display: none">
                        <div class="col-md-5">
                            <div class="row ">
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
                                        <label>Type Name</label>
                                        <select class="form-control select2 type change" id="type_id"  name="type_id">
                                            <option value="">Please select type Name</option>
                                            @foreach ($type  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['type_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>year</label>
                                        <select class="form-control select2 year change" id="expense_year_id"  name="year">
                                            <option value="">Select Year</option>
                                            @for ($i = 2019; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}" {{ $i == date('Y') ? 'selected="selected"' : '' }}>{{ $i }}</option>
                                        @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="dropdown dropdown-inline">
                                    <label>select Time</label>
                                    <select class="form-control select2 month change_report change" id="expense_report_time" name="report_time">
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="semiannually">SemiAnnually</option>
                                        <option value="annually">annually</option>
                                    </select>
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
