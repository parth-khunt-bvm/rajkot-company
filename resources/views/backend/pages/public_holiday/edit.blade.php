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
                     <form class="form" id="edit-public-holiday" method="POST" action="{{ route('admin.public-holiday.save-edit-public-holiday') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                         <label>Date  <span class="text-danger">*</span></label>
                                        <input type="hidden"  class="form-control" name="public_holiday_Id" value="{{ $public_holiday_details->id}}">
                                         <input type="text" name="date" id="datepicker_date" class="form-control date" value="{{date_formate($public_holiday_details->date) }}" placeholder="Select Date" value="" autocomplete="off">
                                     </div>
                                 </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Public Holiday name <span class="text-danger">*</span></label>
                                        <input type="text" name="public_holiday_name" class="form-control" value="{{ $public_holiday_details->holiday_name }}" placeholder="Enter public holiday name" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Note
                                        </label>
                                        <textarea class="form-control" id="" cols="30" rows="1" name="note" id="note">{{ $public_holiday_details->note }}</textarea>
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
