@extends('backend.layout.app')
@section('section')

@php
     $image = url('upload/userprofile/default.jpg');
@endphp

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
                     <form class="form" id="add-document" method="POST" action="{{ route('admin.document.save-add-document') }}" enctype="multipart/form-data">@csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Employee Name
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 employee_id" id="employee_id"  name="employee_id">
                                            <option value="">Please select Employee Name</option>
                                            @foreach ($employee  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['first_name'] .' '. $value['last_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Document Type
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control select2 document_type_id" id="document_type_id"  name="document_type_id">
                                            <option value="">Please select Document Type</option>
                                            @foreach ($document_type  as $key => $value )
                                                <option value="{{ $value['id'] }}">{{ $value['document_name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
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
                                <div id="attachment_fields_container" class="row">
                                    <!-- Attachment fields will be appended here -->
                                </div>
                                @php
                                    $count = 2;
                                @endphp
                                @for ($i = 0; $i < $count; $i++)
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Attachment {{ $i + 1 }}</label>
                                        <div>
                                            <div class="image-input image-input-outline" id="kt_image_{{ $i + 1 }}">
                                                <div class="image-input-wrapper"></div>
                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="Change Attachment {{ $i + 1 }}">
                                                    <i class="fa fa-pencil icon-sm text-muted"></i>
                                                    <input type="file" name="attachment[]" accept=".png, .jpg, .jpeg"/>
                                                    <input type="hidden" name="profile_avatar_remove"/>
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Attachment {{ $i + 1 }}">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg, jpeg. (Max Size For Upload 2MB)</span>
                                        </div>
                                    </div>
                                </div>
                                @endfor


                                {{-- <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Attachement</label>
                                        <div class="">
                                            <div class="image-input image-input-outline" id="kt_image_1">
                                                <div class="image-input-wrapper" style="background-image: url({{ $image }})"></div>

                                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change Attachement 1">
                                                    <i class="fa fa-pencil  icon-sm text-muted"></i>
                                                    <input type="file" name="attachement" id="attachement" accept=".png, .jpg, .jpeg" />
                                                    <input type="hidden" name="profile_avatar_remove" />
                                                </label>
                                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel Attachement 1">
                                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                                </span>
                                            </div>
                                            <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.<br>(Max Size For Upload 2MB)</span>
                                            <span class="attachement_1_error text-danger"></span>
                                        </div>
                                    </div>
                                </div> --}}

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
