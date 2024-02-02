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
                     <form class="form" id="add-emp-overtime" method="POST" action="{{ route('admin.emp-overtime.save-add-emp-overtime') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="date" id="datepicker_date" class="form-control date" placeholder="Select Date" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Employee Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 employee" id="employee"  name="employee">
                                            <option value="">Please select Employee Name</option>
                                            @foreach ($employee  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['first_name']. ' '. $value['last_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>	Hours
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="hours" id="hours" class="form-control onlyNumber" placeholder="Enter Hours" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Note
                                        </label>
                                        <textarea class="form-control" id="" cols="30" rows="10" name="note" id="note" placeholder="Enter your note"></textarea>
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
