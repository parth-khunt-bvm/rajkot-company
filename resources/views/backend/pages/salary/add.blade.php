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
                        <form class="form" id="add-salary" method="POST" action="{{ route('admin.salary.save-add-salary') }}" autocomplete="off">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Manager Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 manager_id" id="manager_id"  name="manager_id">
                                                <option value="">Please select Manager Name</option>
                                                @if (is_array($manager) || is_object($manager))
                                                    @foreach ($manager  as $key => $value )
                                                        <option value="{{ $value['id'] }}">{{ $value['manager_name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Branch Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 manager_id" id="branch_id"  name="branch_id">
                                                <option value="">Please select Branch Name</option>
                                                @if (is_array($branch) || is_object($branch))
                                                    @foreach ($branch  as $key => $value )
                                                        <option value="{{ $value['id'] }}">{{ $value['branch_name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Technology Name
                                                <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control select2 manager_id" id="technology_id"  name="technology_id">
                                                <option value="">Please select Technology Name</option>
                                                @if (is_array($technology) || is_object($technology))
                                                    @foreach ($technology  as $key => $value )
                                                        <option value="{{ $value['id'] }}">{{ $value['technology_name'] }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="date" name="date" class="form-control" placeholder="Enter Date" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Month Of
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="month" name="month_of" class="form-control" placeholder="Enter Month Of" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>amount
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>remarks
                                                <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="remarks" class="form-control" placeholder="Enter remarks" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status <span class="text-danger">*</span></label>
                                            <div class="radio-inline" style="margin-top:10px">
                                                <label class="radio radio-lg radio-success" >
                                                    <input type="radio" name="status" class="radio-btn" value="A" checked="checked"/>
                                                    <span></span>Active</label>
                                                <label class="radio radio-lg radio-danger" >
                                                    <input type="radio" name="status" class="radio-btn" value="I"/>
                                                    <span></span>Inactive</label>
                                            </div>
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
