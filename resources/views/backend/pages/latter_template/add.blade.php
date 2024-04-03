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
                    <form class="form" id="add-latter-template" method="POST" action="{{ route('latter-templates.store') }}">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Template Name
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="template_name" id="template_name" class="form-control" placeholder="Enter Template Name" autocomplete="off" >
                                    </div>
                                </div>

                                <div class="col-md-3">
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
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Template
                                        </label>
                                        {{-- <textarea class="form-control" id="" cols="30" rows="10" name="template" id="remarks"></textarea> --}}
                                        {{-- <textarea name="kt-ckeditor-1" id="kt-ckeditor-1"> --}}
                                        <textarea name="template" id="template" autocomplete="off">
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                               <a data-toggle="modal" data-target="#latter-abbreviation-view" class="latter-abbreviation-view btn btn-success font-weight-bolder mr-5 ">view</a>
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

<!-- view Latter Abbreviation Model-->
<div class="modal fade" id="latter-abbreviation-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Latter Abbreviation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($latter_abbreviations as $latter_abbreviation)
                <ul>
                    {{-- <li> <strong> key:</strong> {{$latter_abbreviation->key}}  => <strong> value:</strong> {{$latter_abbreviation->value}}</li> --}}
                    <li> <strong> {{$latter_abbreviation->key}}</strong> => {{$latter_abbreviation->value}}</li>
                </ul>
                @endforeach
            </div>
        </div>
    </div>
</div

@endsection
