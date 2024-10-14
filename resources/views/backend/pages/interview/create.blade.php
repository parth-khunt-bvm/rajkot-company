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
                        <!--begin::Form-->
                        <form class="form" id="add-hr-expense" method="POST" action="{{ route('admin.hr.expense.save-add-expense') }}" autocomplete="off">@csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="date" id="date" class="form-control date datepicker_date" placeholder="Enter Date" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Branch Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 branch input-name" id="branch"
                                                name="branch">
                                                <option value="">Please select Branch Name</option>
                                                @foreach (user_branch() as $key => $value)
                                                    <option value="{{ $value['id'] }}"
                                                        {{ $_COOKIE['branch'] == $value['id'] ? 'selected="selected"' : '' }}>
                                                        {{ $value['branch_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Technology Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 technology input-name"
                                                id="technology" name="technology">
                                                <option value="">Please select Technology Name</option>
                                                @foreach ($technology as $key => $value)
                                                    <option value="{{ $value['id'] }}">
                                                        {{ $value['technology_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="form-group">
                                            <label>Designation Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 designation input-name"
                                                id="designation" name="designation">
                                                <option value="">Please select Designation Name</option>
                                                @foreach ($designation as $key => $value)
                                                    <option value="{{ $value['id'] }}">
                                                        {{ $value['designation_name'] }}</option>
                                                @endforeach
                                            </select>
                                            <span class="type_error text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary mr-2 submitbtn green-btn">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Card-->

                </div>

            </div>
        </div>
        <!--end::Container-->
    </div>
    <!--end::Entry-->
@endsection
