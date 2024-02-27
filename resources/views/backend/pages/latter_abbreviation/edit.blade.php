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

                     <form class="form" id="edit-latter-abbreviations" method="POST" action="{{ route('latter-abbreviations.update', $latter_abbreviations_details->id) }}">@csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Key
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="hidden" name="editId" value="{{ $latter_abbreviations_details->id}}">
                                        <input type="text" name="key" class="form-control" placeholder="Enter key name" autocomplete="off" value="{{ $latter_abbreviations_details->key}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Value
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="value" class="form-control" placeholder="Enter value" autocomplete="off" value="{{ $latter_abbreviations_details->value}}">
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
