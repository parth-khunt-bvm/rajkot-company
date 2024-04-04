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
                     <form class="form" id="edit-emp-overtime" method="POST" action="{{ route('admin.emp-overtime.save-edit-emp-overtime') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Date <span class="text-danger">*</span> </label>
                                        <input type="hidden" name="id" value="{{$emp_overtime_details['id']  }}">
                                        <input type="text" name="date" id="datepicker_date" value="{{ date_formate($emp_overtime_details->date)  }}" class="form-control date" placeholder="Select Date" value="" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 employee" id="overtimeEmployeeId"  name="employee">
                                            <option value="">Please select Employee Name</option>
                                            @foreach ($employee  as $key => $value )
                                                <option value="{{ $value['id'] }}" {{ $value['id'] == $emp_overtime_details->employee_id ? 'selected="selected"' : '' }}>{{ $value['first_name']. ' '. $value['last_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>	Hours
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="hours" id="hours" value="{{ numberformat( $emp_overtime_details->hours, 0)  }}" class="form-control onlyNumber" placeholder="Enter Hours" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Note
                                        </label>
                                        <textarea class="form-control" id="" cols="30" rows="1" name="note" id="note" placeholder="Enter your note">{{ $emp_overtime_details->note }}</textarea>
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
